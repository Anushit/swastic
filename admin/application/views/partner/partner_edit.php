  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              Add New Partner </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('partner'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Partner List</a>
          </div>
        </div>
        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('partner/edit/'.$partner['id']), 'class="form-horizontal" id="partnerForm"');  ?> 
                           
              <div class="form-group row"> 
                <div class="col-sm-6">
                <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>  
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name',$partner['name']); ?>">
                </div>
                <div class="col-sm-6">
                <label for="email" class="col-sm-6 control-label">Email<span class="red">*</span></label>  
                  <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?= set_value('email',$partner['email']); ?>">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-6">
                <label for="mobile" class="col-sm-6 control-label">Mobile<span class="red">*</span></label>  
                  <input type="text" name="mobile" class="form-control" id="mobile" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" placeholder="" value="<?= set_value('mobile',$partner['mobile']); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="description " class="col-sm-6 control-label">Description </label>
                  <input type="text" name="description" class="form-control" id="description" placeholder="" value="<?= set_value('description',$partner['description']); ?>">
                </div>
              </div> 

              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order',$partner['sort_order']); ?>">
                </div> 
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" id="status"class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status', $partner['is_active']) == 1)?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status', $partner['is_active']) == 0)?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
               
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug',$partner['slug']); ?>"> 
                </div>   
                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                  <?php if(!empty($partner['image'])): ?>
                     <p><img src="<?= base_url($partner['image']); ?>" class="image logosmallimg"></p>
                 <?php endif; ?>
                 <input type="file" name="image" id="image">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$partner['image']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Partner" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div> 
   <script type="text/javascript">
  $(document).ready(function(){     
     $("#partnerForm").validate({
        rules: {
            name:"required",
            description: "required",
            sort_order: "required",
            slug: "required",
            status: "required",
            email: {required: true, email: true},
            mobile:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                },
            image:{
                  
                  extension:"jpg|png|gif|jpeg",
                  },
             
        },
        messages: {
            name:"Please Enter Name",
            description: "Please Enter Description",
            sort_order: "Please Enter sort_order",
            slug: "Please Enter SEO URL",
            status: "Please Enter Status",
            email: "Please Enter Valid Email Address",
            mobile: {
                    "required": "Please Enter Mobile No",
                    "number": "Please Enter Valid Mobile No",
                    "minlength": "Mobile Should Be 10 Digits",
                    "maxlength": "Mobile Should Be 10 Digits",
                },
          image:{
            
            extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
            },
        
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#partnerForm").valid()){
            $("#partnerForm").submit();
        }
    });
  });  
</script>