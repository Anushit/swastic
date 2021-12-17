<?php require_once('config.php');


$servicedata = array(
      'table' => 'ci_services', 
      'where' => 'is_active=1'
      
    );
$service = postData('listname',$servicedata);

$filter = array(
        'table'=>'ci_products',
        'where'=> 'is_active=1'

    ); 
$prod = postData('listname', $filter);

$phone = $email = $address = $logo = "";

$header = getData('setting');
if(isset($header['data']['meta_title']) && !empty($header['data']['meta_title'])){
    $meta_title = $header['data']['meta_title'];
}
if(isset($header['data']['meta_keyword']) && !empty($header['data']['meta_keyword'])){
    $meta_keyword = $header['data']['meta_keyword'];
}
if(isset($header['data']['favicon']) && !empty($header['data']['favicon'])){
    $icon = $header['data']['favicon'];
}
if(isset($header['data']['logo']) && !empty($header['data']['logo'])){
    $logo = $header['data']['logo'];
}
if(isset($header['data']['phone']) && !empty($header['data']['phone'])){
    $phone = $header['data']['phone'];
}
if(isset($header['data']['address']) && !empty($header['data']['address'])){
    $address = $header['data']['address'];
}
if(isset($header['data']['email']) && !empty($header['data']['email'])){
    $email = $header['data']['email'];
}
?>

<!doctype html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title><?=$meta_title?></title>
    <meta name='robots' content='max-image-preview:large' />  
<link rel='stylesheet' id='font-awesome-4.7-css' href='<?=BASE_PATH?>wp-content/plugins/alpas-toolkit/assets/css/font-awesome.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='alpas-style-css' href='<?=BASE_PATH?>wp-content/themes/alpas/style9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='vendors-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/vendors.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='fontawesome-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/fontawesome.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='boxicons-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/boxicons.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='flaticon-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/flaticon9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='alpas-main-style-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/style.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel="stylesheet" href="css/style.css">
<link rel='stylesheet' id='alpas-responsive-css' href='<?=BASE_PATH?>wp-content/themes/alpas/assets/css/responsive.min9f31.css?ver=5.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='alpas-fonts-css' href='https://fonts.googleapis.com/css?family=Dosis%3A400%2C500%2C600%2C700%2C800%7COpen+Sans%3A400%2C600%2C600i%2C700%2C800&amp;ver=1.0.0' type='text/css' media='screen' />
<link rel='stylesheet' id='google-fonts-1-css' href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;display=auto&amp;ver=5.7.2' type='text/css' media='all' />
<script src='<?=BASE_PATH?>wp-includes/js/jquery/jquery.min9d52.js?ver=3.5.1' id='jquery-core-js'></script>
<script src='<?=BASE_PATH?>wp-includes/js/jquery/jquery-migrate.mind617.js?ver=3.3.2' id='jquery-migrate-js'></script>
<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/vendors.min68b3.js?ver=1' id='vendors-js'></script>
<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/jquery.smartify68b3.js?ver=1' id='jquery-smartify-js'></script>
<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/smartify68b3.js?ver=1' id='alpas-smartify-js'></script>
<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/main.min68b3.js?ver=1' id='alpas-main-js'></script>
<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/vendors.min68b3.js?ver=1' id='vendors-js'></script>
<script type='text/javascript' id='alpas-main-js-extra'>
var dateData = {"endTime":"12\/07\/2024"};
</script>
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?=BASE_PATH?>wp-includes/wlwmanifest.xml" />
<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style><link rel="icon" href="<?=ADMIN_PATH.$icon?>" sizes="32x32" />
<link rel="icon" href="<?=ADMIN_PATH.$icon?>" sizes="192x192" />
<link rel="apple-touch-icon" href="<?=ADMIN_PATH.$icon?>" />
<meta name="msapplication-TileImage" content="https://themes.envytheme.com/alpas/wp-content/uploads/2019/11/favicon-5.png" />
<style type="text/css" title="dynamic-css" class="options-output">body{font-size:14px;}.evolta-nav .navbar .navbar-nav .nav-item a{font-size:17px;}.copyright-area ul li{font-size:14px;}
</style>
</head>

<body class="home page-template page-template-elementor_header_footer page page-id-12 theme-alpas woocommerce-no-js no-sidebar elementor-default elementor-template-full-width elementor-kit-669 elementor-page elementor-page-12">

    <div class="preloader">
        <div class="spinner">
        </div>
    </div>


    <header class="header-area ">
        <div class="top-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="header-left-content">
                            <p><?=$meta_keyword?></p>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="header-right-content">
                         <ul>
                            <li class="<?php echo($phone !="")?"":"hide"?>">
                                <a href="tel:<?=$phone?>">
                                    <i class='fa fa-phone<?php echo($phone !="")?"":"hide"?>'></i>
                                    <?=$phone?></a>
                                </li>
                                <li class="<?php echo($address !="")?"":"hide"?>">
                                    <i class='fa fa-location-arrow<?php echo($address !="")?"":"hide"?>'></i>
                                    <?=$address?></li>
                                    <li class="<?php echo($email !="")?"":"hide"?>">
                                        <a href="mailto:<?=$email?>">
                                            <i class='fa fa-envelope-o<?php echo($email !="")?"":"hide"?>'></i>
                                            <?=$email?></li>
                                            <li></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-area">
                        <div class="evolta-responsive-nav">
                            <div class="container">
                                <div class="evolta-responsive-menu">
                                    <div class="logo<?php echo($logo !="")?"":"hide"?>">
                                        <a href="<?=BASE_PATH?>index">
                                            <img src="<?=ADMIN_PATH.$logo?>" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <div class="evolta-nav" style="background: #1d1777;">
                        <div class="container-fluid" >
                            <nav class="navbar navbar-expand-md navbar-light">
                                <a class="navbar-brand" href="<?=BASE_PATH?>index">
                                    <img src="<?=ADMIN_PATH.$logo?>" alt="swastic"></a>
                                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                        <div class="menu-header-menu-container"><ul id="menu-header-menu" class="navbar-nav"><li id="menu-item-32" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-12 current_page_item active menu-item-32 nav-item"><a title="Home" href="<?=BASE_PATH?>index" class="nav-link">Home</a></li>
                                        <li id="menu-item-33" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33 nav-item"><a title="About Us" href="<?=BASE_PATH?>about" class="nav-link">About Us</a></li>
                                        
                                        <li id="menu-item-46" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children dropdown menu-item-46 nav-item"><a title="Services" href="<?=BASE_PATH?>service" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-46">Services</a>
                                        <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-46" role="menu">
                                        <?php foreach($service['data'] as $serviceData){ ?>
                                        <li><a href="<?=BASE_PATH?>service_detail?id=<?=$serviceData['id'];?>"><?=$serviceData['name'];?></a></li>
                                        <?php }?>
                                        </ul>
                                        </li>
                                        <li id="menu-item-34" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children dropdown menu-item-34 nav-item"><a title="Pages" href="<?=BASE_PATH?>products" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link" id="menu-item-dropdown-34">Products</a>
                                        <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-34" role="menu">
                                        <?php if(!empty($prod['data'])){ 
                                       foreach ($prod['data'] as $product) { ?>
                                        <li><a href="<?=BASE_PATH?>product_detail?id=<?=$product['id']?>"><?=$product['name']?></a>
                                         </li>

                                      <?php }}?>
                                         </ul>
                                       </li>
                                        <li id="menu-item-51" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-51 nav-item"><a title="Contact" href="<?=BASE_PATH?>contact" class="nav-link">Contact</a></li>
                                        </ul>
                                    </div>
                                   <div class="others-options">
                                     <div class="option-item"><i class="search-btn flaticon-search"></i>
                                        <i class="close-btn fas fa-times"></i>
                                        <div class="search-overlay search-popup">
                                            <div class='search-box'>
                                                <form role="search" method="get" id="searchform" class="search-form" action="<?=BASE_PATH?>products">
                                                  <input type="text" class="search-input" name="search" id="s" placeholder="Search For Products" required />
                                                  <button type="submit" id="searchsubmit" class="search-button"><i class="fas fa-search"></i></button>
                                              </form>
                                          </div>
                                      </div>
                                </div>
                            </nav>
                        </div>
                    </div>
               </div>
        </header>