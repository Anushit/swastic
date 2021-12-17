<?php include('header.php');?>
<?php
$data = array(
   'table' => 'ci_banners',
   'start' => '0',
   'limit'=>'1',
   'where' => 'is_active=1'
);
$bannerData = postData('listing',$data);

$cmsdata = getData('cms',2);
$sitedata = getData('sideimage',1);
$siteimage = getData('sideimage',2);
$homeimage = getData('sideimage',3);

$servicedata = array(
       'select' => 'id,slug,name,icon,sort_description',
     
    );
$service = postData('service',$servicedata);
$filter = array(
            'sort'=>'sort_order',
            'start'=>'0',
            'limit'=>'3',
            'where' =>'is_active=1'
        );  
$product = postData('productlist',$filter);
?>

<div data-elementor-type="wp-page" data-elementor-id="12" class="elementor   elementor-12" data-elementor-settings="[]">
    <div class="elementor-inner">
        <div class="elementor-section-wrap">

            <section class="elementor-section elementor-top-section elementor-element elementor-element-5aadea5 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="5aadea5" data-element_type="section">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-row">
                        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-dba98a7" data-id="dba98a7" data-element_type="column">
                            <div class="elementor-column-wrap elementor-element-populated">
                                <div class="elementor-widget-wrap">
                                    <div class="elementor-element elementor-element-79c7a1f elementor-widget elementor-widget-alpas-banner-widget" data-id="79c7a1f" data-element_type="widget" data-widget_type="alpas-banner-widget.default">
                                        <div class="elementor-widget-container">

                                            <div class="main-banner">
                                                <?php if(checkdata($bannerData)){ ?>
                                                <div class="d-table">
                                                    <div class="d-table-cell">
                                                        <div class="container-fluid">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-6 col-md-12">
                                                                    <div class="main-banner-content text-left">
                                                                        <span></span>
                                                                        <h1><?=$bannerData['data'][0]['title_first']?></h1>
                                                                        <p class="p"><?=$bannerData['data'][0]['title_second']?></p>
                                                                        <a target="_blank" href="<?=BASE_PATH?>contact" class="btn btn-primary">Get Started</a> </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-12">
                                                                        <div class="main-banner-image">
                                                                            <img class="smartify" sm-src="<?=getimage($bannerData['data'][0]['image'],'noimage.png')?>" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="banner-shape">
                                                        <img class="smartify" sm-src="<?=getimage($bannerData['data'][0]['image1'],'noimage.png')?>" alt="Shape" />
                                                    </div>
                                                    <div class="shape1">
                                                        <img class="smartify" sm-src="<?=getimage($bannerData['data'][0]['image2'],'noimage.png')?>" alt="Shape" />
                                                    </div>
                                                    <div class="shape2">
                                                        <img class="smartify" sm-src="<?=getimage($bannerData['data'][0]['image3'],'noimage.png')?>" alt="Shape" />
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> 

                <section class="elementor-section elementor-top-section elementor-element elementor-element-a0782e7 elementor-section-full_width bg-f7f9fc elementor-section-height-default elementor-section-height-default" data-id="a0782e7" data-element_type="section">
                    <div class="elementor-container elementor-column-gap-no">
                         <div class="elementor-row">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-dc6b993" data-id="dc6b993" data-element_type="column">
                                        <div class="elementor-column-wrap elementor-element-populated">
                                            <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-25e1c2b elementor-widget elementor-widget-feature-widget" data-id="25e1c2b" data-element_type="widget" data-widget_type="feature-widget.default">
                                                    <div class="elementor-widget-container">

                                                        <div class="features-area ptb-110">
                                                            <div class="container"> <div class="overview-box">
                                                                <div class="image wow zoomIn" data-wow-delay="1s">
                                                                    <img class="smartify" sm-src="<?=getimage($sitedata['data']['image'],'noimage.png')?>" alt="image" />
                                                                </div>
                                                                <div class="content text-left">
                                                                    <?=$cmsdata['data']['cms_contant']?>
                                                                     </div>
                                                                </div> 
                                                                </div>
                                                                <div class="rectangle-shape1">
                                                                    <img class="smartify" sm-src="<?=getimage($homeimage['data']['image'],'noimage.png')?>" alt="Shape" />
                                                                </div>
                                                                <div class="rectangle-shape2">
                                                                    <img class="smartify" sm-src="<?=getimage($homeimage['data']['image'],'noimage.png')?>" alt="Shape" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                           
        <section class="elementor-section elementor-top-section elementor-element elementor-element-9cba4f3 elementor-section-full_width  bg-fafafa service-pb-0 elementor-section-height-default elementor-section-height-default" data-id="9cba4f3" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
          <div class="elementor-container elementor-column-gap-no">
             <div class="elementor-row">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2ac1226" data-id="2ac1226" data-element_type="column">
                 <div class="elementor-column-wrap elementor-element-populated">
                     <div class="elementor-widget-wrap">
                         <div class="elementor-element elementor-element-a017862 elementor-widget elementor-widget-service-widget" data-id="a017862" data-element_type="widget" data-widget_type="service-widget.default">
                         <div class="elementor-widget-container">
                         <div class="services-area ptb-110">
                         <div class="container">
                         <div class="section-title">
                       <h2>See wide range of our services</h2>
                        </div> 
                        <div class="row">
                            <?php if(checkdata($service)){ 
                             $i=0;
                           foreach ($service['data'] as $serviceData) { 
                  if($i==4){ echo '</div> <div class="row">'; $i=0; }  ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                         <div class="single-services-box text-left">
                         <div class="icon">
                       <div class="icon-bg" style="text-align: center;">
                          <img class="smartify" sm-src="<?=getimage($serviceData['icon'],'noimage.png') ?>" height="50px" width="50px" alt="Shape" />
                       </div><br> 
                        </div>
                       <h3 style="text-align: center;"> <a href="<?=BASE_PATH?>service_detail?id=<?=$serviceData['id']?>" target="_blank"><?=$serviceData['name']?></a> </h3>
                        <p style="text-align: center;"><?=mb_strimwidth($serviceData['sort_description'],0,50,"...")?></p>
                    </div>
                   </div>
               <?php $i++; }}?>
                </div>
            </div>     
            </div> 
        </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
 <section class="elementor-section elementor-top-section elementor-element elementor-element-9cba4f3 elementor-section-full_width  bg-fafafa service-pb-0 elementor-section-height-default elementor-section-height-default" data-id="9cba4f3" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
          <div class="elementor-container elementor-column-gap-no">
             <div class="elementor-row">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2ac1226" data-id="2ac1226" data-element_type="column">
                 <div class="elementor-column-wrap elementor-element-populated">
                     <div class="elementor-widget-wrap">
                         <div class="elementor-element elementor-element-a017862 elementor-widget elementor-widget-service-widget" data-id="a017862" data-element_type="widget" data-widget_type="service-widget.default">
                         <div class="elementor-widget-container">
                         <div class="services-area ptb-110">
                         <div class="container">
                         <div class="section-title">
                       <h2>Our Products</h2>
                        </div> 
                        <div class="row">
                            <?php if(checkdata($product)){ 
                             $i=0;
                           foreach ($product['data'] as $productData) { 
                  if($i==4){ echo '</div> <div class="row">'; $i=0; }  ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                         <div class="single-services-box text-left">
                         <div class="icon">
                       <div class="icon-bg" style="text-align: center;">
                          <img class="smartify" sm-src="<?=getimage($productData['image'],'noimage.png') ?>" height="50px" width="50px" alt="Shape" />
                       </div><br> 
                        </div>
                       <h3 style="text-align: center;"> <a href="<?=BASE_PATH?>product_detail?id=<?=$productData['id']?>" target="_blank"><?=$productData['name']?></a> </h3>
                        <p style="text-align: center;"><h4 style="text-align: center;">Offer Price <?=$productData['special_price']?></h4></p>
                    </div>
                   </div>
               <?php $i++; }}?>
                </div>
            </div>     
            </div> 
        </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
<div class="elementor-section elementor-top-section elementor-element elementor-element-99cf96e elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="99cf96e" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
    <div class="elementor-container elementor-column-gap-no">
        <div class="elementor-row">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-be981cb" data-id="be981cb" data-element_type="column">
                <div class="elementor-column-wrap elementor-element-populated">
                    <div class="elementor-widget-wrap">
                        <div class="elementor-element elementor-element-59972ef elementor-widget elementor-widget-newsletter-widget" data-id="59972ef" data-element_type="widget" data-widget_type="newsletter-widget.default">
                            <div class="elementor-widget-container">

                                <div class="subscribe-area">
                                    <div class="container">
                                        <div class="row align-items-center">
                                         <div class="col-lg-5 col-md-12">
                                                <div class="newsletter-content">
                                                    <h2>Signup to the free newsletter</h2>
                                                    <form method="post"> 
                                                        <input type="email" class="input-newsletter" placeholder="Enter your email address" name="email" id="email"  required/> 
                                                        <button type="button" name="submit" onclick="submitForm()"> Subscribe <i class="flaticon-paper-plane"></i> </button>
                                                        <p class="mchimp-errmessage" style="display: none;"></p>
                                                        <p class="mchimp-sucmessage" style="display: none;"></p>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-12">
                                                <div class="subscribe-contact-info">
                                                    <img class="smartify" sm-src="<?=getimage($siteimage['data']['image'],'noimage.png')?>" alt="image"/>
                                                    <div class="content text-center">
                                                        <h2>Have any questions?</h2>
                                                        <span>Call:<a href="tel:<?=$phone?>"><?=$phone?></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php include('footer.php');?>

<script type="text/javascript">

function submitForm() {
  
    var formdata = new FormData();
     formdata.append('type', '1');
  formdata.append('email', jQuery("#email").val());
  
  jQuery.ajax({
    type: "POST",
    url: "<?=BASE_PATH?>singup",
    data: formdata,
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
   jQuery(data).notify("newsletter SuccessFull!");
      jQuery('#email').val("");

    }
  });
  return false;
}
</script>