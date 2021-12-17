<div class="form-background">
  <div class="login-box">
    <div class="login-logo">
      <h2><a href="<?= base_url('admin'); ?>"> <img src="<?= base_url($this->general_settings['logo']); ?>" alt="Logo" class="brand-image elevation-3" style="opacity: .8; float: none;"> </a></h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign Into Admin Panel</p>

        <?php $this->load->view('includes/_messages.php') ?>
        
        <?php echo form_open(base_url('login'), 'class="login-form" id="loginform"'); ?>
          <div class="form-group has-feedback">
            <input type="text" name="username" id="name" class="form-control" placeholder="Username" >
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" >
          </div>
          <div class="row">
            <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="Sign In">
            </div>
            <!-- /.col -->
          </div>
        <?php echo form_close(); ?>

        <p class="mb-1">
          <a href="<?= base_url('forgot_password'); ?>">I forgot my password</a>
        </p>
        <!-- <p class="mb-0">
          <a href="<?= base_url('register'); ?>" class="text-center">Register a new membership</a>
        </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</div>
          
 <script type="text/javascript">
  $(document).ready(function(){     
     $("#loginform").validate({
        rules: {
            username:"required",
            password:"required", 
         },
        messages: {
            username:"Please Enter User Name",
            password:"Please Enter Password", 

        }
    });
     $("body").on("click", ".btn-submit", function(e){
        if ($("#loginform").valid()){
            $("#loginform").submit();
        }
    });

  });  
</script>