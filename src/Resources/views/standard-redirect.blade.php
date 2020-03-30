<?php $instamojoStandard = app('Srikanth\Instamojo\Payment\Standard') ?>

<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    Srikanth You will be redirected to the PayPal website in a few seconds.

    <form action="{{ $instamojoStandard->getPaypalUrl() }}" id="instamojo_standard_checkout" method="POST">
        {!!csrf_field()!!}
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">

        @foreach ($instamojoStandard->getFormFields() as $name => $value)
            @if(($name == "amount") || ($name == "tax") || ($name == "discount_amount") || ($name == "amount_1") || ($name == "amount_2") || ($name == "amount_3") )
                <?php $value = round($value,2); ?>
            @else

            @endif
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">

        @endforeach
    </form>

    <script type="text/javascript">
        document.getElementById("instamojo_standard_checkout").submit();
    </script>
</body>