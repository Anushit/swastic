  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Add New career Page </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('career'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Career Pages List</a>

          </div>

        </div>

        <div class="card-body">  
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>

            <?php echo form_open(base_url('career/add'), 'class="form-horizontal" id="careerForm"');  ?> 
             
              <div class="form-group row">
                 <div class="col-sm-6">
                   <label for="name" class="col-sm-6 control-label">Career Name <span class="red">*</span></label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name'); ?>">
                </div>

                     
                <div class="col-sm-6">
                  <label for="type" class="col-sm-6 control-label">Career Type <span class="red">*</span></label>
                  <select name="type" id="type"class="form-control">
                    <option value="">Select Career</option>
                    <option value="full" <?= (set_value('type')  == 'full')?'selected': '' ?>>Full Time </option>
                    <option value="part" <?= (set_value('type')  == 'part')?'selected': '' ?>>Part time</option>
                    <option value="hour" <?= (set_value('type')  == 'hour')?'selected': '' ?>>Hour</option>
                  </select>
                </div>
              </div>
             
              <div class="form-group row">
                <div class="col-sm-6">
                  <label for="opening_date" class="col-sm-6 control-label">Opening Date <span class="red">*</span></label>
                  <input type="date" name="opening_date" class="form-control" id="opening_date" placeholder="" value="<?= set_value('opening_date'); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="is_active" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1"  <?= (set_value('status')  == '1')?'selected': '' ?>>Active</option>
                    <option value="0"  <?= (set_value('status')  == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>
               <div class="form-group row">
                <label for="qualification" class="col-sm-6 control-label"> Qualification <span class="red">*</span></label>
                <div class="col-sm-12">
                  <textarea name="qualification" class="form-control textarea" id="qualification" placeholder=""><?= set_value('qualification'); ?></textarea> 
                </div>
              </div>
              <div class="form-group row">
                <label for="experince" class="col-sm-6 control-label"> Experince <span class="red">*</span></label>
                <div class="col-sm-12">
                  <textarea name="experince" class="form-control textarea" id="experince" placeholder=""><?= set_value('experince'); ?></textarea> 
                </div>
                
              </div>
              <div class="form-group row"> 
                <label for="description" class="col-sm-6 control-label"> Job Description <span class="red">*</span></label>
                <div class="col-sm-12">
                  <textarea name="description" class="form-control textarea" id="description" placeholder=""><?= set_value('description'); ?></textarea> 
                </div>
              </div>

              <div class="form-group row"> 
              <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug'); ?>"> 
              </div>
              <div class="form-group col-sm-6"> 
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order'); ?>">
              </div>  
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Career" class="btn btn-submit btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
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
     $("#careerForm").validate({
        rules: {
            name:"required",
            opening_date:{
                    required:true,
                    date:true,
                    },
            description: "required",
            qualification:"required",
            experince: "required",
            type: "required",
            slug: "required",
            sort_order: "required",
            status: "required",
            
         },
        messages: {
            name:"Please Enter Name",
            opening_date:{
                    required:'Please Enter Date',
                    date:"Please select valid date",
                    },
            description: "Please Enter Job Description",
            qualification: "Please Enter Job qualification",
            experince: "Please Enter Job experince",
            type: "Please Enter Career type",
            slug: "Please Enter SEO URL",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#careerForm").valid()){
            $("#careerForm").submit();
        }
    });
  });  
</script>  