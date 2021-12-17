<?php include('header.php');?>
<?php
$id = $_GET['id'];
$product = getData('product_detail',$id);
$products = $product['data'];
/*echo "<pre>"; print_r($products); die;
*/?>

<?php
$data = array(
   'table' => 'ci_banners',
   'where' => 'is_active=1'
);
$bannerData = postData('listing',$data);

?>



<div class="page-title-area" style="background-image:url(<?=ADMIN_PATH.$bannerData['data'][1]['image'];?>);">
	<div class="container">
		<div class="page-title-content text-center">
			<h2><?=$products['name']?></h2>
			<ul>
				<li><a href="<?=BASE_PATH?>index">Home</a></li>
				<li><?=$products['name']?></li>
			</ul> </div>
		</div>
	</div>

	<div class="services-details-area ptb-110 ">
		<div class="container">
			<div data-elementor-type="wp-post" data-elementor-id="149" class="elementor elementor-149" data-elementor-settings="[]">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-a473328 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="a473328" data-element_type="section">
							<div class="elementor-container elementor-column-gap-no">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-c96d259" data-id="c96d259" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-ec47910 elementor-widget elementor-widget-single-service-widget" data-id="ec47910" data-element_type="widget" data-widget_type="single-service-widget.default">
													<div class="elementor-widget-container">

														<div class="services-details-overview">
															<div class="services-details-image">
																<img class="smartify" sm-src="<?=ADMIN_PATH.$products['image']?>" width="300" height="200" alt=""/>
															</div>
															<div class="services-details-desc text-left">
																<h3><?=$products['meta_title']?></h3>
																<p class="p" style="text-align: justify;"><?=mb_strimwidth($products['sort_description'],0,100,"...")?></p>
																
																<ul class="features-list">
																	<li><i class="bx bx-check-double"></i><p style="text-align: justify;"><?=$products['description']?></p></li>
																</ul> </div>

																<div class="nav-side col-md-4 col-sm-12 col-xs-12">
                                                             <div class="inner">
                                                           <h2>Product Inquery</h2>
                                                           <div class="link-box"><a href="<?=BASE_PATH?>product_inquery?id=<?=$products['id']?>" class="btn btn-primary">Inquery Here</a></div>
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
		</div>

		<?php include('footer.php');?>
