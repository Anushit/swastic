  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>
              Add New Subadmin </h3>
          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('subadmin'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Subadmin List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open(base_url('subadmin/add'), 'class="form-horizontal" id="userForm"'); ?> 
              <div class="form-group row">                
                <div class="col-sm-6">
                  <label for="username" class="col-sm-6 control-label">User Name <span class="red">*</span></label>
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
                  <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('mobile_no'); ?>">
                </div> 
                 <div class="col-sm-6">
                  <label for="role" class="col-sm-6 control-label">Role <span class="red">*</span></label>
                  <select name="role" id="role" class="form-control">
                    <option value="">Select Role</option>
                    <?php foreach($role as $urole){ ?>
                    <option value="<?= $urole['id'] ?>" <?= (set_value('role') == $urole['id'])?'selected': '' ?>><?= $urole['name'] ?></option>
                  <?php } ?>
                  </select>
                </div>
               
              </div>
              <div class="form-group row">               
                <div class="col-sm-6">
                  <label for="password" class="col-sm-6 control-label">Password <span class="red">*</span></label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="" value="<?= set_value('password'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="password" class="col-sm-6 control-label">Confirm Password <span class="red">*</span></label>
                  <input type="password" name="conf_password" class="form-control" id="conf_password" placeholder="" value="<?= set_value('conf_password'); ?>">
                </div>
              </div>
 
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Subadmin" class="btn btn-submit btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
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
            email: {required: true, email: true},
            mobile_no:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                },
            role:"required", 
            password:{
                        required: true,
                        minlength: 5
                    },
            conf_password:{
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
            mobile_no: {
                    "required": "Please Enter Mobile No",
                    "number": "Please Enter Valid Mobile No",
                    "minlength": "Mobile Should Be 10 Digits",
                    "maxlength": "Mobile Should Be 10 Digits",
                },
            role: "Please Select Role", 
            password: {
                "required": "Please Enter Password",
            },
            conf_password: {
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