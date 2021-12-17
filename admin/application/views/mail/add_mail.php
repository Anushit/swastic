  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content">

       <div class="card card-default color-palette-bo ">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Create New Mail </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('mail'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Mail List</a>
          </div>
        </div>
      </div>

      <div class="card card-default color-palette-bo col-lg-12">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-paper-plane"></i>

              Send Mail </h3>

          </div>

        
        </div>

        <div class="card-body ">   

           <!-- For Messages -->
          <div class="error"> </div>
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('mail/add'), 'class="form-horizontal" id ="myform"');  ?> 
              <div class="form-group row">  
             
                <div class="col-sm-12 email-id-row">

                   <input type="text" name="allemailids"class="emails" hidden="" />
                   
                  <span class="to-input">To</span>
                     <div class="all-mail"> </div>
                      <input type="email"  class="enter-mail-id"  pattern="[^ @]*@[^ @]*" placeholder="Enter the email id .." />

                </div>
                <span><small>if you use multiple email then type email address and use space for add next email address</small></span>
              </div>
              <div class="form-group row">                
                <div class="col-sm-12">
                  <label for="subject" class="col-sm-12 control-label">Subject <span class="red">*</span></label>
                  <input type="text" name="subject" class="form-control" id="subject" placeholder="" value="<?= set_value('subject'); ?>">
                </div>
              </div>  
               <div class="form-group row">                
                <div class="col-sm-12">
                  <label for="message" class="col-sm-12 control-label">Message <span class="red">*</span></label>
                  <textarea name="message" class="form-control" id="message" placeholder="" value=""><?= set_value('message'); ?></textarea> 
                </div>
              </div>  
              <div class="form-group row">   
               <div class="col-md-12">
                  <label for="attachment" class="col-sm-6 control-label">Attachment </label>                  
                 <input type="file"  class="form-control"id="attachment" name="attachment">
                 <span> <small class="text-success">Allowed Types: gif, jpg, png, jpeg, pdf</small></span>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input onclick="sendmail()" type="submit" name="submit" value="Send Mail" class="btn btn-info pull-right">
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
    //alert('You Press enter');
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var emailblockReg =
     /^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/;



   var getValue = $(this).val();

  var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);


  if(pattern.test(getValue)){
      $('.all-mail').append('<span class="email-ids">'+ getValue +' <span class="cancel-email"><i class="fa fa-window-close"></i></span></span>');
      $(this).val('');
      $('.error').html('');
      }else{
        $('.error').html('<span class="text-white bg-danger p-1">Please enter valid email id</span>');
      }
  }
});

$(document).on('click','.cancel-email',function(){
        $(this).parent().remove();
  });

  </script>
<script type="text/javascript">
  $(document).ready(function(){     
     $("#myform").validate({
        rules: {
            message:"required", 
            subject:"required", 
            attachment:{
                  required:true,
                  extension:"jpg|png|gif|jpeg|pdf",
                  },
            
         },
        messages: {
            message:"Please Enter Message", 
            subject:"Please Enter Subject", 
            attachment:{
                required:"Please Select Attachment",
                extension:"Please upload file in these format only (jpg, jpeg, png, gif, pdf)",
                 },
        }
    });

  });  
</script>