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
          <h3 class="card-title"><i class="fa fa-question-circle"></i>&nbsp; Inquiry List </h3>
        </div>
        <div class="d-inline-block float-right">
          <div class="btn-group margin-bottom-20"> 
            <a href="<?= base_url() ?>inquiry/create_inquiry_pdf" class="btn btn-secondary">Export as PDF</a>
            <a href="<?= base_url() ?>inquiry/export_csv" class="btn btn-secondary">Export as CSV</a>&nbsp
            <a href="<?= base_url('inquiry/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New Inquiry</a>
          </div> 
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#ID</th> 
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Inquiry Type</th>
              <th>Assigned To</th>
              <th>IP Address</th>
              <th>Created Date</th> 
              <th width="100" class="text-right">Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>  
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "<?=base_url('inquiry/datatable_json')?>",
    "order": [[6,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true}, 
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "email", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "inquiry_type", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "firstname", 'searchable':true, 'orderable':true},
    { "targets": 5, "name": "ip_address", 'searchable':true, 'orderable':true},
    { "targets": 6, "name": "created_at", 'searchable':false, 'orderable':false}, 
    { "targets": 7, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script> 