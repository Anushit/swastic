<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css"> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-question-circle"></i>&nbsp; Assign Inquiry </h3>
        </div>
        <div class="d-inline-block float-right">
          <div class="btn-group margin-bottom-20"> 
           
            <a href="<?= base_url('inquiry'); ?>" class="btn btn-success"><i class="fa fa-plus"></i>Inquiry list</a>
          </div> 
        </div>
      </div>
    </div>

     <div class="card-body">   
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open(base_url('inquiry/assign_inquiry/'.$inquiry_id), 'class="form-horizontal" id="assignForm"');  ?> 
              <div class="form-group row">                
                <div class="col-sm-7">
                  <label for="user" class="col-sm-6 control-label">User Name<span class="red">*</span></label>
                    <select name="user" id="user" class="form-control">
                      <option value="">Select User</option>
                      <?php foreach($subadmin as $row){ ?>
                      <option value="<?= $row['admin_id'] ?>" <?= (set_value('user') == $row['admin_id'])?'selected': '' ?>><?= $row['firstname'].' '. $row['lastname']?></option>
                    <?php } ?>
                    </select>
                </div> 
              </div>
              <div class="form-group row">                
                <div class="col-md-3">
                  <label for="user" class="col-sm-6 control-label"> &nbsp; </label>
                  <input type="submit" name="submit" value="Assing inquiry" class="btn btn-info pull-left">
                </div>
              </div>
            <?php echo form_close(); ?>
          <!-- /.box-body -->
      </div>
    <div class="card">
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#ID</th> 
              <th>User_name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Inquiry Type</th>
              <th>Subject</th>
              <th>Assign Date</th> 
              <th>Decline Date</th>
            </tr>

          </thead>
          <tbody>
            <?php 
            if(!empty($assigninquery)){
            $i = 1;
            foreach ($assigninquery as $value) {?>
            <tr>
              <td><?= $i ?></td> 
              <td><?= $value['name']?></td>
              <td><?= $value['email']?></td>
              <td><?= $value['mobile']?></td>
              <td><?php
               if($value['inquiry_type'] == 1)
                { echo "Genral"; }
               if($value['inquiry_type'] == 2)
                { echo "Product"; }
               if($value['inquiry_type'] ==3)
                { echo "Service"; }
              ?></td>
              <td><?= $value['subject']?></td>
              <td><?= $value['assign_date']?></td> 
              <td><?= $value['decline_date']?></td>                 
            </tr>
            <?php $i++; } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>  
</div>


<!-- DataTables -->
 <script type="text/javascript">
  $(document).ready(function(){     
     $("#assignForm").validate({
        rules: {
            user:"required",

        },
        messages: {
            user:"Please Select User",
        
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#assignForm").valid()){
            $("#assignForm").submit();
        }
    });
  });  
</script>