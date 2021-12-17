  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Edit Banner </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('banner'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Banner List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>

            <?php echo form_open_multipart(base_url('banner/edit/'.$banner['id']), 'class="form-horizontal" id="bannerForm"'); ?> 
                           
              <div class="form-group row"> 
                <div class="col-sm-6">
                <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>  
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name',$banner['name']); ?>">
                </div>
                <div class="col-sm-6">
                <label for="title_first" class="col-sm-6 control-label">First Title</label>  
                  <input type="text" name="title_first" class="form-control" id="title_first" placeholder="" value="<?= set_value('title_first',$banner['title_first']); ?>">
                </div>
              </div>
 

              <div class="form-group row">
                <div class="col-sm-6">
                <label for="title_second" class="col-sm-6 control-label">Second Title </label>  
                  <input type="text" name="title_second" class="form-control" id="title_second" placeholder="" value="<?= set_value('title_second',$banner['title_second']); ?>">
                </div> 
                <div class="col-sm-6">
                <label for="url_link" class="col-sm-6 control-label">URL </label>  
                  <input type="text" name="url_link" class="form-control" id="url_link" placeholder="" value="<?= set_value('url_link',$banner['url_link']); ?>">
                </div>  
              </div>

              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order',$banner['sort_order']); ?>">
                </div> 
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" id = "status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status', $banner['is_active']) == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status', $banner['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
               
              <div class="form-group row"> 
                

                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                  <?php if(!empty($banner['image'])): ?>
                     <p><img src="<?= base_url($banner['image']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image" id="image">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$banner['image']); ?>">
               </div>
               <div class="col-md-6">
                <label class="control-label">Image1</label><br/>
                  <?php if(!empty($banner['image1'])): ?>
                     <p><img src="<?= base_url($banner['image1']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image1" id="image1">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$banner['image1']); ?>">
               </div>
               <div class="col-md-6">
                <label class="control-label">Image2</label><br/>
                  <?php if(!empty($banner['image2'])): ?>
                     <p><img src="<?= base_url($banner['image2']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image2" id="image2">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$banner['image2']); ?>">
               </div>
               <div class="col-md-6">
                <label class="control-label">Image3</label><br/>
                  <?php if(!empty($banner['image3'])): ?>
                     <p><img src="<?= base_url($banner['image3']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image3" id="image3">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$banner['image3']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Banner" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div> 
  <script type="text/javascript">
  $(document).ready(function(){     
     $("#bannerForm").validate({
        rules: {
            name:"required",
            title_first: "required",
            title_second: "required",
            url_link:{
                        required: true,
                        minlength: 5
                    },
            sort_order: "required",
            status: "required",
            image:{
                    extension:"jpg|png|gif|jpeg",
                    },
         },
        messages: {
            name:"Please Enter Name",
            title_first: "Please Enter First Title",
            title_second: "Please Enter Second Title",
            
            url_link:{
                        "required": "Please Enter Url Link",
                    },
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
            image:{
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#bannerForm").valid()){
            $("#bannerForm").submit();
        }
    });
  });  
</script>