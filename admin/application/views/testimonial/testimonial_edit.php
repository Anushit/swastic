<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              Update Testimonial </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('testimonial'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Testimonial List</a>
          </div>
        </div>
        <div class="card-body">   
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('testimonial/edit/'.$testimonial['id']), 'class="form-horizontal" id="testimonialForm"');  ?>                            
              <div class="form-group row"> 
                <div class="col-sm-6">
                <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>  
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name',$testimonial['name']); ?>">
                </div>
                <div class="col-sm-6">
                <label for="designation" class="col-sm-6 control-label">Designation <span class="red">*</span></label>  
                  <input type="text" name="designation" class="form-control" id="designation" placeholder="" value="<?= set_value('designation',$testimonial['designation']); ?>">
                </div>
              </div>
              <div class="form-group row"> 
                <div class="col-sm-12">
                  <label for="message " class="col-sm-6 control-label">Message</label>
                  <textarea name="message" class="form-control" id="message" ><?= set_value('message',$testimonial['message']); ?></textarea> 
                </div>
              </div>
 
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="sort_order" class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" value="<?= set_value('sort_order',$testimonial['sort_order']); ?>">
                </div>
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status',$testimonial['is_active']) == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status',$testimonial['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
               
              <div class="form-group row"> 
                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                  <?php if(!empty($testimonial['image'])): ?>
                     <p><img src="<?= base_url($testimonial['image']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$testimonial['image']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Testimonial" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div> 
   <script type="text/javascript">
  $(document).ready(function(){     
     $("#testimonialForm").validate({
        rules: {
            name:"required",
            message: "required",
            sort_order: "required",
            status: "required",
            designation: "required",
            image:{
                 
                  extension:"jpg|png|gif|jpeg",
                  },
        },
        messages: {
            name:"Please Enter Name",
            message: "Please Enter Message",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
            designation: "Please Enter Designation",
            image:{
                   
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
        },
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#testimonialForm").valid()){
            $("#testimonialForm").submit();
        }
    });
  });  
</script>