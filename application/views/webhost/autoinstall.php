<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
?>
<?php echo $header?>
</script>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
<div class="d-flex flex-column-fluid">
<div class="container">
<div class="card card-custom mb-3">
<div class="card-header card-header-tabs-line">
<div class="card-toolbar">
<ul class="nav nav-tabs nav-bold nav-tabs-line">
<li class="nav-item">
<a href="/webhost/control/index/<?php echo $webhost['web_id'] ?>" class="nav-link active&lt;">
<span class="nav-icon">
<i class="fa fa-chalkboard-teacher"></i>
</span>
<span class="nav-text">ws<?php echo $webhost['web_id'] ?></small></h3>
</a>
</li>
<li class="nav-item">
<a href="/webhost/autoinstall/index/<?php echo $webhost['web_id'] ?>" class="nav-link active">
<span class="nav-icon">
<i class="fa fa-fast-forward"></i>
</span>
<span class="nav-text">Автоустановка сайтов (NEW)</span>
</a>
</li>
</li>
</ul>
</div>
</div>
</div>
			<div class="row">
				<div class="col-xl-12">
				</div>
				<?php foreach($mods as $item):?>
				<div class="col-xl-4">
					<div class="card card-custom gutter-b">
						<div class="card-header border-0 pt-5 text-center">
							<h3 class="card-title font-weight-bolder"><?php echo $item['mod_name']?></h3>
						</div>
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<img src="<?php echo $item['mod_img'] ?>" alt="" class="mw-100 w-400px">
							</div>
							<div class="pt-5">
								<div class="mb-5" data-scroll="true" data-height="70">
									<p class="text-center font-weight-normal font-size-lg pb-7"><?php echo $item['mod_textx']?></p>
								</div>
								<hr>
								<?php if($item['mod_price'] > 0): ?>
								<?php foreach($usermods as $mod):  ?>
								<? if($mod['mod_id'] == $item['mod_id']) $item['free_mode'] = 1; ?>
								<?php endforeach; ?>
								<? if($item['free_mode'] == 1): ?>
								<button type="submit" onClick="sendAction(<?php echo $webhost['web_id'] ?>,'<?echo $item['mod_id']?>')" class="btn btn-light-primary btn-shadow-hover font-weight-bolder w-100 py-3" data-toggle="tooltip" data-placement="right"data-original-title="Товар куплен">Установить</button>
								<? else: ?>
								<button type="submit" onClick="sendAction(<?php echo $webhost['web_id'] ?>,'<?echo $item['mod_id']?>')" class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Установить за <?php echo $item['mod_price']?> RUB.</button>
								<?php endif;?>
								<?php elseif($item['mod_price'] == 0): ?>
								<button type="submit" onClick="sendAction(<?php echo $webhost['web_id'] ?>,'<?echo $item['mod_id']?>')" class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Установить</button>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php if(empty($mods)): ?>
				<div class="col-xl-12 col-xxl-12">
					<div class="alert alert-custom alert-light-primary fade show mb-4" role="alert">
						<div class="alert-icon">
							<i class="flaticon-exclamation"></i>
						</div>
						<div class="alert-text">На данный момент список пуст.</div>
						<div class="alert-close">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">
							<i class="ki ki-close"></i>
							</span>
							</button>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script>	
	function sendAction(serverid, action) {	
		$.ajax({ 
			url: '/webhost/autoinstall/action/'+serverid+'/'+action,
			type: 'POST',
			dataType: 'text',
			success: function(data) {
				console.log(data);
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						Swal.fire('Ошибка', data.error, 'error');
						$('button[type=submit]').prop('disabled', false);
						break;
					case 'success':
					Swal.fire('Успех', data.success, 'success');
						break;
				}
			},
			beforeSend: function(arr, options) {
				$('button[type=submit]').prop('disabled', true);
				<?php foreach($mods as $item): ?> 
				if(action == "<?echo $item['mod_id']?>") toastr.warning("Идет установка <?echo $item['mod_name']?>, пожалуйста, подождите...");
				<?endforeach;?>
			}
		});  
	}
</script>
<?php echo $footer ?>