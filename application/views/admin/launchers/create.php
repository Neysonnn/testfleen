<!-- @mrsasha082 -->
<?php echo $admheader ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">Добавление лаунчера
						</h3>
					</div>
				</div>
				<div class="card-body">
					<form id="createForm" method="POST">
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите название лаунчера">
						</div>
						<div class="form-group form-md-line-input">
							<textarea class="form-control" id="textx" name="textx" rows="3" placeholder="Описание..."></textarea>
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="img" name="img" placeholder="Введите ссылку на изображение">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="url" name="url" placeholder="Введите адрес лаунчера">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="price" name="price" placeholder="Введите стоимость лаунчера">
						</div>
						<hr>
						<input type="submit" class="btn btn-primary m-btn m-btn--air btn-outline  btn-block sbold uppercase" value="Сохранить">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#createForm').ajaxForm({ 
		url: '/admin/launchers/create/ajax',
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
					toastr.success(data.success);
					setTimeout("redirect('/admin/launchers')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
</script>
<?php echo $footer ?>