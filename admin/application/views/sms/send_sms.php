  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content">

       <div class="card card-default color-palette-bo ">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-paper-plane"></i>

              Send New SMS </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('sms'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  SMS List</a>
          </div>
        </div>
      </div>

      <div class="card card-default color-palette-bo col-lg-8 m-3">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-paper-plane"></i>

              Send SMS </h3>

          </div>

        
        </div>

        <div class="card-body ">   

           <!-- For Messages -->
          <div class="error"> </div>
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('sms/add'), 'class="form-horizontal" id ="myform"');  ?> 
              <div class="form-group row">  
             
                <div class="col-sm-12 email-id-row">

                   <input type="text" name="allemailids" class="emails" hidden="" />
                   
                  <span class="to-input">To</span>
                     <div class="all-number"> </div>
                     
                     
                      <input type="text" class="enter-mail-id" name="number"  id="number"placeholder="Enter the Mobile Number  .." />

                </div>
                <span><small>if you use multiple Mobile Number then type Number and use space for add next Number </small></span>
              </div>
   
               <div class="form-group row">                
                <div class="col-sm-12">
                  <label for="message" class="col-sm-12 control-label">Message <span class="red">*</span></label>
                  <textarea name="message" class="form-control" id="message" placeholder="" value=""><?= set_value('message'); ?></textarea> 
                </div>
              </div>  
              <div class="form-group">
                <div class="col-md-12">
                  <input onclick="sendmail()" type="submit" name="submit" value="Send SMS" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>
  <script type="text/javascript">
    

    function sendmail() { 
      if ($("#myform").valid()){
        var str = $('.email-ids').text();
        $('.emails').val(str);
        }
    } 

  $(".enter-mail-id").keydown(function (e) {
  if (e.keyCode == 13 || e.keyCode == 32) {
  
   var getValue = $(this).val();

  if(phone_validate(getValue)){
      $('.all-number').append('<span class="email-ids">'+ getValue +' <span class="cancel-email"><i class="fa fa-window-close"></i></span></span>');
      $(this).val('');
      $('.error').html('');
      }else{
        $('.error').html('<span class="text-white bg-danger p-1">Please enter valid Mobile number</span>');
      }
  }
});

function phone_validate(phno) 
{ 
  var regexPattern=new RegExp(/^[0-9-+]+$/);    // regular expression pattern
  return regexPattern.test(phno); 
} 
$(document).on('click','.cancel-email',function(){
    
        $(this).parent().remove();
  
  });

  </script>>


  <script type="text/javascript">
  $(document).ready(function(){     
     $("#myform").validate({
        rules: {
            number:"required", 
            message:"required", 
         },
        messages: {
            number:"Please Enter Mobile Number",
            message:"Please Enter Message", 
        }
    });

  });  
</script>