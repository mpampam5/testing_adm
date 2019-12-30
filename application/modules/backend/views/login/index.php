<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name='robots' content='noindex, follow' />
<!--===============================================================================================-->
	<!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" href="<?=base_url()?>_template/backend/vendors/jquery-toast-plugin/jquery.toast.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>_template/backend/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" action="<?=$action?>" id="form" autocomplete="off">
					<span class="login100-form-title p-b-43">
						Account Login
					</span>

					<div class="wrap-input100 rs1">
						<input class="input100 username" type="text" name="username">
						<span class="label-input100">Username</span>
					</div>


					<div class="wrap-input100 rs2">
						<input class="input100 password" type="password" name="password">
						<span class="label-input100">Password</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="submit">
							Login
						</button>
					</div>

					<div class="text-center w-full p-t-23">
						<a href="#" class="txt1">
							Copyright © <?=date('Y')?>  <?=strtoupper(setting_system("title"))?>
						</a>
					</div>
				</form>


        <div class="text-center">
          <div class="" id="username"></div>
          <div class="" id="password"></div>
        </div>


				<?php
				// $token =  "mpampam8888" ;
				// $password = "admin";
				//  echo pass_encrypt($token,$password);
				 ?>

			</div>
		</div>
	</div>





<!--===============================================================================================-->
	<script src="<?=base_url()?>_template/backend/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>_template/backend/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>_template/backend/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url()?>_template/backend/login/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="<?=base_url()?>_template/backend/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url()?>_template/backend/login/js/main.js"></script>


<script type="text/javascript">
  $("#form").submit(function(e){
    e.preventDefault();
    var me = $(this);
    $('#submit').prop('disabled', true)
                 .html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Loading...');
    $.ajax({
      url      : me.attr('action'),
      type     : 'POST',
      data     :me.serialize(),
      dataType : 'JSON',
      success:function(json){
       if (json.success==true) {
         if (json.valid==true) {
           window.location.href = json.url;
         }else {
           $(".password").val('');
           $('#submit').prop('disabled', false).text('Login');
           $.toast({
             // heading: 'Gagal Login',
             text: json.alert,
             showHideTransition: 'slide',
             icon: 'error',
             loaderBg: '#3e3e3e',
             position: 'top-center'
           });
           $('.text-danger').remove();
         }
       }else {
         $.each(json.alert, function(key, value) {
           var element = $('#' + key);
           $('#submit').prop('disabled', false).text('Login');
           $(element).find('.text-danger').remove();
           $(element).html(value);
         });
       }
     }
    });
  })
</script>

</body>
</html>
