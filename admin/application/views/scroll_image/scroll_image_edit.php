  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-edit"></i>
              &nbsp; Edit Scroll Image </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('scroll_image'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Scroll Image List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
           
            <?php echo form_open_multipart(base_url('scroll_image/edit/'.$scroll_image['id']), 'class="form-horizontal" id="siteimgForm"' )?> 
              <div class="form-group row">
                <div class="col-sm-6">
                   <label for="title" class="col-sm-6 control-label">Title <span class="red">*</span></label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="" value="<?= set_value('title',$scroll_image['title']); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="Url" class="col-sm-6 control-label">Url </label>
                  <input type="text" name="url" class="form-control" id="meta_title" placeholder="" value="<?= set_value('url',$scroll_image['url']); ?>">
                </div> 
              </div> 
                
              

               <div class="form-group row">

                <div class="col-sm-6">
                    <label for="role" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>
                     <select name="status" id="status" class="form-control">
                      <option value="">Select Status</option>
                      <option value="1" <?= (set_value('is_active',$scroll_image['is_active']) == '1')?'selected': '' ?> >Active</option>
                      <option value="0" <?= (set_value('is_active',$scroll_image['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="control-label">Image</label><br/>
                      <?php if(!empty($scroll_image['image'])): ?>
                         <p><img src="<?= base_url($scroll_image['image']); ?>" class="image logosmallimg"></p>
                      <?php endif; ?>
                      <input type="file" name="image">
                      <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg <br></small></p>
                      <input type="hidden" name="old_image" value="<?php echo html_escape(@$scroll_image['image']); ?>">
                 </div>
              </div>
               
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Scroll image" class="btn btn-info pull-right">
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
     $("#siteimgForm").validate({
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
        if ($("#siteimgForm").valid()){
            $("#siteimgForm").submit();
        }
    });
  });  
</script>