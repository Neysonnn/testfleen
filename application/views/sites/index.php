<!-- @mrsasha082 -->
<?php echo $header ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<div class="row">
				<?php foreach($sites as $item):?>
				<div class="col-xl-4">
					<div class="card card-custom gutter-b">
						<div class="card-header border-0 pt-5 text-center">
							<h3 class="card-title font-weight-bolder"><?php echo $item['sites_name'] ?></h3>
						</div>
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<img src="<?php echo $item['sites_img'] ?>" alt="" class="mw-100 w-233px">
							</div>
							<div class="pt-5">
								<div class="mb-5" data-scroll="true" data-height="100">
									<p class="text-center font-weight-normal font-size-lg pb-7"><?php echo $item['sites_textx']?></p>
								</div>
								<hr>
								<?php if($item['sites_price'] > 0): ?>
								<?php foreach($user_sites as $sites_item):  ?>
								<? if($item['sites_id'] == $sites_item['sites_id']) $item['free_sites'] = 1; ?>
								<?php endforeach; ?>
								<? if($item['free_sites'] == 1): ?>
								<a href="<?php echo $item['sites_url']?>" class="btn btn-light-primary btn-shadow-hover font-weight-bolder w-100 py-3" data-toggle="tooltip" data-placement="right"data-original-title="Файл куплен">Скачать файл</a>
								<? else: ?>
								<a type="submit" onClick="sendAction('<?php echo $item['sites_id']?>')" class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Купить за <?php echo $item['sites_price']?> RUB.</a>
								<?php endif;?>
								<?php elseif($item['sites_price'] == 0): ?>
								<a href="<?php echo $item['sites_url']?>"  class="btn btn-primary btn-shadow-hover font-weight-bolder w-100 py-3">Скачать файл</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div> 
				<?php endforeach; ?>
				<?php if(empty($sites)): ?>
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
			<?php echo $pagination ?>
		</div>
	</div>
</div>
<script>	
	function sendAction(sitesid) {	
		$.ajax({ 
			url: '/sites/buy/'+sitesid,
			type: 'POST',
			dataType: 'text',
			success: function(data) {
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
</script>
<?php echo $footer ?>
<!-- @mrsasha082 -->