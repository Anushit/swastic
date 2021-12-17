<?php include('header.php');?>
<?php 

  $servicedata = array(
      'select' => 'id,slug,name,image,sort_description',
      
    );
$service = postData('service',$servicedata);

$data = array(
   'table' => 'ci_banners',
   'where' => 'is_active=1'
);
$bannerData = postData('listing',$data);

?>


<div class="page-title-area" style="background-image:url(<?=ADMIN_PATH.$bannerData['data'][1]['image'];?>);">
	<div class="container">
		<div class="page-title-content text-center">
			<h2>Services</h2>
			<ul>
				<li><a href="<?=BASE_PATH?>index">Home</a></li>
				<li>Services</li>
			</ul> </div>
		</div>
	</div>
<div class="page-area ">
<article id="post-24" class="post-24 page type-page status-publish has-post-thumbnail hentry">
	<div class="entry-content">
	<div data-elementor-type="wp-page" data-elementor-id="24" class="elementor elementor-24" data-elementor-settings="[]">
	<div class="elementor-inner">
	<div class="elementor-section-wrap">
	<section class="elementor-section elementor-top-section elementor-element elementor-element-dc96449 elementor-section-stretched elementor-section-full_width  bg-fafafa elementor-section-height-default elementor-section-height-default" data-id="dc96449" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
	<div class="elementor-container elementor-column-gap-no">
		<div class="elementor-row">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9ef2899" data-id="9ef2899" data-element_type="column">
		<div class="elementor-column-wrap elementor-element-populated">
		<div class="elementor-widget-wrap">
		<div class="elementor-element elementor-element-d539fb2 elementor-widget elementor-widget-service-widget" data-id="d539fb2" data-element_type="widget" data-widget_type="service-widget.default">
        <div class="elementor-widget-container">
		<div class="services-area ptb-110">
		<div class="container">
			<div class="row">
			<?php if(checkdata($service)){ 
				$i=0;
				foreach ($service['data'] as $serviceData) { 
				if($i==3){ echo '</div> <div class="row">'; $i=0; }?>
				<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="single-services-box text-left">
			<div class="icon">

			<div class="icon-bg" style="text-align: center;">
			<img class="smartify" sm-src="<?=getimage($serviceData['image'],'noimage.png')?>" width="100" height="100"alt="" alt="Shape" />
		</div> 
		</div><br><br>
		<h3 style="text-align: center;"> <a href="<?=BASE_PATH?>service_detail?id=<?=$serviceData['id']?>" target="_blank"><?=$serviceData['name']?></a> </h3>
		<p style="text-align: center;"><?=mb_strimwidth($serviceData['sort_description'],0,100,"...")?></p>
	</div>
</div>
<?php $i++; }} ?>
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
</div>
</div>
</div>
</div>
</article>
</div>

<?php include('footer.php');?>


