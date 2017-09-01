<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	
    <title>1Residence Inventory</title>
	<link rel="shortcut icon" href="{{ asset('imgs/logo.gif') }}" /> 
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	
    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_mystyle.css') }}">
    <style>
        .tooltip-inner {
            background-color: #fff !important;
            color: #000;
            font-size: 15px;
            border: 1px solid #000;
        }

        .fa-btn {
            margin-right: 6px;
        }
	    .label{
            font-weight: normal !important;
            font-size: 13px !important;
        }
    </style>
</head>
<body id="app-layout">

    
	@include('layouts.menu')
    @yield('content')
   
	 <div class="modal fade" id="modelChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-11 col-xs-11">
                    <div class="alert alert-info" style="margin:0px; padding:15px 15px 0px;">
                        <h4 align="center">Change Profile</h4>
                    </div>
                </div>
                <div class="col-md-1 col-xs-1">
                    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div class="modal-body" style="padding-top:0px;">

            </div>
        </div>
    </div>
</div>
    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery.min.js') }}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src ="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>
    <script src ="{{ asset('js/jquery.validate1.js') }}"></script>
    <script src ="{{ asset('js/sweetalert-dev.js') }}"></script>
    <script>
      	
    </script>
	@yield('jquery')
   

<script>
    $(function(){
   		$(document).on('click', "#changePass",function () {
			var url = "/changePassword";
			$('.modal-body').load(url,function(result){
				$('#modelChangePassword').modal({show:true});
			});
		});
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>


</body>
</html>
