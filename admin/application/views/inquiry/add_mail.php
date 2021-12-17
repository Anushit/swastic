<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">   <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content">
      <div class="card card-default color-palette-bo ">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"><a href="<?php echo base_url('inquiry') ?>"> <i class="fa fa-arrow-left" aria-hidden="true"></i></a>&nbsp  <i class="fa fa-envelope-o"></i>
              Inqiry Reply Mail &nbsp <span class="badge badge-primary"><?= $inquiry_data['name']?></span> </h3>
          </div>
        </div>
      </div>
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
            <h4><i class="fa fa-info-circle"></i>

              Inquiry Details</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                 <b> Name </b>
                </div>
                <div class="col-sm-6">
                 :  <?= $inquiry_data['name'];?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b>Email </b>
                </div>
                <div class="col-sm-6">
               : <?= $inquiry_data['email'];?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> Phone </b>
                </div>
                <div class="col-sm-6">
               : <?= $inquiry_data['mobile'];?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> Mode </b>
                </div>
                <div class="col-sm-6">
               : <?php if($inquiry_data['inquiry_mode']==1){echo "Website"; }
               if($inquiry_data['inquiry_mode']==2){echo "Telephonic"; }
               if($inquiry_data['inquiry_mode']==3){echo "Direct inquiry"; }
               if($inquiry_data['inquiry_mode']==4){echo "News paper";}?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> Type </b>
                </div>
                <div class="col-sm-6">
               : <?php if($inquiry_data['inquiry_type']==1){echo "Gernal"; }
               if($inquiry_data['inquiry_type']==2){echo "Product ";}
               if($inquiry_data['inquiry_type']==3){echo "Service"; }?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                 <b>  Subject </b>
                </div>
                <div class="col-sm-6">
               : <?= $inquiry_data['subject'];?>
                </div>
              </div>
            </div>
          </div>
         <?php if($inquiry_data['inquiry_type']!=1){ ?> 
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> <?php if($inquiry_data['inquiry_type']==2){echo "Product Name"; }
                  if($inquiry_data['inquiry_type']==3){echo "Service Name"; } ?></b>
                </div>
                <div class="col-sm-6">
               : <?php if($inquiry_data['inquiry_type']==2){echo '('.$inquiry_data['productName'].')'; }
               if($inquiry_data['inquiry_type']==3){ echo '('.$inquiry_data['serviceName'].')';} ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> Create Date </b>
                </div>
                <div class="col-sm-6">
                  : <?= date_time($inquiry_data['created_at']);?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                 <b>  IP Address </b>
                </div>
                <div class="col-sm-6">
               : <?= $inquiry_data['ip_address'];?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <b> Create By </b>
                </div>
                <div class="col-sm-6">
               : <?php 
                  if(!empty($creatby)){ echo $creatby['firstname'].' '.$creatby['lastname']; }else{ echo ' Web Inquery '; } ?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                 <b>  Assigned user </b>
                </div>
                <div class="col-sm-6">
               : <?= $inquiry_data['first_name'].' '.$inquiry_data['last_name'];?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-2" style="max-width: 12.50%;">
                 <b>  Message </b>
                </div>
                <div class="col-sm-10">
               : <?= $inquiry_data['message'];?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex p-0">
              <h3 class="card-title p-3"><i class="fa fa-paper-plane"></i>
            Mail </h3>
             <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Compose Mail</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Sent Mail List</a></li> 
              </ul>
            </div>        
          
            <div class="card-body ">   
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <!-- For Messages -->
                  <div class="error"> </div>
                  <?php $this->load->view('includes/_messages.php') ?>
                  <?php echo form_open_multipart(base_url('inquiry/send_replymail/'.$inquiry_data['id']), 'class="form-horizontal" id ="myform"');  ?> 

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
                      <input type="submit" name="submit" value="Send Mail" class="btn btn-info pull-right">
                    </div>
                  </div>
                  <?php echo form_close( ); ?>
                  <!-- /.box-body --> 
                </div>
                <div class="tab-pane" id="tab_2">  
                  <div class="card">
                    <div class="card-body table-responsive">
                    <table id="na_datatable" class="table table-bordered table-striped" width="100%">
                    <thead>
                    <tr>
                    <th>#ID</th> 
                    <th>Inquiry Email</th>
                    <th>Message</th>
                    <th>Attachment</th>
                    <th>subject</th>
                    <th>Followup date</th>
                    </tr>
                    </thead>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section> 
  </div>
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>

<script> 
  var table = $('#na_datatable').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": "<?=base_url('inquiry/datatable_json_reply_mail/'.$inquiry_data['id'])?>",
    "order": [[5,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':false, 'orderable':true}, 
    { "targets": 1, "name": "ci_inquiry.email", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "ci_inquiry.message", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "attachment", 'searchable':false, 'orderable':true},
    { "targets": 4, "name": "ci_inquiry.subject", 'searchable':true, 'orderable':true},
    { "targets": 5, "name": "followup_date", 'searchable':false, 'orderable':true},
    ]
  });
</script> 

<script type="text/javascript">
  $(document).ready(function(){     
     $("#myform").validate({
        rules: {
            message:"required", 
            subject:"required", 
            attachment:{
                  extension:"jpg|png|gif|jpeg|pdf",
                  },
         },
        messages: {
            message:"Please Enter Message", 
            subject:"Please Enter Subject", 
            attachment:{
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