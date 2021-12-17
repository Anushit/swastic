<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css"> 

<script type="text/javascript">
    function actions(checkid)
    {   
        var checkBox = document.getElementById(checkid);
        var modulId = $('#'+checkid).attr('data-modelid');       
        var userid = $('#'+checkid).attr('data-userid');
        var type = $('#'+checkid).attr('data-type');            
        var checkedProps = 0;
        if (checkBox.checked == true){
            checkedProps = 1;
        }

      var vdata = {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
          'id': userid,
          'menu': modulId,
          'action': type,
          'admin_id': '<?=$subadmin['admin_id']; ?>',
          'value':checkedProps
        };


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>subadmin/update_permission",
            data: vdata,
            success: function (data) {
            data = JSON.parse(data); 
                if (data.status==true) {
                  $('#result').html(data.data);
                  $.jGrowl('<i class="fa fa-check"></i>&nbsp;' + type + ': Permissions has been  <br> changed successfully.', {
                        theme: 'bg-success'
                    }); 
                } else {
                  $('#result').html(data.data);
                    $.jGrowl('<i class="<i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;Unable to complete this request. <br> Permission not allowe.', {
                        theme: 'bg-warning'
                    }); 
                }
            },
        });
        return true;
    }

 function refreshPage() {
        setTimeout(function () {
            location.reload();
        }, 3000);
    }
   
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; Manage Permission <span class="badge badge-info"><?= $subadmin['username'] ?></span> </h3>
        </div>

      </div>
    </div>
    <div class="card">
       <div id="message" class="row"></div>
      <div class="card-body table-responsive">
          
             <table class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Section</th>
                        <th>Allowed</th>
                        <th>Add</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        
                    </tr>
                </thead>
                <tbody id="result">
                    <?php 
                    if (isset($permission) && count($permission) > 0) {
                        $i = 1;
                        foreach ($permission as $rs) {
                            ?>
                            <tr id="<?php echo $rs->id . 'row'; ?>">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"><?php echo $rs->menu_name;?></td>

                                <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="<?php echo 'is_allow'.$rs->module_id.$rs->id; ?>" data-modelid="<?php echo $rs->id; ?>"data-userid="<?php echo $rs->permission_id; ?>" data-type="is_allow"  onChange="return actions(this.id)" <?php if($rs->is_allow == 1){ echo 'checked'; } ?>></td>

                                 <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="<?php echo 'is_add' . $rs->module_id.$rs->id; ?>" data-modelid="<?php echo $rs->id; ?>"data-userid="<?php echo $rs->permission_id; ?>" data-type="is_add"  onChange="actions(this.id)"<?php if($rs->is_allow == 0){ echo 'disabled'; } ?> <?php if($rs->is_add == 1){ echo 'checked'; } ?>></td>

                                  <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="<?php echo 'is_view' . $rs->module_id.$rs->id; ?>" data-modelid="<?php echo $rs->id; ?>"data-userid="<?php echo $rs->permission_id; ?>" data-type="is_view"  onChange="actions(this.id)"<?php if($rs->is_allow == 0){ echo 'disabled'; } ?> <?php if($rs->is_view == 1){ echo 'checked'; } ?>></td>

                                 <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="<?php echo 'is_edit' . $rs->module_id.$rs->id; ?>" data-modelid="<?php echo $rs->id; ?>"data-userid="<?php echo $rs->permission_id; ?>" data-type="is_edit"  onChange="actions(this.id)" <?php if($rs->is_allow == 0){ echo 'disabled'; } ?><?php if($rs->is_edit == 1){ echo 'checked'; } ?>></td>

                                <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="<?php echo 'is_delete' . $rs->module_id.$rs->id; ?>" data-modelid="<?php echo $rs->id; ?>"data-userid="<?php echo $rs->permission_id; ?>" data-type="is_delete"  onChange="actions(this.id)" <?php if($rs->is_allow == 0){ echo 'disabled'; } ?><?php if($rs->is_delete == 1){ echo 'checked'; } ?>></td>

                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
          </table>
       
      </div>
    </div>
  </section>  
</div>




