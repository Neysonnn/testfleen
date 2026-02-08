<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
?>
<?php echo $admheader ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">Создание скрипта
						</h3>
					</div>
				</div>
				<div class="card-body">
					<form id="createForm" method="POST">
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите название скрипта">
						</div>
						<div class="form-group form-md-line-input">
							<textarea class="form-control" id="textx" name="textx" rows="3" placeholder="Описание..."></textarea>
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="img" name="img" placeholder="Введите ссылку на изображение">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="gameid" name="gameid" value="<?php echo $mod['gameid'] ?>" placeholder="Введите ид игр">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="url" name="url" placeholder="Введите ссылку на архив (tar)">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="arch" name="arch" placeholder="Введите название архива">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="cfg" name="cfg" placeholder="Введите как записан скрипт (script.fs)">
						</div>
						<div class="form-group form-md-line-input">
							<input type="text" class="form-control" id="price" name="price" placeholder="Введите стоимость скрипта">
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
		url: '/admin/fs/create/ajax',
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
					setTimeout("redirect('/admin/fs')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});

	$(function(){
		var progressBar = $('#progressbar');
		$('#createForm').on('submit', function(e){
			e.preventDefault();
			var $that = $(this),
				formData = new FormData($that.get(0));
			$.ajax({
				url: $that.attr('action'),
				type: $that.attr('method'),
				contentType: false,
				processData: false,
				data: formData,
				dataType: 'json',
				xhr: function(){
					var xhr = $.ajaxSettings.xhr();
					xhr.upload.addEventListener('progress', function(evt){
						if(evt.lengthComputable) {
							var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
							progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
							toastr.info('Загружено ' + percentComplete + '%');
						}
					}, false);
					return xhr;
				},
				success: function(json){
					if(json){
						$that.after(json);
					}
				}
			});
		});
	});
</script>
<?php echo $footer ?>