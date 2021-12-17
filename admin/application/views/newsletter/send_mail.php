  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content">

       <div class="card card-default color-palette-bo ">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-paper-plane"></i>

              Send Newsletter Mail </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('Newsletter'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Newsletter List</a>
          </div>
        </div>
      </div>

      <div class="card card-default color-palette-bo col-lg-12">
<!-- 
        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-paper-plane"></i>

              Send  Mail </h3>

          </div>

        </div> -->

        <div class="card-body ">   

           <!-- For Messages -->
          <div class="error"> </div>
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('Newsletter/send_mail'), 'class="form-horizontal" id="myform"');  ?> 
              <div class="form-group row">  
             
                <div class="col-sm-12 email-id-row">
                  <label for="users" class="col-sm-6 control-label">Select Newsletter Customer <span class="red">*</span></label>
                    <select class="form-control select2" onchange="getval(this);" name="users" id="users" >
                      <option >Select Newsletter Customer</option> 
                      <option value="1">All Newsletter Customer </option>
                      <option value="2">Selected Newsletter Customer </option>          
                    </select> 
                </div>
                 
              </div>

              <div class="form-group row">                
                <div class="col-sm-12" style="border: solid 1px #ccc; border-radius: 5px;">
                  <div class="m-2 row minheightdiv" id="result"></div>
                </div>
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
                 <input type="file"  class="form-control" name="attachment">
                 <span> <small class="text-success">Allowed Types: gif, jpg, png, jpeg, pdf</small></span>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Send Mail" class="btn btn-submit btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>
  <script type="text/javascript">
    $( document ).ready(function() {
    $('#result').hide();
    });

  function getval(sel)
    { 
       
      var select =sel.value;

      var vdata = {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
          'id': select,
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Newsletter/get_allnewletter",
            data: vdata,
            success: function (data) {
            data = JSON.parse(data);
            console.log(data);
            
                if (data.status==true) {
                  $('#result').html(data.data);
                  $('#result').show();
                 
                } else {
                   $('#result').hide();
                   $('#result').html('');
                }
            },
        });
        return true;
    }

  </script>
  <script type="text/javascript">
  $(document).ready(function(){     
     $("#myform").validate({
        rules: {
            users:"required",
            message:"required", 
            subject:"required", 
            attachment:{
                  required:true,
                  extension:"jpg|png|gif|jpeg|pdf",
                  },
            
         },
        messages: {
            users:"Please Select Users",
            message:"Please Enter Message", 
            subject:"Please Enter Subject", 
            attachment:{
                required:"Please Select Attachment",
                extension:"Please upload file in these format only (jpg, jpeg, png, gif, pdf)",
                 },
        }
    });
     $("body").on("click", ".btn-submit", function(e){
        if ($("#myform").valid()){
            $("#myform").submit();
        }
    });

  });  
</script>