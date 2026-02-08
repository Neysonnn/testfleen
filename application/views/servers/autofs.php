<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
?>
<?php echo $header?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<?php include 'application/views/common/menuserver.php';?>
				</div>
				<?php foreach($fs as $item):?>
									<?php if (strpos($item['game_id'],$server['game_id']) !== false):
    

				?>
				<div class="col-xl-4">
					<div class="card card-custom gutter-b">
						<div class="card-header border-0 pt-5 text-center">
							<h3 class="card-title font-weight-bolder"><?php echo $item['fs_name']?></h3>
						</div>
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<img src="<?php echo $item['fs_img'] ?>" alt="" class="mw-100 w-400px">
							</div>
							<div class="pt-5">
								<div class="mb-5" data-scroll="true" data-height="130">
									<p class="text-center font-weight-normal font-size-x-small pb-0"><?php echo $item['fs_textx']?></p>
								</div>
								<hr>
								<?php if($item['fs_price'] > 0): ?>
								<?php foreach($userfs as $fs):  ?>
								<? if($fs['fs_id'] == $item['fs_id']) $item['free_fs'] = 1; ?>
								<?php endforeach; ?>
								<? if($item['free_fs'] == 1): ?>
								<button type="submit" onClick="sendInstall(<?php echo $server['server_id'] ?>,'<?echo $item['fs_id']?>')" class="btn btn-light-primary btn-shadow-hover font-weight-bolder w-100 py-3" data-toggle="tooltip" data-placement="right"data-original-title="Файл куплен">Установить скрипт</button>
								<? else: ?>
								<button type="submit" onClick="sendAction(<?php echo $server['server_id'] ?>,'<?echo $item['fs_id']?>')" class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Установить за <?php echo $item['fs_price']?> RUB.</button>
								<?php endif;?>
								<?php elseif($item['fs_price'] == 0): ?>
								<button type="submit" onClick="sendInstall(<?php echo $server['server_id'] ?>,'<?echo $item['fs_id']?>')"  class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Установить скрипт</button>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>   
				<?php endforeach; ?>
				<?php if(empty($fs)): ?>
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
			url: '/servers/autofs/action/'+serverid+'/'+action,
			type: 'POST',
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
						setTimeout("reload()", 1500);
						break;
				}
			},
			beforeSend: function(arr, options) {
				$('button[type=submit]').prop('disabled', true);
			}
		});  
	}
	function sendInstall(serverid, install) {	
		$.ajax({ 
			url: '/servers/autofs/install/'+serverid+'/'+install,
			type: 'POST',
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
						setTimeout("location.replace('/servers/control/index/<?php echo $server['server_id'] ?>')", 1500);
						break;
				} 
			},
			beforeSend: function(arr, options) {
				$('button[type=submit]').prop('disabled', true);
				toastr.success("Установка скрипта...");
			}
		});  
	}
</script>
<?php echo $footer ?>