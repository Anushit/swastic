<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-pencil"></i>
              &nbsp; Update Admin </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('profile/change_pwd'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Change Password</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>

            <?php echo form_open(base_url('profile'), 'class="form-horizontal" id="profileForm"' )?> 
              <div class="form-group">
                <label for="username" class="col-sm-2 control-label">User Name</label>

                <div class="col-md-12">
                  <input type="text" name="username" value="<?= set_value('username',$admin['username']); ?>" class="form-control" id="username" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">First Name</label>

                <div class="col-md-12">
                  <input type="text" name="firstname" value="<?= set_value('firstname',$admin['firstname']); ?>" class="form-control" id="firstname" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                <div class="col-md-12">
                  <input type="text" name="lastname" value="<?= set_value('lastname',$admin['lastname']); ?>" class="form-control" id="lastname" placeholder="">
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>

                <div class="col-md-12">
                  <input type="email" name="email" value="<?= set_value('email',$admin['email']); ?>" class="form-control" id="email" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="mobile_no" class="col-sm-2 control-label">Mobile No</label>

                <div class="col-md-12">
                  <input type="number" name="mobile_no" value="<?= set_value('mobile_no',$admin['mobile_no']); ?>" class="form-control" id="mobile_no" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Profile" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
  </div> 
  <script type="text/javascript">
  $(document).ready(function(){     
     $("#profileForm").validate({
        rules: {
            username:"required",
            firstname: "required",
            lastname: "required",
            email: {required: true, email: true},
            mobile_no:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                },

        },
        messages: {
            username:"Please Enter Username",
            firstname: "Please Enter First Name",
            lastname: "Please Enter Last Name",
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
        if ($("#profileForm").valid()){
            $("#profileForm").submit();
        }
    });
  });  
</script>