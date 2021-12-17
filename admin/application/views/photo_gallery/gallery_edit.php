  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Edit Photo Gallery </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('gallery/photo'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Photo Gallery List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('gallery/editphoto/'.$gallery['id']), 'class="form-horizontal" id="galleryForm"');  ?> 
                           
              <div class="form-group row"> 
                <div class="col-sm-6">
                <label for="album" class="col-sm-6 control-label">Album <span class="red">*</span></label>  
                  <input type="text" name="album" class="form-control" id="album" placeholder="" value="<?= set_value('album',$gallery['album']); ?>">
                </div>
                 <div class="col-sm-6">
                <label for="description" class="col-sm-6 control-label">Description </label>  
                  <input type="text" name="description" class="form-control" id="description" placeholder="" value="<?= set_value('description',$gallery['description']); ?>">
                </div> 
              </div> 

              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order',$gallery['sort_order']); ?>">
                </div> 
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status', $gallery['is_active']) == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status', $gallery['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
               
              <div class="form-group row"> 
                <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug',$gallery['slug']); ?>"> 
                </div>
                
                <div class="col-md-6">
                <label class="control-label">Cover Photo</label><br/>
                  <?php if(!empty($gallery['cover_photo'])): ?>
                     <p><img src="<?= base_url($gallery['cover_photo']); ?>" class="cover_photo logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="cover_photo" accept=".png, .jpg, .jpeg, .gif, .svg">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_cover_photo" value="<?php echo html_escape(@$gallery['cover_photo']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Photo Album" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div> 
   <script type="text/javascript">
  $(document).ready(function(){     
     $("#galleryForm").validate({
        rules: {
            album:"required",
            description: "required",
            sort_order: "required",
            status: "required",
            slug: "required",
            cover_photo:{
                  
                  extension:"jpg|png|gif|jpeg",
                  },
        },
        messages: {
            album:"Please Enter Album Name",
            description: "Please Enter Description",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
            slug: "Please Enter SEO URL",
            cover_photo:{
                   
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
        },
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#galleryForm").valid()){
            $("#galleryForm").submit();
        }
    });
  });  
</script>