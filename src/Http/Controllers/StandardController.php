<?php

namespace Srikanth\Instamojo\Http\Controllers;

use Illuminate\Http\Request;
use Srikanth\Instamojo\Helpers\Ipn;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

/**
 * Paypal Standard controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class StandardController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * Ipn object
     *
     * @var array
     */
    protected $ipnHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        Ipn $ipnHelper
    )
    {
        $this->orderRepository = $orderRepository;

        $this->ipnHelper = $ipnHelper;
    }

    /**
     * Redirects to the paypal.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('instamojo::standard-redirect');
    }


    public function postdata(Request $request)
    {
         $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );

        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => "FIFA 16",
                "amount" => $request->amount,
                "buyer_name" => "$request->name",
                "send_email" => true,
                "email" => "$request->email",
                "phone" => "$request->mobile_number",
                "redirect_url" => url('instamojo/standard/success')
                ));
                 
                header('Location: ' . $response['longurl']);
                exit();
        }catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }
    }

    /**
     * Cancel payment from paypal.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', 'Paypal payment has been canceled.');

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
    }

    /**
     * Paypal Ipn listener
     *
     * @return \Illuminate\Http\Response
     */
    public function ipn()
    {
        $this->ipnHelper->processIpn(request()->all());
    }
}