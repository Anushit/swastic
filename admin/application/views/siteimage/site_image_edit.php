  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-edit"></i>
              &nbsp; Edit Site Image </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Site Image List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
           
            <?php echo form_open_multipart(base_url('site_image/edit/'.$site_image['id']), 'class="form-horizontal" id="siteimgForm"' )?> 
              <div class="form-group row">
                 <div class="col-sm-6">
                  <label for="section_name" class="col-sm-6 control-label">Section Name</label>
                  <div class="form-control bggray"><?= $site_image['section_name']; ?></div>
                  <input type="hidden" name="section_name" class="form-control" value="<?= @$site_image['section_name']; ?>">
                </div>
                <div class="col-sm-6">
                   <label for="title" class="col-sm-6 control-label">Title <span class="red">*</span></label>
                  <input type="text" name="title" class="form-control" id="title" placeholder="" value="<?= set_value('title',$site_image['title']); ?>">
                </div>
              </div> 
                
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="Url" class="col-sm-6 control-label">Url </label>
                  <input type="text" name="url" class="form-control" id="meta_title" placeholder="" value="<?= set_value('url',$site_image['url']); ?>">
                </div> 
              </div>

               <div class="form-group row">

                <div class="col-sm-6">
                    <label for="role" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>
                     <select name="status" id="status" class="form-control">
                      <option value="">Select Status</option>
                      <option value="1" <?= (set_value('is_active',$site_image['is_active']) == '1')?'selected': '' ?> >Active</option>
                      <option value="0" <?= (set_value('is_active',$site_image['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="control-label">Image</label><br/>
                      <?php if(!empty($site_image['image'])): ?>
                         <p><img src="<?= base_url($site_image['image']); ?>" class="image logosmallimg"></p>
                      <?php endif; ?>
                      <input type="file" name="image" accept=".png, .jpg, .jpeg, .gif, .svg">
                      <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg <br><?= $site_image['size_suggestion']; ?></small></p>
                      <input type="hidden" name="old_image" value="<?php echo html_escape(@$site_image['image']); ?>">
                 </div>
              </div>
               
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Site image" class="btn btn-info pull-right">
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
            url:"required",
            title:"required",
            status: "required",
            image:{
                  extension:"jpg|png|gif|jpeg",
                  },
        },
        messages: {
            section_name:"Please Enter Section Name",
            url: "Please Enter Url",
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