<!-- @mrsasha082 -->
<?php echo $admheader ?>								
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">Редактирование лаунчера
						</h3>
					</div>
				</div>
				<div class="card-body">
					<form id="editForm" method="POST">
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="name" name="name" value="<?php echo $launchers['launchers_name'] ?>" placeholder="Введите название лаунчера">
						</div>
						<div class="form-group form-md-line-input">
							<textarea class="form-control" id="textx" name="textx" rows="3"placeholder="Описание..."><?php echo $launchers['launchers_textx'] ?></textarea>
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="img" name="img" value="<?php echo $launchers['launchers_img'] ?>" placeholder="Введите ссылку на изображение">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="url" name="url" value="<?php echo $launchers['launchers_url'] ?>" placeholder="Введите ссылку на лаунчер">
						</div>
						<hr>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="price" name="price" value="<?php echo $launchers['launchers_price'] ?>" placeholder="Введите стоимость лаунчера">
						</div>
						<div class="form-group form-md-line-input">
							<select class="form-control" id="status" name="status" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
								<option value="0"<?php if($launchers['launchers_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключен</option>
								<option value="1"<?php if($launchers['launchers_status'] == 1): ?> selected="selected"<?php endif; ?>>Включен</option>
							</select>
						</div>
						<hr>
						<div class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-block" role="group" aria-label="Large button group">
							<button type="submit" class="btn btn-primary btn-outline  btn-block sbold uppercase">Сохранить изменения</button>
							<a data-toggle="tooltip" data-placement="right" title="" data-original-title="Удалить" style="height: 3.1rem;" href="/admin/launchers/edit/delete/<?php echo $launchers['launchers_id'] ?>" class="btn btn-danger btn-elevate btn-icon"><i class="fa fa-trash-alt"></i></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#editForm').ajaxForm({ 
		url: '/admin/launchers/edit/ajax/<?php echo $launchers['launchers_id'] ?>',
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