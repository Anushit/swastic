  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/select2.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Add New Category </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('category'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Category List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('category/add'), 'class="form-horizontal" id="categoryForm"');  ?> 
                           
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="parent_id" class="col-sm-6 control-label">Main Category <span class="red">*</span></label>
                  <select class="form-control select2" name="parent_id" required="" id="parent_id" >
                   <option value="0">Parent</option> 
                   <?php 
                   foreach ($parcat as $key => $pcat) { ?>
                    <option value="<?php echo $pcat['id']?>" <?= (set_value('parent_id') == $pcat['id'])?'selected': '' ?>><?php echo $pcat['name']?></option>
                   <?php } ?>                   
                  </select> 
                </div> 
                <div class="col-sm-6">
                <label for="name" class="col-sm-6 control-label">Category Name <span class="red">*</span></label>  
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name'); ?>">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-6">
                <label for="meta_title" class="col-sm-6 control-label">Meta Title <span class="red">*</span></label>  
                  <input type="text" name="meta_title" class="form-control" id="meta_title" placeholder="" value="<?= set_value('meta_title'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="meta_keyword " class="col-sm-6 control-label">Meta Keyword  <span class="red">*</span></label>
                  <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" placeholder="" value="<?= set_value('meta_keyword'); ?>">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-6">
                <label for="meta_description" class="col-sm-6 control-label">Meta Description <span class="red">*</span></label>  
                  <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="" value="<?= set_value('meta_description'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order'); ?>">
                </div>
              </div>
              <div class="form-group row">               
                <div class="col-sm-12">
                   <label for="description" class="col-sm-6 control-label">Description <span class="red">*</span></label>
                   <textarea name="description" class="form-control" id="description" placeholder="" ><?= set_value('description'); ?></textarea> 
                </div>  
              </div>
              <div class="form-group row"> 
               <div class="col-md-6">
                  <label for="is_feature" class="col-sm-6 control-label">Is Featured<span class="red">*</span></label>                  
                  <select name="is_feature" id="is_feature"class="form-control">
                    <option value="">Select Is Featured</option>
                    <option value="1" <?= (set_value('is_feature') == '1')?'selected': '' ?>>Yes</option>
                    <option value="0" <?= (set_value('is_feature') == '0')?'selected': '' ?>>No</option>
                  </select>
                </div>        
                <div class="col-md-6">
                  <label for="role" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status') == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status') == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>
              <div class="form-group row"> 
                <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug'); ?>"> 
                </div>
                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                  <?php if(!empty($cat['image'])): ?>
                     <p><img src="<?= base_url($cat['image']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$cat['image']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Category" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

   })
    /*function getsubcategroy(id)
    {  
      var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
      csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
       var dataJson = { [csrfName]: csrfHash, id: id };
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>category/get_subcategroy",
            data: dataJson,
            success: function (data) {
                $('#loadsubcategory').html(data);
            },
        });
        return true;
    }*/
</script>

<script type="text/javascript">
  $(document).ready(function(){     
     $("#categoryForm").validate({
        rules: {
            parent_id:"required",
            name:"required",
            meta_keyword:"required",
            meta_title:"required",
            meta_description:"required",
            is_feature: "required",
            description: "required",
            sort_order: "required",
            status: "required",
            slug: "required",
            image:{
                    required:true,
                    extension:"jpg|png|gif|jpeg",
                    },
         },
        messages: {
            parent_id:"Please Select Main Category",
            name:"Please Enter Category Name",
            meta_keyword: "Please Enter Meta Keyword",
            meta_title: "Please Enter Meta title",
            meta_description: "Please Enter Meta Description",
            is_feature: "Please Select is feature",
            description: "Please Enter Description",
            slug: "Please Enter SEO URL",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
            image:{
                    required:"Please Select Photo",
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#categoryForm").valid()){
            $("#categoryForm").submit();
        }
    });
  });  
</script>