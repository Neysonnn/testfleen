<?php?>
<?echo $header?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="row">
			<?if($yandexkassa == 1):?>
				<div class="col-lg-4">
					<div class="card card-custom gutter-b">
						<div class="card-body">
							<center><img src="/application/public/img/pay/yandexmoney.jpg" style="max-width:100%;height:65px;" alt=""></center>
						</div>
						<div class="card-footer">
							<button data-toggle="modal" data-target="#yandexkassabox" class="btn btn-primary btn-lg btn-block">Пополнить</button>
						</div>
					</div>
				</div>
				<?endif;?>
				<?php if($aaio == 1): ?>
				<div class="col-lg-4">
					<div class="card card-custom gutter-b">
						<div class="card-body">
							<center><img src="/application/public/img/pay/aaio.png" style="max-width:100%;height:65px;" alt=""></center>
						</div>
						<div class="card-footer">
							<button data-toggle="modal" data-target="#aaio" class="btn btn-primary btn-lg btn-block">Пополнить</button>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?if($freekassa == 1):?>
				<div class="col-lg-4">
					<div class="card card-custom gutter-b">
						<div class="card-body">
							<center><img src="/application/public/img/pay/freekassa.svg" style="max-width:100%;height:65px;" alt=""></center>
						</div>
						<div class="card-footer">
							<button data-toggle="modal" data-target="#freepay" class="btn btn-primary btn-lg btn-block">Пополнить</button>
						</div>
					</div>
				</div>
				<?endif;?>
			</div>
		</div>
	</div>
</div>
<!-- ================================================ /aaio ================================================ -->
<div class="modal fade" id="aaio" tabindex="-1" role="dialog" aria-labelledby="aaio" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Пополнение баланса</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i aria-hidden="true" class="ki ki-close"></i>
				</button>
				</div>
				<form id="aaioForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
					<div class="modal-body">
									<div class="form-group">
										<label>Введите сумму</label>
										<input class="form-control" id="ammount" name="ammount" placeholder="100">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Отмена</button>
									<button type="submit" class="btn btn-primary font-weight-bold">Пополнить</button>
								</div>
							</form>
						</div>
					</div>
				</div>
<!-- ================================================ /aaio ================================================ -->
<!-- ================================================ /freekassa ================================================ -->
<?if($freekassa == 1):?>
<div class="modal fade" id="freepay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<form id="freepay" method="POST" class="form_0" style="padding:0px; margin:0px;">
				<div class="modal-body">
					<div class="form-group">
						<label>Введите сумму</label>
						<input class="form-control" id="ammount" name="ammount" placeholder="100">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Отмена</button>
					<button type="submit" class="btn btn-primary font-weight-bold">Пополнить</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?endif;?>
<!-- ================================================ /freekassa ================================================ -->
<!-- ================================================ /yoomoney ================================================ -->
<?if($yandexkassa == 1):?>
<div class="modal fade" id="yandexkassabox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<form id="yandexkassa" method="POST" class="form_0" style="padding:0px; margin:0px;">
				<div class="modal-body">
					<div class="form-group">
						<label>Введите сумму</label>
						<input class="form-control" id="ammount" name="ammount" placeholder="100">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Отмена</button>
					<button type="submit" class="btn btn-primary font-weight-bold">Пополнить</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?endif;?>
<!-- ================================================ /yoomoney ================================================ -->
<?if($yandexkassa == 1):?>
<script>
	$('#yandexkassa').ajaxForm({ 
	     url: '/account/pay/yandexkassa',
	     dataType: 'text',
	     success: function(data) {
	         console.log(data);
	         data = $.parseJSON(data);
	         switch(data.status) {
	             case 'error':
	                 toastr.error(data.error);
	                 $('button[type=submit]').prop('disabled', false);
	                 break;
	             case 'success':
	                 redirect(data.url);
	             break;
	         }
	     },
	     beforeSubmit: function(arr, $form, options) {
	         $('button[type=submit]').prop('disabled', true);
	     }
	 });
</script>
<?endif;?>
<?php if($aaio == 1):?>
<script>
	$('#aaioForm').ajaxForm({ 
	     url: '/account/pay/aaio',
	     dataType: 'text',
	     success: function(data) {
	         console.log(data);
	         data = $.parseJSON(data);
	         switch(data.status) {
	             case 'error':
	                 toastr.error(data.error);
	                 $('button[type=submit]').prop('disabled', false);
	                 break;
	             case 'success':
	                 redirect(data.url);
	             break;
	         }
	     },
	     beforeSubmit: function(arr, $form, options) {
	         $('button[type=submit]').prop('disabled', true);
	     }
	 });
</script>
<?php endif; ?>
<?if($freekassa == 1):?>
<script>
	$('#freepay').ajaxForm({ 
	     url: '/account/pay/freepay',
	     dataType: 'text',
	     success: function(data) {
	         console.log(data);
	         data = $.parseJSON(data);
	         switch(data.status) {
	             case 'error':
	                 toastr.error(data.error);
	                 $('button[type=submit]').prop('disabled', false);
	                 break;
	             case 'success':
	                 redirect(data.url);
	             break;
	         }
	     },
	     beforeSubmit: function(arr, $form, options) {
	         $('button[type=submit]').prop('disabled', true);
	     }
	 });
</script>
<?endif;?>
<?echo $footer?>