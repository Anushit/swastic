<?php include('header.php');?>
<?php 
if(isset($_POST['submit'])){ 
        $msg = '';
        $error = '';
        
        if($error==''){
            $data = $_POST;  
            $contactData = postData('saveinquery', $data);  
            $msg = $contactData['message'];
        } 
} 

$contactimage = getData('sideimage',2);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$product = getData('product_detail',$id);
$productInquery = $product['data'];


$data = array(
   'table' => 'ci_banners',
   'where' => 'is_active=1'
);
$bannerData = postData('listing',$data);
?>



<div class="page-title-area" style="background-image:url(<?=ADMIN_PATH.$bannerData['data'][1]['image'];?>);">
    <div class="container">
        <div class="page-title-content text-center">
            <h2>Inquery Here</h2>
            <ul>
                <li><a href="<?=BASE_PATH?>index">Home</a></li>
                <li>Product Inquiry</li>
            </ul> </div>
        </div>
    </div>


<div class="page-area ">
<article id="post-28" class="post-28 page type-page status-publish has-post-thumbnail hentry">
<div class="entry-content">
<div data-elementor-type="wp-page" data-elementor-id="28" class="elementor elementor-28" data-elementor-settings="[]">
<div class="elementor-inner">
<div class="elementor-section-wrap">
    <section class="elementor-section elementor-top-section elementor-element elementor-element-fe01e58 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="fe01e58" data-element_type="section">

        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-row">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-c619884" data-id="c619884" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                            <div class="elementor-element elementor-element-3da1ce0 elementor-widget elementor-widget-contact-widget" data-id="3da1ce0" data-element_type="widget" data-widget_type="contact-widget.default">
                                <div class="elementor-widget-container">
                                    <div class="contact-area ptb-110">
                                        <div class="container">

                                            <div style="background-color: white; border:0;">
                                                    <?php  
                                                        if(!empty($error)){
                                                            echo "<div class='alert alert-danger text-center'>".$error."</div>";
                                                        } 
                                                        if(!empty($msg)){
                                                            echo "<div class='alert alert-success text-center'>".$msg."</div>";
                                                        } 
                                                    ?>
                                                    </div> 
                         
                                            <div class="section-title">
                                                
                                                <span>Inquiry Here</span>
                                                <h2>Inquery For <?=$productInquery['name']?></h2>
                                            </div>
                                                
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="contact-image">
                                                        <img class="smartify" sm-src="<?=getimage($contactimage['data']['image'],'noimage.png')?>" alt="image" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8">
                                                    
                                                    <div class="contact-form">
                                                        <div>
                                                                <form action="<?=BASE_PATH?>product_inquery?id=<?=$productInquery['id']?>" id="contactForm" name="contactForm" enctype="multipart/form-data" method="post">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6">
                                                                            <div class="form-group">
                                                                                 <input type="text" id="name" name="name" value="" size="40" class=" form-control"aria-required="true" aria-invalid="false" placeholder="Name">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="email" id="email" name="email" value="" size="40" class=" form-control" aria-required="true" aria-invalid="false" placeholder="Email">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="mobile" id="mobile" value="" size="40" class=" form-control" aria-required="true" aria-invalid="false" placeholder="Phone">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="subject" id="subject" value="" size="40" class=" form-control" aria-required="true" aria-invalid="false" placeholder="Subject">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <div class="form-group">
                                                                                        <textarea name="message" id="message" cols="40" rows="10" class="form-control" aria-required="true" aria-invalid="false" placeholder="Your Message"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                 
                                                                                </div>
                                                                                <input type="hidden" name="inquiry_type" value="2">
                                                                                
                                                                                <div class="col-lg-12 col-md-12">
                                                                                    <span class="wpcf7-form-control-wrap acceptance-737"><span class="wpcf7-form-control wpcf7-acceptance"><span class="wpcf7-list-item">
                                                                                    <button type="submit" name="submit" class="btn btn-primary submit-button submitData">Send Message</button>
                                                                                </div>
                                                                            </div>
                                                                            </form>
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
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>

    <!-- Footer -->
    <?php include 'footer.php';?>
    <!-- End Footer -->

    <script type="text/javascript"> 
        //Refresh Captcha
        jQuery(document).ready(function(){

            jQuery(document).on("click", ".submitData", function(e){  
            if (jQuery("#contactForm").valid()) { 
                // alert("asdf");
                jQuery("#contactForm").submit();
            }
        });

        jQuery("#contactForm").validate({
            rules: {
                name: "required",
                email: {required: true, email: true},
                mobile: {
                    required: true, 
                    number: true,
                    minlength:10,
                    maxlength:10,
                },
                subject: "required",
                message: "required", 
            },
            messages: {
                name: "Please Enter Full Name",
                email: { 
                  "required": "Please Enter Email Address",
                  "email": "Please Enter Valid Email Address",
                },
                mobile: { 
                  "required": "Please Enter Mobile No.",
                  "number": "Please Enter Valid Mobile No",
                  "minlength": "Mobile No Should Be 10 Digits",
                  "maxlength": "Mobile No Should Be 10 Digits",
                },
                subject: "Please Enter Subject",
                message: "Please Enter Message",  
            }
        }); 

        });
  

</script>

</body>

</html>