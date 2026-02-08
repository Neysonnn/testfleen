<?php
?>
<?php echo $header ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
<center><h4 class="card" style="padding:12px;width:80%; text-align:center;">Активация секретного кода</h4></center>
	<div class="d-flex flex-column-fluid" style="margin-top:15px;">
		<div class="container">
				<div class="row">
<div class="col-xl-6 col-xxl-6">
  <div class="card card-custom bg-gray-100 gutter-b">
    <div class="card-header border-0 pt-7">
      <h3 class="card-title align-items-start flex-column">
<span class="card-label font-weight-bold font-size-h4 text-dark-75">Секретный код</span>
</h3>
    </div>
    <div class="card-body">
      <form id="orderForm" method="POST" style="padding:0px; margin:0px;">
        <div data-repeater-item="" class="kt--margin-bottom-10">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
<i class="fa fa-gift" aria-hidden="true"></i>
</span>
            </div>
            <input id="code" type="text" class="form-control form-control-danger" name="code" placeholder="Введите секретный код">
            <div class="input-group-append">
              <button type="button" onclick="codeCode()" class="btn btn-primary btn-icon"><i class="fa fa-check" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-xl-6 col-xxl-6">
<div class="card card-custom card-shadowless bg-gray-100 gutter-b">
<div class="card-header border-0 pt-7">
<h3 class="card-title align-items-start flex-column">
<span class="card-label font-weight-bold font-size-h4 text-dark-75">Информация о заказе 📌</span>
</h3>

			<div class="content-box-wrapper">
				<ul><b>Периодически мы будем выкладывать секретные коды, активировав которые можно получить бонусы<br>
					<li>Где искать коды?:</li>
					1. На стене нашего сообщества(<u><a href="https://vk.com/public<?=$public;?>" target="_blank">VK</a></u>);<br>
					2. В рассылке.
					<li>Что может выпасть?:</li>
					1. Любой сервер;<br>
					2. Баланс на счет аккаунта.
					</b>
				</ul>
			</div>
</div>
</div>
</div>

				</div>
		</div>
	</div>
</div>
<script>
	function codeCode(){
		var codik = $("#code").val();
		$.post("/code/index/code",{code: codik},function(data){
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					break;
				case 'success':
					toastr.success(data.success);
					if(data.type == 1) {
						setTimeout("redirect('/servers/control/index/" + data.id + "')", 1500);
					} else {
						setTimeout("reload()", 1500);
					}
					break;
			}
		});
	}

</script>
<?php echo $footer ?>