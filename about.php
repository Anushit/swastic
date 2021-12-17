<?php include('header.php');?>
<?php 
$filter = array(
            'table'=>'ci_cms',
            'order'=>'asc',
            'start'=>'0',
            'limit'=>'3',
            'where'=> 'is_active=1 && cms_name="About Us"'
        );  
    $aboutData = postData('listing', $filter);

$data = array(
   'table' => 'ci_banners',
   'where' => 'is_active=1'
  
);
$bannerData = postData('listing',$data);

$filter = array(
            'table'=>'ci_teams',
            'sort' => 'sort_order',
            'order'=>'asc',
            'start'=>'0',
            'limit'=>'10',
            'where'=> 'is_active=1'
        );  
        $teamData = postData('listing', $filter);
?>


<div class="page-title-area" style="background-image:url(<?=ADMIN_PATH.$bannerData['data'][1]['image'];?>);">
	<div class="container">
		<div class="page-title-content text-center">
			<h2>About Us</h2>
			<ul>
				<li><a href="<?=BASE_PATH?>index">Home</a></li>
				<li>About Us</li>
			</ul> </div>
		</div>
	</div>

	<div class="page-area">
<article id="post-14" class="post-14 page type-page status-publish has-post-thumbnail hentry">
<div class="entry-content">
<div data-elementor-type="wp-page" data-elementor-id="14" class="elementor elementor-14" data-elementor-settings="[]">
<div class="elementor-inner">
<div class="elementor-section-wrap">

    <section class="elementor-section elementor-top-section elementor-element elementor-element-197e918 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default ptb-110" data-id="197e918" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-row">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-15e2d97" data-id="15e2d97" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-931b0b3 elementor-widget elementor-widget-about-us-widget" data-id="931b0b3" data-element_type="widget" data-widget_type="about-us-widget.default">
                                <div class="elementor-widget-container">

                                    <div class="about-area">
                                        <div class="container">
                                                <div class=" about-content text-left pb-110">
                                                    <span >ABOUT US</span>
                                                    <h2 style="text-align: center;">Swastic Fintech Pvt. Ltd.</h2>
                                                </div>
                                                <?php if(!empty($aboutData['data'])){ 
                                                            foreach ($aboutData['data'] as  $aboutvalue) {  ?>
                                                <div class="col-lg-12 col-md-15 single-team-box">
                                                    <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                                        <div class="">
                                                            <p class="text-justify"><?=$aboutvalue['cms_contant'] ?></p> 
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                                        <div class="single-team-box">
                                                            <div class="image" style="height: 240px;">
                                                                <img class="smartify" sm-src="<?=ADMIN_PATH.$aboutvalue['cms_banner'] ?>"alt="image" />
                                                            </div>
                                                            <div class="content">
                                                                <h3><?=$aboutvalue['cms_title'] ?></h3>
                                                                <span><?=$aboutvalue['meta_title'] ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <?php }} ?>
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
        </section>

	<section class="elementor-section elementor-top-section elementor-element elementor-element-197e918 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="197e918" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
<div class="elementor-container elementor-column-gap-no">
<div class="elementor-row">
<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-15e2d97" data-id="15e2d97" data-element_type="column">
<div class="elementor-column-wrap elementor-element-populated">
<div class="elementor-widget-wrap">
<div class="elementor-element elementor-element-e4ece98 elementor-widget elementor-widget-teams-widget" data-id="931b0b3" data-element_type="widget" data-widget_type="about-us-widget.default">
<div class="elementor-widget-container">

<div class="container">
    <div class="section-title">
        <h2>Meet Our Team</h2>
        <p class="p"></p> </div>
        <div class="row">
            <?php if(!empty($teamData['data'])){ 
            	$i=0;
                foreach ($teamData['data'] as $teamvalue) {  
                	if($i==4){ echo '</div> <div class="row">'; $i=0; }?>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-team-box">
                    <div class="image" style="height: 240px;">
                        <img class="smartify" sm-src="<?=ADMIN_PATH.$teamvalue['image'] ?>" alt="image" />

                        
                    </div>
                    
                    <div class="content">
                        <h3><?=$teamvalue['name'] ?></h3>
                        <span><?=$teamvalue['designation'] ?></span>
                    </div>
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
</section>
							</div>
			            </div>
		           </div>
	          </div>
       </article>
    </div>

<?php include('footer.php');?>

								