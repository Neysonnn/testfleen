<html lang="ru">
   <head>
      <meta charset="utf-8" />
      <title>Fleen Host | Хостинг игровых серверов SAMP / CRMP</title>
      <meta name="description" content="<?php echo $description ?>">
      <meta name="keywords" content="<?php echo $keywords ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />


<? //тута первый стиль?>
         <?if($themeid == 1):?>
         <link href="/assets/css/dark/style.bundle.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/dark/light.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/dark/lightm.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/dark/dark.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/dark/header.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/dark/darkm.css" rel="stylesheet" type="text/css" />
         <?endif;?>
         <? //тута второй стиль?>
         <?if($themeid == 2):?>
         <link href="/assets/css/theme1/style.bundle.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/theme1/light.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/theme1/lightm.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/theme1/dark.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/theme1/header.css" rel="stylesheet" type="text/css" />
         <link href="/assets/css/theme1/darkm.css" rel="stylesheet" type="text/css" />
         <?endif;?>


      <link href="/assets/css/translate.css" rel="stylesheet" type="text/css" />
      <link href="/assets/css/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
      <link href="/assets/css/plugins.bundle.css" rel="stylesheet" type="text/css" />
      <link href="/assets/css/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	  <link href='https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700' rel='stylesheet'>
       </head>
   <body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable">
      <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
         <a href="/main/index">
         <h1 href="index.html#">
                              FLEEN-HOST
                           </h1>
         </a>
         <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
            </button>
            <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
               <span class="svg-icon svg-icon-xl">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                     </g>
                  </svg>
               </span>
            </button>
         </div>
      </div>
      <div class="d-flex flex-column flex-root">
      <div class="d-flex flex-row flex-column-fluid page">
      <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
      <div class="flex-column-auto" id="kt_brand">
         <a href="/main/index" class="brand-logo">
         <span _ngcontent-kbk-c40="" class="font-size-h1 font-weight-boldest ml-13 text-nowrap"> FLEEN-HOST </span>
         </a>
         <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
         </button>
      </div>
     <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
<ul class="menu-nav">
<li class="menu-item menu-item" aria-haspopup="true">
<a href="/main/index" class="menu-link">
<span class="menu-icon fa fa-home">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
<polygon points="0 0 24 0 24 24 0 24" />
<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
</g>
</svg>
                     </span>
                     <span class="menu-text">Главная страница</span>
                  </a>
               </li>
               <li class="menu-item menu-item-submenu menu-item-rel " aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <path d="M5,2 L19,2 C20.1045695,2 21,2.8954305 21,4 L21,6 C21,7.1045695 20.1045695,8 19,8 L5,8 C3.8954305,8 3,7.1045695 3,6 L3,4 C3,2.8954305 3.8954305,2 5,2 Z M11,4 C10.4477153,4 10,4.44771525 10,5 C10,5.55228475 10.4477153,6 11,6 L16,6 C16.5522847,6 17,5.55228475 17,5 C17,4.44771525 16.5522847,4 16,4 L11,4 Z M7,6 C7.55228475,6 8,5.55228475 8,5 C8,4.44771525 7.55228475,4 7,4 C6.44771525,4 6,4.44771525 6,5 C6,5.55228475 6.44771525,6 7,6 Z" fill="#000000" opacity="0.3"/>
                              <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,13 C21,14.1045695 20.1045695,15 19,15 L5,15 C3.8954305,15 3,14.1045695 3,13 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M11,11 C10.4477153,11 10,11.4477153 10,12 C10,12.5522847 10.4477153,13 11,13 L16,13 C16.5522847,13 17,12.5522847 17,12 C17,11.4477153 16.5522847,11 16,11 L11,11 Z M7,13 C7.55228475,13 8,12.5522847 8,12 C8,11.4477153 7.55228475,11 7,11 C6.44771525,11 6,11.4477153 6,12 C6,12.5522847 6.44771525,13 7,13 Z" fill="#000000"/>
                              <path d="M5,16 L19,16 C20.1045695,16 21,16.8954305 21,18 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,18 C3,16.8954305 3.8954305,16 5,16 Z M11,18 C10.4477153,18 10,18.4477153 10,19 C10,19.5522847 10.4477153,20 11,20 L16,20 C16.5522847,20 17,19.5522847 17,19 C17,18.4477153 16.5522847,18 16,18 L11,18 Z M7,20 C7.55228475,20 8,19.5522847 8,19 C8,18.4477153 7.55228475,18 7,18 C6.44771525,18 6,18.4477153 6,19 C6,19.5522847 6.44771525,20 7,20 Z" fill="#000000"/>
                           </g>
                        </svg>
                     </span>
                     <span class="menu-text">Игровые сервера</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">Игровые сервера</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/servers/order" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Заказать Сервер</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/servers" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Мои Сервера</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
			   <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="menu-icon fa fa-shopping-cart">
                        
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                     </g>
                           </span>
                     <span class="menu-text">Дополнительные услуги</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">Дополнительные услуги</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/uslugi" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Услуги для сервера</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/webuslugi" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Услуги для сайта</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
                              <li class="menu-item menu-item-submenu menu-item-rel " aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <path d="M6,8 L6,16 L18,16 L18,8 L6,8 Z M20,16 L21.381966,16 C21.7607381,16 22.1070012,16.2140024 22.2763932,16.5527864 L22.5,17 C22.6706654,17.3413307 22.5323138,17.7563856 22.190983,17.927051 C22.0950363,17.9750244 21.9892377,18 21.881966,18 L2.11803399,18 C1.73641461,18 1.42705098,17.6906364 1.42705098,17.309017 C1.42705098,17.2017453 1.45202663,17.0959467 1.5,17 L1.7236068,16.5527864 C1.89299881,16.2140024 2.23926193,16 2.61803399,16 L4,16 L4,8 C4,6.8954305 4.8954305,6 6,6 L18,6 C19.1045695,6 20,6.8954305 20,8 L20,16 Z" fill="#000000" fill-rule="nonzero"/>
                              <polygon fill="#000000" opacity="0.3" points="6 8 6 16 18 16 18 8"/>
                           </g>
                        </svg>
                     </span>
                     <span class="menu-text">WEB</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">WEB</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/webhost/order" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Заказать веб-хостинг</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/webhost" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Мои веб-сайты</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
                  <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                     </g>
                           </span>
                     <span class="menu-text">Товары</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">Товары</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/sites" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Сайты</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/forums" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Форумы</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
               <li class="menu-item menu-item-submenu menu-item-rel " aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"/>
                              <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"/>
                           </g>
                        </svg>
                     </span>
                     <span class="menu-text">Поддержка</span>
                     <?php
if ($rowtick > 0) {
    echo '<span class="label label-danger font-weight-bold label-inline"><b>+' . $rowtick . '</b></span>';
}
?>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">Поддержка</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/tickets/create" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Создать запрос</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/tickets/index" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Мои запросы</span>
						   <?php
if ($rowtick > 0) {
    echo '<span class="label label-danger font-weight-bold label-inline"><b>' . $rowtick . '</b></span>';
}
?>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/tickets/faq" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">База знаний (FAQ)</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
               <li class="menu-item menu-item-submenu menu-item-rel " aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                              <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                              <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                           </g>
                        </svg>
                     </span>
                     <span class="menu-text">Финансы</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                           <span class="menu-text">Финансы</span>
                           </span>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/account/pay" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Пополнить баланс</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/account/invoices" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">История баланса</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/account/perevod" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Перевод средств</span>
                           </a>
                        </li>
                        <li class="menu-item " aria-haspopup="true">
                           <a href="/account/bonus" class="menu-link">
                           <i class="menu-bullet menu-bullet-dot">
                           <span></span>
                           </i>
                           <span class="menu-text">Обменять бонусы</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
			   <li class="menu-item menu-item" aria-haspopup="true">
                  <a href="/code" class="menu-link">
                     <span class="svg-icon menu-icon">
						<span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Design\Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"></rect>
													<path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z" fill="currentColor"></path>
													<path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="currentColor"></path>
													<path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z" fill="currentColor"></path>
								<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
							</g>
						</svg><!--end::Svg Icon--></span>
                     </span>
                     <span class="menu-text">Секретный код</span>
                  </a>
               </li>
               <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" data-menu-toggle="hover">
                  <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                           <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"></path>
                           <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z"></path>
                        </svg>
                     </span>
                     <span class="menu-text">Язык</span>
                     <i class="menu-arrow"></i>
                  </a>
                  <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                           <span class="menu-link">
                            <span class="menu-text">Язык</span>
                           </span>
                        </li>
                        <li class="menu-item" aria-haspopup="true" id="ru">
                           <a href="/" data-google-lang="ru" class="menu-link language__img_active">
                           <span></span>
                           <span class="menu-text">Русский(Russia)</span>
                           <span>
                              <img src="/application/public/img/lang/lang__ru.png">
                           </span>
                           </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true" id="uk">
                           <a href="/" data-google-lang="uk" class="menu-link">
                           <span></span>
                           <span class="menu-text">Украинский</span>
                           <span>
                              <img src="/application/public/img/lang/lang__uk.png">
                           </span>
                           </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true" id="en">
                           <a href="/" data-google-lang="en" class="menu-link">
                           <span></span>
                           <span class="menu-text">English</span>
                           <span>
                              <img src="/application/public/img/lang/lang__en.png">
                           </span>
                           </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true" id="es">
                           <a href="/" data-google-lang="es" class="menu-link">
                           <span></span>
                           <span class="menu-text">Испанский</span>
                           <span>
                              <img src="/application/public/img/lang/lang__es.png">
                           </span>
                           </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true" id="kk">
                           <a href="/" data-google-lang="kk" class="menu-link">
                           <span></span>
                           <span class="menu-text">Казахстанский</span>
                           <span>
                              <img src="/application/public/img/lang/lang__kz.png">
                           </span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
			   <button type="submit" href="javascript:;" onClick="sendActionn('one')" class="btn btn-light-primary btn-lg btn-block font-weight-bolder">Сменить тему</button>
                  </a>
               </li>
			</div>
		</div>
	</div>
           <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
      <div id="kt_header" class="header header-fixed">
         <div class="container-fluid d-flex align-items-stretch justify-content-between">
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
               <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                  <ul class="menu-nav">
                     <li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
                        <a href="https://vk.com/fleenhost" target="_blank" class="navi-link">
                        <span class="symbol symbol-30 mr-3">
                        <span class="symbol-label"><i class="fab fa-vk text-primary"></i></span>
                        </span>
						<a href="https://vk.me/join/AJQ1d1ZjOCO3jneVP8wNJ9Ed" target="_blank" class="btn btn-sm btn-success font-weight-bolder py-3 px-6">Беседа VK</a>
	                    </a>
                     </li>
                  </ul>
               </div>
            </div>				   
            <div class="topbar">
               <div class="topbar-item mr-1 mr-lg-3">
                  <a <?if($oplata_status == 1):?> data-toggle="modal" data-target="#hostin" <? else:?>onClick="redirect('/account/pay')"<?endif;?> class="btn btn-fixed-height btn-light-primary font-weight-bolder font-size-sm px-5 my-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                              <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                              <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                           </g>
                        </svg>
                     </span>
                     <?php echo $user_balance ?> RUB
                  </a>
               </div>
               <div class="topbar-item mr-1 mr-lg-3">
                  <div class="btn btn-icon btn-circle btn-hover-light-primary <?php foreach($tickets as $item): ?>
                     <?php if($item['ticket_status'] == 2): ?>pulse pulse-primary<?php endif; ?>
                     <?php endforeach; ?>" id="kt_quick_panel_toggle">
                     <span class="pulse-ring"></span>
                     <span class="svg-icon svg-icon-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24" />
                              <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M14.4862 18L12.7975 21.0566C12.5304 21.54 11.922 21.7153 11.4386 21.4483C11.2977 21.3704 11.1777 21.2597 11.0887 21.1255L9.01653 18H5C3.34315 18 2 16.6569 2 15V6C2 4.34315 3.34315 3 5 3H19C20.6569 3 22 4.34315 22 6V15C22 16.6569 20.6569 18 19 18H14.4862Z" fill="black" />
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7H15C15.5523 7 16 7.44772 16 8C16 8.55228 15.5523 9 15 9H6C5.44772 9 5 8.55228 5 8C5 7.44772 5.44772 7 6 7ZM6 11H11C11.5523 11 12 11.4477 12 12C12 12.5523 11.5523 13 11 13H6C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11Z" fill="black" />
                           </g>
                        </svg>
                     </span>
                  </div>
               </div>
               <div class="topbar-item mr-1 mr-lg-3">
                  <div class="btn btn-icon btn-circle btn-hover-light-primary" id="kt_quick_actions_toggle">
                     <span class="pulse-ring"></span>
                     <span class="svg-icon svg-icon-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"/>
                              <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"/>
                              <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"/>
                           </g>
                        </svg>
                     </span>
                  </div>
               </div>
               <div class="topbar-item">
                  <div class="btn btn-icon btn-circle btn-light-primary" id="kt_quick_user_toggle">
                     <span class="svg-icon svg-icon-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24" />
                              <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                              <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                           </g>
                        </svg>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				 <h3 class="font-weight-bold m-0">Профиль 
               <small class="text-muted font-size-sm ml-2"><?if($user_access_level == 3):?> Администратора<?elseif($user_access_level == 2):?>Тех.поддержки<?elseif($user_access_level == 1):?>Пользователя<?endif;?></small>
            </h3>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
            </a>
         </div>
         <div class="offcanvas-content pr-5 mr-n5">
            <div class="d-flex align-items-center mt-5">
               <div class="symbol symbol-50 mr-5">
                  <div class="symbol-label" style="background-image:url('<?php echo $url ?><?php echo $user_img ?>')"></div>
                  <i class="symbol-badge bg-success"></i>
               </div>
               <div class="d-flex flex-column">
                  <a href="javascript:;" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?php echo $user_lastname ?> <?php echo $user_firstname ?></a>
                  <div class="navi mt-1">
                     <a href="javascript:;" class="navi-item">
                     <span class="navi-link p-0 pb-2">
                     <span class="navi-text text-muted text-hover-primary"><?php echo $user_email ?></span>
                     </span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="separator separator-dashed mt-8 mb-5"></div>
            <div class="navi navi-spacer-x-0 p-0">
               <a href="/main/acc" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-danger">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3" />
                                    <path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000" />
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">Мой профиль</div>
                        <div class="text-muted">Личные данные</div>
                     </div>
                  </div>
               </a>
               <a href="/servers" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-success">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
                                    <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">Мои сервера</div>
                        <div class="text-muted">Список серверов</div>
                     </div>
                  </div>
               </a>
               <a href="/account/invoices" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-primary">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                    <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">История баланса</div>
                        <div class="text-muted">Список пополнений</div>
                     </div>
                  </div>
               </a>
               <a href="/account/waste" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-warning">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect opacity="0.200000003" x="0" y="0" width="24" height="24"/>
                                    <path d="M4.5,7 L9.5,7 C10.3284271,7 11,7.67157288 11,8.5 C11,9.32842712 10.3284271,10 9.5,10 L4.5,10 C3.67157288,10 3,9.32842712 3,8.5 C3,7.67157288 3.67157288,7 4.5,7 Z M13.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L13.5,18 C12.6715729,18 12,17.3284271 12,16.5 C12,15.6715729 12.6715729,15 13.5,15 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M17,11 C15.3431458,11 14,9.65685425 14,8 C14,6.34314575 15.3431458,5 17,5 C18.6568542,5 20,6.34314575 20,8 C20,9.65685425 18.6568542,11 17,11 Z M6,19 C4.34314575,19 3,17.6568542 3,16 C3,14.3431458 4.34314575,13 6,13 C7.65685425,13 9,14.3431458 9,16 C9,17.6568542 7.65685425,19 6,19 Z" fill="#000000"/>
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">История операций</div>
                        <div class="text-muted">Список операций</div>
                     </div>
                  </div>
               </a>
               <a href="/tickets" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-info">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3" />
                                    <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000" />
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">Мои тикеты</div>
                        <div class="text-muted">Список запросов</div>
                     </div>
                  </div>
               </a>
               <span class="navi-item mt-2">
               <span class="navi-link">
               <a href="/account/logout" class="btn btn-sm btn-light-primary font-weight-bolder py-3 px-6">Выйти</a>
               </span>
               </span>
               <?if($user_access_level > 1):?>
               <div class="separator separator-dashed mt-8 mb-5"></div>
               <a href="/admin" class="navi-item">
                  <div class="navi-link">
                     <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                           <span class="svg-icon svg-icon-md svg-icon-dark">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                 </g>
                              </svg>
                           </span>
                        </div>
                     </div>
                     <div class="navi-text">
                        <div class="font-weight-bold">Управление</div>
                        <div class="text-muted">Панель <?if($user_access_level == 3):?> Администратора<?elseif($user_access_level == 2):?> Тех.поддержки<?endif;?></div>
                     </div>
                  </div>
               </a>
               <?endif;?>
            </div>
         </div>
      </div>
      <div id="kt_quick_panel" class="offcanvas offcanvas-right p-10">
         <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Тикеты 
               <small class="text-muted font-size-sm ml-2">Список запросов</small>
            </h3>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
            <i class="ki ki-close icon-xs text-muted"></i>
            </a>
         </div>
         <div class="tab-pane fade pt-2 pr-5 mr-n5 scroll active show" id="kt_quick_panel_notifications" role="tabpanel" style="height: auto; overflow: hidden;">
            <ul class="navi navi-hover navi-active">
               <?php foreach($tickets as $item): ?>
               <li class="navi-item">
                  <a class="navi-link" href="/tickets/view/index/<?php echo $item['ticket_id'] ?>">
                     <div class="navi-text">
                        <span class="d-block font-weight-bold"><?php echo $item['ticket_name'] ?></span>
                        <span class="text-muted"><?php if($item['ticket_status'] == 0): ?> Вопрос закрыт.
                        <?php elseif($item['ticket_status'] == 1): ?> Ваш вопрос рассматривают.
                        <?php elseif($item['ticket_status'] == 2): ?> Ответ от администрации.
                        <?php endif; ?></span>
                     </div>
                     <?php if($item['ticket_status'] == 2): ?>
                     <span class="label label-light-primary font-weight-bold label-inline">new</span>
                     <?php endif; ?>
                  </a>
               </li>
               <?php endforeach; ?>
            </ul>
            <?php if(empty($tickets)): ?>
            <div class="alert alert-primary" role="alert">
               На данный момент у вас нет запросов.
            </div>
            <?php endif; ?>
         </div>
      </div>
      <div id="kt_quick_actions" class="offcanvas offcanvas-right p-10">
         <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Авторизация
               <small class="text-muted font-size-sm ml-2">История авторизации</small>
            </h3>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_actions_close">
            <i class="ki ki-close icon-xs text-muted"></i>
            </a>
         </div>
         <div class="offcanvas-content pr-5 mr-n5 scroll" style="height: auto; overflow: hidden;">
            <?php foreach($visitors as $item):?>
            <div class="d-flex align-items-center bg-light-<?php if($item['status'] == 0): ?>danger<?php elseif($item['status'] == 1): ?>success<?php elseif($item['status'] == 2): ?>warning<?php endif; ?>	 rounded p-5 mb-9">
               <div class="d-flex flex-column flex-grow-1 mr-2">
                  <a href="/main/acc" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">IP: <?php echo $item['ip'] ?></a>
                  <span class="text-muted font-weight-bold"><?php if($item['status'] == 0): ?>
                  Попытка входа в аккаунт -
                  <?php elseif($item['status'] == 1): ?>
                  Вход в аккаунт - 
                  <?php elseif($item['status'] == 2): ?>
                  Выход с аккаунта -
                  <?php endif; ?> 
                  <?php echo date("d.m.Y в H:i", strtotime($item['datetime'])) ?></span>
               </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($visitors)): ?>
            <span class="m-widget14__desc">
               <center>У вас нет активов.</center>
            </span>
            <?php endif; ?>
         </div>
      </div>
      <!--begin::Modal-->
      <div class="modal fade" id="hostin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
                  </button>
               </div>
               <form id="samirForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
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
      <!--end::Modal-->
      <div id="kt_scrolltop" class="scrolltop">
         <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
               <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24" />
                  <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                  <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
               </g>
            </svg>
         </span>
      </div>
      <script>
         function sendActionn(action) {
            $.ajax({ 
               url: '/theme/theme/'+action,
               dataType: 'text',
               success: function(data) {
                  console.log(data);
                  data = $.parseJSON(data);
                  switch(data.status) {
                     case 'error':
                        toastr.error(data.error);
                        break;
                     case 'success':
                        toastr.success(data.success);
                        setTimeout("reload()", 1500);
                        break;
                  }
               },
               beforeSend: function(arr, options) {
                  toastr.warning("Проверка данных стиля, ожидайте...");     
                  $('button[type=submit]').prop('disabled', true);            
               }
            });
         }
      </script>
	
      
      <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>

      <script src="/assets/js/darkjs/plugins.bundle.js"></script>
      <script src="/assets/js/darkjs/prismjs.bundle.js"></script>
      <script src="/assets/js/darkjs/scripts.bundle.js"></script>
      <script src="/application/public/js/main.js"></script>
      <script src="/application/public/js/jquery.form.min.js"></script>
      <script src="/assets/js/darkjs/fullcalendar.bundle.js"></script>
      <script src="/assets/js/darkjs/widgets.js"></script>
	  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
	  <script src="http://fphosting.free-plums.ru/js_google-translate.js"></script>
	  <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>	
	        <script src="/assets/js/translate.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
   </body>
</html>
<?php if(isset($error)): ?><script>toastr.error('<?php echo $error ?>');</script><?php endif; ?> 
<?php if(isset($warning)): ?><script>toastr.warning('<?php echo $warning ?>');</script><?php endif; ?> 
<?php if(isset($success)): ?><script>toastr.success('<?php echo $success ?>');</script><?php endif; ?>