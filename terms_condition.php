<?php include('header.php');?>
<?php 
$terms_setting = getData('cms',5);

$data = array(
   'table' => 'ci_banners',
   'where' => 'is_active=1'
);
$bannerData = postData('listing',$data);

?>

<div class="page-title-area" style="background-image:url(<?=ADMIN_PATH.$bannerData['data'][1]['image'];?>););">
	<div class="container">
		<div class="page-title-content text-center">
			<h2><?=$terms_setting['data']['cms_title']?></h2>
			<ul>
				<li><a href="<?=BASE_PATH?>index">Home</a></li>
				<li><?=$terms_setting['data']['meta_title']?></li>
			</ul> </div>
		</div>
	</div>
<div class="page-main-content  ">

<div class="page-area ">
<div class="container">
<article id="post-289" class="post-289 page type-page status-publish has-post-thumbnail hentry">
<div class="entry-content">
<h3 id="mce_0"><?=$terms_setting['data']['meta_keyword'];?></h3>
<p class="text-justify"><?=$terms_setting['data']['meta_description'];?></p>
<p class="text-justify"><?=$terms_setting['data']['cms_contant'];?></p>

</div>
</article>
</div>
</div>
</div>


<?php include('footer.php');?>


