  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Add New Customer </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('users'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Customers List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open(base_url('users/add'), 'class="form-horizontal" id="userForm"');  ?> 
              <div class="form-group row">                
                <div class="col-sm-6">
                  <label for="username" class="col-sm-6 control-label">Customer Name <span class="red">*</span></label>
                  <input type="text" name="username" class="form-control" id="username" placeholder="" value="<?= set_value('username'); ?>">
                </div>
                <div class="col-sm-6">
                <label for="firstname" class="col-sm-6 control-label">First Name <span class="red">*</span></label>  
                  <input type="text" name="firstname" class="form-control" id="firstname" placeholder="" value="<?= set_value('firstname'); ?>">
                </div>
              </div>            
              <div class="form-group row">
                <div class="col-sm-6">
                <label for="lastname" class="col-sm-6 control-label">Last Name <span class="red">*</span></label>  
                  <input type="text" name="lastname" class="form-control" id="lastname" placeholder="" value="<?= set_value('lastname'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="email" class="col-sm-6 control-label">Email <span class="red">*</span></label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?= set_value('email'); ?>">
                </div>
              </div>
              <div class="form-group row">               
              <div class="col-sm-6">
                   <label for="mobile_no" class="col-sm-6 control-label">Mobile No <span class="red">*</span></label>
                  <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder=""  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('mobile_no'); ?>">
                </div> 
                <div class="col-sm-6">
                  <label for="password" class="col-sm-6 control-label">Password <span class="red">*</span></label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="" value="<?= set_value('password'); ?>">
                </div>
              </div>

              <div class="form-group row">
                
                <div class="col-6">
                  <label for="address" class="col-sm-6 control-label">Address</label>
                  <input type="text" name="address"class="form-control " id="address" placeholder="" value="<?= set_value('address'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="password" class="col-sm-6 control-label">Confirm Password <span class="red">*</span></label>
                  <input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd" placeholder="" value="<?= set_value('confirm_pwd'); ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Customer" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>
  <script type="text/javascript">
  $(document).ready(function(){     
     $("#userForm").validate({
        rules: {
            username:"required",
            firstname: "required",
            lastname: "required",
            address: "required",
            email: {required: true, email: true},
            mobile_no:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                },
            
            password:{
                        required: true,
                        minlength: 5
                    },
            confirm_pwd:{
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    }, 

             
        },
        messages: {
            username:"Please Enter Username",
            firstname: "Please Enter First Name",
            lastname: "Please Enter Last Name",
            email: "Please Enter Valid Email Address",
            address: "Please Enter Customer Address",
            mobile_no: {
                    "required": "Please Enter Mobile No",
                    "number": "Please Enter Valid Mobile No",
                    "minlength": "Mobile Should Be 10 Digits",
                    "maxlength": "Mobile Should Be 10 Digits",
                },
            
            password: {
                "required": "Please Enter Password",
            },
            confirm_pwd: {
                "required": "Please Enter Confirm Password",
                "equalTo": "Password And Confirm Password Should be Same",
            },
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#userForm").valid()){
            $("#userForm").submit();
        }
    });
  });  
</script>