  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-edit"></i>
              &nbsp; Add Scroll Image  </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('scroll_image'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Site Scroll Image List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
           
            <?php echo form_open_multipart(base_url('scroll_image/add/'), 'class="form-horizontal" id="scrollimgForm"' )?> 
            <div class="form-group row">
                <div class="col-sm-6">
                   <label for="title" class="col-sm-6 control-label">Title <span class="red">*</span></label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="" value="">
                </div>
                <div class="col-sm-6">
                  <label for="Url" class="col-sm-6 control-label">Url </label>
                  <input type="text" name="url" class="form-control" id="meta_title" placeholder="" value="">
                </div> 
              </div> 
                
               <div class="form-group row">

                <div class="col-sm-6">
                    <label for="role" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>
                     <select name="status" id="status" class="form-control">
                      <option value="">Select Status</option>
                      <option value="1" >Active</option>
                      <option value="0" >Deactive</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="control-label">Image</label><br/>
                      <input type="file" name="image" >
                      <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg <br></small></p>
                      <input type="hidden" name="old_image" value="">
                 </div>
              </div>
               
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Scroll Image" class="btn btn-info pull-right">
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
     $("#scrollimgForm").validate({
        rules: {
            section_name:"required",
            title:"required",
            status: "required",
            image:{
                  extension:"jpg|png|gif|jpeg",
                  },
        },
        messages: {
            title: "Please Enter Title", 
            status: "Please Select Status",
            image:{
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
        },
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#scrollimgForm").valid()){
            $("#scrollimgForm").submit();
        }
    });
  });  
</script>