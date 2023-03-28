<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width">
    <!-- Title -->
    <title>@yield('title')</title>
   
    <!-- Font -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/google-fonts.css">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/theme.minc619.css?v=1.0">
    <!-- select picker -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/bootstrap-select.min.css"/>
    @stack('css_or_js')
    <link rel="icon" type="image/x-icon" href="{{asset('public/assets/admin/img/160x160/img1.jpg')}}">


    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/custom.css"/>

    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>

<body class="footer-offset">

{{--loader--}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="d-none">
                <div class="loader-img">
                    <img width="200" src="{{asset('public/assets/admin/img/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>
{{--loader--}}

<!-- JS Preview mode only -->
@include('layouts.admin.partials._header')
@include('layouts.admin.partials._sidebar')
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
@yield('content')
<!-- End Content -->

    <!-- Footer -->
@include('layouts.admin.partials._footer')
<!-- End Footer -->

    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <center>
                                <h2 class="title-new-order">
                                    <i class="tio-shopping-cart-outlined"></i> {{\App\CPU\translate('You_have_new_order,_Check_Please')}}.
                                </h2>
                                <hr>
                                <button onclick="check_order()" class="btn btn-primary">{{\App\CPU\translate('Ok,_let_me_check')}}</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="{{asset('public/assets/admin')}}/js/custom.js"></script>
<!-- JS Implementing Plugins -->

@stack('script')

<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
<!-- select picker -->
<script src="{{asset('public/assets/admin')}}/js/bootstrap-select.min.js"></script>
<!-- ck editor -->
<script src="{{asset('public/assets/admin')}}/js/ck-editor.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<!-- JS Plugins Init. -->
<script src="{{asset('public/assets/admin')}}/js/app-page.js"></script>

@stack('script_2')
<audio id="myAudio">
    <source src="{{asset('public/assets/admin/sound/notification.mp3')}}" type="audio/mpeg">
</audio>


 <script> 
    $(document).ready(function () {


        $('.add_balance_form .add_balance').keyup(function(){

            let form = $(this).parent().parent();
            let current_balance = parseFloat( form.find('.current_balance').val());
            let value = parseFloat($(this).val());
            form.find('.remaining_balance').val(current_balance + value);

        });

        $('.remove_balance_form .add_balance').keyup(function(){
            let form = $(this).parent().parent();
            let current_balance = parseFloat( form.find('.current_balance').val());
            let value = parseFloat($(this).val());
            form.find('.remaining_balance').val(current_balance - value);
        });


        $('.customer_order_payment_form .payment_type').change(function(){
            
            let element = $(this).parent().parent().parent();
            let payment_type = $(this).val();
            let order_amount = element.find('.order_total input').val();
            element.find('.amount').val('');

            if(payment_type == 'cash'){
                element.find('.current_balance').hide();
                element.find('.remaining_balance').hide();
                element.find('.returned_amount').show();
                element.find('.collected_cash').show();
                element.find('.collected_cash input').attr('required',true);
                element.find('.collected_cash input').attr({"min" : order_amount});

            }else{

                element.find('.current_balance').show();
                element.find('.remaining_balance').show();
                element.find('.returned_amount').hide();
                element.find('.collected_cash').hide();
                element.find('.collected_cash input').removeAttr('required');
                let current_balance = element.find('.current_balance input').val();
                element.find('.remaining_balance input').val( current_balance - order_amount);
            }

        });


        $('.customer_order_payment_form .amount').change(function(){
           
            let element = $(this).parent().parent();
            let amount = $(this).val(); 
            let order_amount = element.find('.order_total input').val();
            let payment_type = element.find('.payment_type').val();

            if(payment_type == 'cash'){
               let remain = amount - order_amount;
               element.find('.returned_amount input').val(remain);
            }else{
                element.find('.returned_amount input').val('');
            }

        });






    });

</script>

</body>
</html>