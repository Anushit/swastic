  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>
              Add New Inquiry </h3>
          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('inquiry'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Inquiry List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open(base_url('inquiry/add'), 'class="form-horizontal" id="inquiryForm"');  ?> 
              <div class="form-group row">                
                <div class="col-sm-6">
                  <label for="name" class="col-sm-6 control-label"> Name <span class="red">*</span></label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name'); ?>">
                </div>
                 <div class="col-sm-6">
                  <label for="inquiry_mode" class="col-sm-6 control-label">inquiry Mode <span class="red">*</span></label>
                  <select name="inquiry_mode" class="form-control">
                    <option value="">Select Inquiry Mode</option>
                    <option value="1" <?= (set_value('inquiry_mode') == 1)?'selected': '' ?>>Website</option>
                    <option value="2" <?= (set_value('inquiry_mode') == 2)?'selected': '' ?>>Telephonic</option>
                    <option value="3" <?= (set_value('inquiry_mode') == 3)?'selected': '' ?>>Direct Enquiry</option>
                    <option value="4" <?= (set_value('inquiry_mode') == 4)?'selected': '' ?>>News Paper</option>

                  </select>
                </div>
                
              </div>            
              <div class="form-group row">
               <div class="col-sm-6">
                  <label for="email" class="col-sm-6 control-label">Email <span class="red">*</span></label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?= set_value('email'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="inquiry_type" class="col-sm-6 control-label">inquiry Type <span class="red">*</span></label>
                  <select name="inquiry_type" id="inquiry_type" onchange ="get_data(this)" class="form-control">
                    <option value="">Select Inquiry type</option>
                    <option value="1" <?= (set_value('inquiry_type') == 1)?'selected': '' ?>>Genral</option>
                    <option value="2" <?= (set_value('inquiry_type') == 2)?'selected': '' ?>>Product</option>
                    <option value="3" <?= (set_value('inquiry_type') == 3)?'selected': '' ?>>Service </option>
                  </select>
                </div>
              </div>
              <div class="form-group row">               
                <div class="col-sm-6">
                   <label for="mobile_no" class="col-sm-6 control-label">Mobile No <span class="red">*</span></label>
                  <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('mobile_no'); ?>">
                </div> 
                <div class="col-sm-6">
                <label for="subject" class="col-sm-6 control-label">Subject <span class="red">*</span></label>  
                  <input type="text" name="subject" class="form-control" id="subject" placeholder="" value="<?= set_value('subject'); ?>">
                </div>
                
               
              </div>
              <div class="form-group row">               
                <div class="col-sm-6">
                  <label for="message" class="col-sm-6 control-label">Message <span class="red">*</span></label>
                  <textarea name="message" class="form-control" id="message" placeholder="" value=""><?= set_value('message'); ?></textarea>
                </div>
                <div class="col-sm-6" id="result">
                  
                </div>

               
                </div>
 
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add inquiry" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>

  <script type="text/javascript">
  
  function get_data(sel)
    { 
       
      var type =sel.value;

      var vdata = {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
          'type': type,
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>inquiry/get_inqirytype_data",
            data: vdata,
            success: function (data) {
             
             data = JSON.parse(data);
             console.log(data);
             
                if (data.status==true) {
                  $('#result').html(data.data);
                } else {
                   $('#result').html('');
                }
            },
        });
        return true;
    }

  </script>
  <script type="text/javascript">
  $(document).ready(function(){     
     $("#inquiryForm").validate({
        rules: {
            name:"required",
            inquiry_mode: "required",
            inquiry_type: "required",
            message: "required",
            subject: "required",
            email: {required: true, email: true},
            mobile_no:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                },
   
             
        },
        messages: {
            name:"Please Enter Name",
            inquiry_mode: "Please Enter Inquiry Mode",
            inquiry_type: "Please Enter Inquiry Type",
            message: "Please Enter Message",
            subject: "Please Enter Subject",
            email: "Please Enter Valid Email Address",
            mobile_no: {
                    "required": "Please Enter Mobile No",
                    "number": "Please Enter Valid Mobile No",
                    "minlength": "Mobile Should Be 10 Digits",
                    "maxlength": "Mobile Should Be 10 Digits",
                },
  
        
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#inquiryForm").valid()){
            $("#inquiryForm").submit();
        }
    });
  });  
</script>