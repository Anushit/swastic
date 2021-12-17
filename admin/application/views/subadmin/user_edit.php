  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-edit"></i>
              &nbsp; Edit Subadmin </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Subadmin List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
           
            <?php echo form_open(base_url('subadmin/edit/'.$user['admin_id']), 'class="form-horizontal"' )?> 
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="username" class="col-sm-6 control-label">User Name <span class="red">*</span></label>
                  <input type="text" name="username" value="<?= set_value('username',$user['username']); ?>" class="form-control" id="username" placeholder="">
                </div>
                <div class="col-md-6">
                  <label for="firstname" class="col-sm-6 control-label">First Name <span class="red">*</span></label>
                  <input type="text" name="firstname" value="<?= set_value('firstname',$user['firstname']); ?>" class="form-control" id="firstname" placeholder="">
                </div>
              </div>

              <div class="form-group row"> 
                <div class="col-md-6">
                <label for="lastname" class="col-sm-6 control-label">Last Name <span class="red">*</span></label>  
                  <input type="text" name="lastname" value="<?= set_value('lastname',$user['lastname']); ?>" class="form-control" id="lastname" placeholder="">
                </div>
                <div class="col-md-6">
                 <label for="email" class="col-sm-6 control-label">Email <span class="red">*</span></label>
                  <input type="email" name="email" value="<?= set_value('email',$user['email']); ?>" class="form-control" id="email" placeholder="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                   <label for="mobile_no" class="col-sm-6 control-label">Mobile No <span class="red">*</span></label>
                  <input type="text" name="mobile_no" value="<?= set_value('mobile_no',$user['mobile_no']); ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" class="form-control" id="mobile_no" placeholder="">
                </div> 
                <div class="col-md-6">
                  <label for="role" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('is_active',$user['is_active']) == '1')?'selected': '' ?> >Active</option>
                    <option value="0" <?= (set_value('is_active',$user['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Subadmin" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
  </div> 