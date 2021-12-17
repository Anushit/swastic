<?php require_once('config.php');

$footer = getData('setting');

 
if(isset($footer['data']['sticky_logo']) && !empty($footer['data']['sticky_logo'])){
    $logo = $footer['data']['sticky_logo'];
}
if(isset($footer['data']['phone']) && !empty($footer['data']['phone'])){
    $phone = $footer['data']['phone'];
}
if(isset($footer['data']['address']) && !empty($footer['data']['address'])){
    $address = $footer['data']['address'];
}
if(isset($footer['data']['email']) && !empty($footer['data']['email'])){
    $email = $footer['data']['email'];
}
if(isset($footer['data']['meta_description']) && !empty($footer['data']['meta_description'])){
    $meta_description = $footer['data']['meta_description'];
}

if(isset($footer['data']['whatsapp_button']) && !empty($footer['data']['whatsapp_button'])){
    $whatsapp_button = $footer['data']['whatsapp_button'];
}

$facebook_link = $footer['data']['facebook_link'];
$twitter_link = $footer['data']['twitter_link'];
$instagram_link = $footer['data']['instagram_link'];

$servicedata = array(
      'table' => 'ci_services', 
      'where' => 'is_active=1'
      
    );
$service = postData('listname',$servicedata);
$footerimage = getData('sideimage',3);
$terms_setting = getData('cms',5);
?>


<footer class="footer-area ">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="single-footer-widget">
					<div class="logo<?php echo ($logo != "")?"":"hide"; ?>">
						<a href="<?=BASE_PATH?>index">
							<img src="<?=ADMIN_PATH.$logo?>" alt="swastic" width="150" height="100"></a>
							<p class="p-0 text-justify"><?=$meta_description?></p> 
					</div>
							<ul class="social">
								<li <?php if (empty($facebook_link)){?>style="display:none"<?php }?>><a href="<?=$facebook_link?>" target="_blank"><i class="flaticon-facebook-letter-logo"></i> </a>
								</li>
								<li  <?php if (empty($twitter_link)){?>style="display:none"<?php }?>><a href="<?=$twitter_link?>" target="_blank"><i class="flaticon-twitter-black-shape"></i></a>
								</li>
								<li <?php if (empty($instagram_link)){?>style="display:none"<?php }?>><a href="<?=$instagram_link?>" target="_blank"><i class="flaticon-instagram-logo<?php echo($instagram_link != "")?"":"hide";?>"></i> </a>
								</li>
						     </ul>
				</div>
			</div>
				<div class="single-footer-widget col-lg-3 col-md-3 col-sm-3 widget_nav_menu"><h3 class="footer-wid-title">Services</h3>
					<div class="menu-footer-menu-one-container">
						<ul id="menu-footer-menu-one" class="menu">
                        <?php foreach($service['data'] as $serviceData){ ?>
                                        <li><a href="<?=BASE_PATH?>service_detail?id=<?=$serviceData['id'];?>"><?=$serviceData['name'];?></a></li>
                         <?php }?>
				</ul>
			</div>
		</div>
		<div class="single-footer-widget col-lg-3 col-md-3 col-sm-3 widget_text"><h3 class="footer-wid-title">Contacts</h3> 
			<div class="textwidget">
				<ul class="footer-contact-list">
					<li <?php if (empty($address)){?>style="display:none"<?php } ?>><span class="span">Address:</span><?=$address?></li>
					<li <?php if (empty($email)){?>style="display:none"<?php } ?>><span class="span">Email:</span> <a><?=$email?></span></a></li>
					<li <?php if (empty($phone)){?>style="display:none"<?php } ?>><span class="span<?php echo($phone != "")?"":"hide"?>">Phone:</span> <a href="tel:<?=$phone?>"><?=$phone?></a></li>
					
				</ul>
			</div>
		</div> 
		<div class="single-footer-widget col-lg-3 col-md-3 col-sm-3 widget_nav_menu"><h3 class="footer-wid-title">Quick Links</h3><div class="menu-footer-menu-two-container"><ul id="menu-footer-menu-two" class="menu"><li id="menu-item-283" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-283"><a href="<?=BASE_PATH?>about">About Us</a></li>
					<li id="menu-item-285" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-285"><a href="<?=BASE_PATH?>service">Services</a></li>
					<li id="menu-item-284" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-284"><a href="<?=BASE_PATH?>contact">Contact</a></li>
				</ul>
			</div>
		</div>
	
	</div>
	</div>
	<div class="copyright-area ">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<p>
						<?=$footer['data']['copyright']?>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="menu-footer-bottom-menu-container">
							<ul id="footer-bottom-menu-one" class="menu">
							<li id="menu-item-294" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-294"><b> Developed By : </b> <a href="https://adiyogitechnosoft.com" target="_blank"> Adiyogi Technosoft</a>
							</li>
							
							<li id="menu-item-294" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-294"><a href="<?=BASE_PATH?>terms_condition"><?=$terms_setting['data']['meta_title']?></a>
							</li>

						</ul></div> 
					</div>
					
					</div>
				</div>
			</div>
			<div class="circle-map "><img class="smartify" sm-src="<?=ADMIN_PATH.$footerimage['data']['image']?>" alt="Alpas"></div>
			<div class="lines">
				<div class="line"></div>
				<div class="line"></div>
				<div class="line"></div>
			</div>
		</footer>

        <div class="<?php echo ($whatsapp_button != "")?"":"hide"; ?>">
         <?=$whatsapp_button?>
        </div>

		<div class="go-top"><i class="fas fa-arrow-up"></i><i class="fas fa-arrow-up"></i></div>
		<script src='https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js' >
		</script>	
       <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></
		</script>
		<script src='<?=BASE_PATH?>wp-content/themes/alpas/assets/js/notify.min.js'></script>
		
		</body>
	</html>