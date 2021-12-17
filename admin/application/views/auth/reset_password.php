<div class="form-background"> 

  <div class="login-box">

    <div class="login-logo">

      <h2><a href="<?= base_url('admin'); ?>"><?= $this->general_settings['application_name']; ?></a></h2>

    </div>

    <!-- /.login-logo -->

    <div class="card">

      <div class="card-body login-card-body">

        <p class="login-box-msg">Reset Password</p>



        <?php $this->load->view('includes/_messages.php') ?>

        

         <?php echo form_open(base_url('reset_password/'.$reset_code), 'class="login-form" id="resetpassform"'); ?>

          <div class="form-group has-feedback">

            <input type="password" name="password" id="password" class="form-control" placeholder="Password" >

          </div>

          <div class="form-group has-feedback">

            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm" >

          </div>

          <div class="row">

            <!-- /.col -->

            <div class="col-12">

              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="Reset">

            </div>

            <!-- /.col -->

          </div>

        <?php echo form_close(); ?>



        <p class="mt-3"><a href="<?= base_url('login'); ?>">You remember Password? Sign In </a></p>



      </div>

      <!-- /.login-card-body -->

    </div>

  </div>

  <!-- /.login-box -->

</div>
<script type="text/javascript">
  $(document).ready(function(){     
     $("#resetpassform").validate({
        rules: {
          password:{
                      required: true,
                      minlength: 5
                  },
          confirm_passwords:{
                      required: true,
                      minlength: 5,
                      equalTo: "#password"
                  }, 

         },
        messages: {
            password: {
                "required": "Please Enter Password",
            },
            confirm_passwords: {
                "required": "Please Enter Confirm Password",
                "equalTo": "Password And Confirm Password Should be Same",
            }, 

        }
    });
     $("body").on("click", ".btn-submit", function(e){
        if ($("#resetpassform").valid()){
            $("#resetpassform").submit();
        }
    });

  });  
</script>

