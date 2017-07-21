<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demo.naksoid.com/elephant-v1.3.0/theme-4/login-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Jul 2017 07:14:18 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Booking Room Sistem</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <!--<meta name="description" content="Elephant is a front-end template created to help you build modern web applications, fast and in a professional manner.">
    <meta property="og:url" content="http://demo.naksoid.com/elephant">
    <meta property="og:type" content="website">
    <meta property="og:title" content="The fastest way to build modern admin site for any platform, browser, or device">
    <meta property="og:description" content="Elephant is a front-end template created to help you build modern web applications, fast and in a professional manner.">
    <meta property="og:image" content="../../elephant/img/ae165ef33d137d3f18b7707466aa774d.jpg">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@naksoid">
    <meta name="twitter:creator" content="@naksoid">
    <meta name="twitter:title" content="The fastest way to build modern admin site for any platform, browser, or device">
    <meta name="twitter:description" content="Elephant is a front-end template created to help you build modern web applications, fast and in a professional manner.">
    <meta name="twitter:image" content="../../elephant/img/ae165ef33d137d3f18b7707466aa774d.jpg">
	-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="manifest.json">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#27ae60">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">
    <link rel="stylesheet" href="<?php echo base_url() ?>asset/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>asset/css/elephant.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>asset/css/login-3.min.css">
	<script src="<?php echo base_url() ?>asset/js/jquery.js"></script>
  </head>
  <body>
    <div class="login">
      <div class="login-body">
          <img class="img-responsive" src="asset/img/header-login.png" style="width:650%; max-width:250px;">
        <h3 class="login-heading">Sign in</h3>
        <div class="login-form">
          <?php echo form_open('login');?>
		  <div class="alert alert-info" id="konf">
			<!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>-->
			<span class="icon icon-info-circle icon-lg"></span>
			<small id="konfIsi">Silahkan Isikan <strong>Username</strong> dan <strong>Password</strong> Anda</small>
		  </div>
          <form data-toggle="md-validator">
            <div class="md-form-group md-label-floating">
              <input id="username" class="md-form-control" type="text" name="username" spellcheck="false" autocomplete="off" data-msg-required="Please enter your username." required>
              <label class="md-control-label">Username</label>
            </div>
            <div class="md-form-group md-label-floating">
              <input id="password" class="md-form-control" type="password" name="password" data-msg-required="Please enter your password." required>
              <label class="md-control-label">Password</label>
            </div>
            <!--<button class="btn btn-primary btn-block" type="submit">Sign in</button>-->
			<a class="btn btn-primary btn-block" onclick="javascript:ogy();">Sign in</a>
          </form>
        </div>
      </div>
	  <!--
      <div class="login-footer">
        Don't have an account? <a href="signup-3.html">Sign Up</a>
      </div>
	  -->
    </div>
    <script src="asset/js/vendor.min.js"></script>
    <script src="asset/js/elephant.min.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-83990101-1', 'auto');
      ga('send', 'pageview');
	  
	function ogy(){
			if($('#username').val() == ''){
					$('#konf').attr('class', 'alert alert-danger');
					$('#konfIsi').html('Username Tidak Boleh Kosong');					
					return false;
			}
			
			if($('#password').val() == ''){
					$('#konf').attr('class', 'alert alert-danger');
					$('#konfIsi').html('Password Tidak Boleh Kosong');					
					return false;
			}
			
		
		$('#konf').attr('class', 'alert alert-info');
		$('#konfIsi').html('Processing ...');
		
		request = $.ajax({
			url: "http://124.81.66.52/book_login/",
			type: "post",
			data: {
				username:$('#username').val(),
				pass: $('#password').val()
			}
		});

		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXHR){
			res = response.split('|');
			
			if(res[0].trim() != 'SUCCESS'){
				$('#konf').attr('class', 'alert alert-danger');
				$('#konfIsi').html('Username / Password Tidak Ditemukan	');
			}else{
				$('#konf').attr('class', 'alert alert-success');
				$('#konfIsi').html('Login Berhasil !');
				if(res[6]== 2){
					window.location.href='<?php echo site_url('user/home'); ?>';
				}else{
					window.location.href='<?php echo site_url('admin/home'); ?>';
				}
			}
			return false;
		});

		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
			);
		});
	}
    </script>
  </body>

<!-- Mirrored from demo.naksoid.com/elephant-v1.3.0/theme-4/login-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Jul 2017 07:14:18 GMT -->
</html>