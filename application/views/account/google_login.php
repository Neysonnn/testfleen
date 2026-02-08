<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
?>


<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $title ?> | <?php echo $description ?></title>
		<meta name="description" content="<?php echo $description ?>">
		<meta name="keywords" content="<?php echo $keywords ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="/assets/css/login-2.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/favicon.ico" />
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
		<div class="d-flex flex-column flex-root">
			<div class="login login-2 login-signin-on d-flex flex-column flex-column-fluid bg-white position-relative overflow-hidden">
				<div class="login-header py-10 flex-column-auto">
				</div>
				<div class="login-body d-flex flex-column-fluid align-items-stretch justify-content-center">
					<div class="container row">
						<div class="col-lg-6 d-flex align-items-center">
							<div class="login-form login-signin">
								<form class="form w-xxl-550px rounded-lg p-20" novalidate="novalidate" id="loginForm">
									<div class="alert alert-primary mb-5 p-5" role="alert">
										<h4 class="alert-heading">Здравствуйте, <?php echo $user_email; ?>!</h4>
										<p>Ваша сессия заблокирована. Для ее разблокировки, войдите на мобильном устройстве в приложение Google Authenticator и введите временный код в соответствующую форму. <br>После успешной операции, Вам будет открыт доступ к функциям аккаунта.</p>
									</div>
									<div class="form-group">
										<label class="font-size-h6 font-weight-bolder text-dark">Код из приложения</label>
										<input class="form-control form-control-solid h-auto p-6 rounded-lg" type="text" name="google_auth_code" id="google_auth_code" maxlength="6" placeholder="Введите код из приложения Google Authenticator" required>
									</div>
									<div class="pb-lg-0 pb-5">
										<div class="btn-group btn-block" role="group">
											<button type="submit" class="btn btn-primary btn-block font-weight-bolder font-size-h6">Войти</button>
										</div>
									</div>
								   <hr>
								   <center>
										<span class="text-muted font-weight-bold font-size-h4">Не Ваш аккаунт?<br>
											<a href="/account/logout" class="text-primary font-weight-bolder">Выйти</a>
										</span>
								   </center>
								</form>
							</div>
						</div>
						<div class="col-lg-6 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-150px mt-10 m-md-0 offcanvas-mobile" style="background-image: url(/application/public/img/hostinpl56.png)"></div>
					</div>
				</div>
				<div class="login-footer py-10 flex-column-auto">
					<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
						<div class="font-size-h6 font-weight-bolder order-2 order-md-1 py-2 py-md-0">
							<span class="text-muted font-weight-bold mr-2">2022©</span>
							<a href="https://hostinpl.ru" target="_blank" class="text-dark-50 text-hover-primary"><?php echo $description ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="/assets/js/plugins.bundle.js"></script>
		<script src="/assets/js/prismjs.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<script src="/application/public/js/jquery.form.min.js"></script>
		<script src="/application/public/js/main.js"></script>
		<script src="/assets/js/fullcalendar.bundle.js"></script>
	</body>
</html>
<script>
   	$('#loginForm').ajaxForm({ 
   	    url: '/account/google_login/ajax',
   	    dataType: 'text',
		type: 'POST',
   	    success: function(data) {
   			console.log(data);
   			data = $.parseJSON(data);
   			switch(data.status) {
   				case 'error':
   					toastr.error(data.error);
   					$('button[type=submit]').prop('disabled', false);
   					break;
   				case 'success':
   					toastr.success(data.success);
   					setTimeout("reload()", 1500);
   					break;
   			}
   		},
   		beforeSubmit: function(arr, $form, options) {
   			$('button[type=submit]').prop('disabled', true);
   		}
   	});
</script>
<?php if(isset($error)): ?><script>toastr.error('<?php echo $error ?>');</script><?php endif; ?> 
<?php if(isset($warning)): ?><script>toastr.warning('<?php echo $warning ?>');</script><?php endif; ?> 
<?php if(isset($success)): ?><script>toastr.success('<?php echo $success ?>');</script><?php endif; ?>