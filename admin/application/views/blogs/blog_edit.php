  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-edit"></i>
              &nbsp; Edit Blogs</h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Blog List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
           
            <?php echo form_open_multipart(base_url('blogs/edit/'.$blog['id']), 'class="form-horizontal" id="blogForm"' )?> 
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>
                  <input type="text" name="name" value="<?= set_value('name',$blog['name']); ?>" class="form-control" id="name" placeholder="">
                </div>
                 <div class="col-md-6">
                <label for="blog_date" class="col-sm-6 control-label">Blog Date<span class="red">*</span></label>  
                  <input type="date" name="blog_date" value="<?= set_value('blog_date',$blog['blog_date']); ?>" class="form-control" id="blog_date" placeholder="">
                </div>
              </div>

              <div class="form-group row">  
                <div class="col-md-6">
                 <label for="email" class="col-sm-6 control-label">Posted By <span class="red">*</span></label>
                  <input type="text" name="posted_by" value="<?= set_value('posted_by',$blog['posted_by']); ?>" class="form-control" id="posted_by" placeholder="">
                </div>
                <div class="col-md-6">
                  <label for="sort_description" class="col-sm-6 control-label">Sort Description<span class="red">*</span></label>
                  <input type="text" name="sort_description" value="<?= set_value('sort_description',$blog['sort_description']); ?>" class="form-control" id="message" placeholder="">
                </div>
              </div>
              
              <div class="form-group row">  
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order',$blog['sort_order']); ?>">
                </div>   
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status',$blog['is_active']) == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status',$blog['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
             

              <div class="form-group"> 
                <div class="col-md-12">
                   <label for="description" class="col-sm-6 control-label">Description <span class="red">*</span></label>
                  <textarea name="description" class="form-control textarea" id="description" placeholder=""><?= set_value('description',$blog['description']); ?></textarea> 
                </div>
              </div>
              <div class="form-group row"> 
                <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug',$blog['slug']); ?>"> 
                </div>
                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                  <?php if(!empty($blog['image'])): ?>
                     <p><img src="<?= base_url($blog['image']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image" >
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$blog['image']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Blog" class="btn btn-submit btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
  </div>  
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
 $(function () { 
    // bootstrap WYSIHTML5 - text editor
   $('.textarea').wysihtml5({
      toolbar: { fa: true, "html": true},
      "html": true,  
      parser: function(html) {
        return html;
      }
    }) 
  })
</script> 
<script type="text/javascript">
  $(document).ready(function(){     
     $("#blogForm").validate({
        rules: {
            name:"required",
            blog_date: "required",
            posted_by: "required",
            sort_description: "required",
            description: "required",
            sort_order: "required",
            status: "required",
            slug: "required",
            image:{
                    
                    extension:"jpg|png|gif|jpeg",
                    },
         },
        messages: {
            name:"Please Enter Name",
            blog_date: "Please Enter Date",
            sort_description: "Please Enter Sort Description",
            posted_by: "Please Enter Post By",
            description: "Please Enter Description",
            slug: "Please Enter SEO URL",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
            image:{
                    
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#blogForm").valid()){
            $("#blogForm").submit();
        }
    });
  });  
</script>