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
						<h3 class="card-label">Список секрет кодов
						</h3>
					</div>
					<div class="card-toolbar">
						<a href="javascript:;" data-toggle="modal" data-target="#createmoney" class="btn btn-sm btn-icon btn-light-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Создать секретный код(деньги)">
						<i class="flaticon2-add-square"></i>
						</a>
					</div>
					<div class="card-toolbar">
						<a href="javascript:;" data-toggle="modal" data-target="#createserv" class="btn btn-sm btn-icon btn-light-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Создать секретный код(сервер)">
						<i class="flaticon2-add-square"></i>
						</a>
					</div>
				</div>
				<div class="card-body" style="padding: 0rem 1rem;">
					<div class="table-responsive">
						<table class="table table-head-custom table-vertical-center">
							<thead>
								<tr>
									<th><i class="fa fa-list-ol"></i></th>
									<td>Код</td>
									<td>Денег</td>
									<td>дней</td>
									<td>Использовано</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($codes as $item): ?>
								<tr onClick="redirect('/admin/code/edit/index/<?php echo $item['id'] ?>')">
									<td><?php echo $item['id'] ?></td>
									<td><?echo $item['cod']?></td>
									<td><?php echo $item['money'] ?></td>
									<td><?php echo $item['server_day'] ?></td>
									<td><?php echo $item['used'] ?>/<?php echo $item['uses'] ?></td>
								</tr>
								<?php endforeach; ?>
								<?php if(empty($codes)): ?>
								<tr>
									<td colspan="4" class="text-center">На данный момент нет секрет кодов.</td>
								</tr>
								<?php endif; ?> 
							</tbody>
						</table>
						<?php echo $pagination ?> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="createmoney" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Создание секретного кода(деньги)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<form id="createmoney" method="POST" style="padding:0px; margin:0px;">
				<div class="modal-body">
					<div class="form-group form-md-line-input">
						<label>Название секретного кода</label>
						<input type="text" class="form-control" id="code" name="code" placeholder="code">
					</div>
					<div class="form-group form-md-line-input">
						<label>Деняк</label>
						<input oninput="this.value = this.value.replace(/\D/g, '')" class="form-control" id="money" name="money" placeholder="money">
					</div>
					<div class="form-group form-md-line-input">
						<label>Использований</label>
						<input oninput="this.value = this.value.replace(/\D/g, '')" class="form-control" id="uses" name="uses" placeholder="uses">
					</div>
					<div class="modal-footer" style="padding: 0.5rem;">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Отмена</button>
						<button type="submit" class="btn btn-primary font-weight-bold">Создать</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="createserv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Создание секретного кода(сервер)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<form id="createserv" method="POST" style="padding:0px; margin:0px;">
				<div class="modal-body">
					<div class="form-group form-md-line-input">
						<label>Название секретного кода</label>
						<input type="text" class="form-control" id="code" name="code" placeholder="code">
					</div>
								<div class="form-group form-md-line-input">
									<label>Выберите локацию</label>
									<select class="form-control" id="locationid" name="locationid" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
										<?php foreach($locations as $item): ?> 
										<option value="<?php echo $item['location_id'] ?>" class="<?php echo $item['location_games'] ?>"><?php echo $item['location_name'] ?> | Anti-DDoS</option>
										<?php endforeach; ?>
										<?php if(empty($locations)): ?>
										<option value="0">На данный момент нет доступных локаций</option>
										<?php endif; ?>
									</select>
								</div>
									<label>Игра</label>
									<select class="form-control" id="gameid" name="gameid" aria-required="true" aria-invalid="false" aria-describedby="delivery-error" onChange="updateForm()">
										<?php foreach($games as $item): ?> 
										<option value="<?php echo $item['game_id'] ?>"><?php echo $item['game_name'] ?></option>
										<?php endforeach; ?>
										<?php if(empty($games)): ?>
										<option value="0">На данный момент нет доступных игр</option>
										<?php endif; ?>
									</select>
								<div class="form-group form-md-line-input">
									<label>Выберите период оплаты</label>
									<select class="form-control" id="days" name="days" aria-required="true" aria-invalid="false" aria-describedby="delivery-error" onChange="updateForm()">
										<option value="15">15 дней</option>
										<option value="30">30 дней</option>
										<option value="60">60 дней</option>
										<option value="90">90 дней (-5%)</option>
										<option value="180">180 дней (-10%)</option>
										<option value="360">360 дней (-15%)</option>
									</select>
								</div>
					<div class="form-group form-md-line-input">
						<label>Слоты</label>
						<input oninput="this.value = this.value.replace(/\D/g, '')" class="form-control" id="slots" name="slots" placeholder="slots">
					</div>
					<div class="form-group form-md-line-input">
						<label>Использований</label>
						<input oninput="this.value = this.value.replace(/\D/g, '')" class="form-control" id="uses" name="uses" placeholder="uses">
					</div>
					<div class="modal-footer" style="padding: 0.5rem;">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Отмена</button>
						<button type="submit" class="btn btn-primary font-weight-bold">Создать</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('#createmoney').ajaxForm({ 
		url: '/admin/code/index/ajax',
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
					setTimeout("redirect('/admin/code')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
</script>
<script>
	$('#createserv').ajaxForm({ 
		url: '/admin/code/index/ajax2',
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
					setTimeout("redirect('/admin/code')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
</script>	
<?php echo $footer ?>