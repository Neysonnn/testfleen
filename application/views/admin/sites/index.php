<!-- @mrsasha082 -->
<?php echo $admheader ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
   <div class="d-flex flex-column-fluid">
      <div class="container">
         <div class="card card-custom">
            <div class="card-header">
               <div class="card-title">
                  <h3 class="card-label">Список сайтов
                  </h3>
               </div>
               <div class="card-toolbar">
                  <a href="/admin/sites/create" class="btn btn-sm btn-icon btn-light-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Добавить сайт">
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
                           <th>Название</th>
                           <th>Статус</th>
                           <th>Стоимость</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach($sites as $item): ?>
                        <tr onClick="redirect('/admin/sites/edit/index/<?php echo $item['sites_id'] ?>')">
                           <th scope="row"><?php echo $item['sites_id'] ?></th>
                           <td><?php echo $item['sites_name'] ?></td>
                           <td>
                              <?php if($item['sites_status'] == 0): ?> 
                              <span class="badge badge-danger">Выключен</span>
                              <?php elseif($item['sites_status'] == 1): ?> 
                              <span class="badge badge-success">Включен</span>
                              <?php endif; ?>
                           </td>
                           <td><?php echo $item['sites_price'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($sites)): ?> 
                        <tr>
                           <td colspan="4" class="text-center">На данный момент нет сайтов.</td>
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
<?php echo $footer ?>
