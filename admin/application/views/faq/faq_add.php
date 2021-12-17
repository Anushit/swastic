<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Add FAQ </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('faq'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  FAQ List</a>

          </div>

        </div>

        <div class="card-body">  
           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>

            <?php echo form_open(base_url('faq/add'), 'class="form-horizontal" id="faqForm"');  ?> 
             
              <div class="form-group row">
                            
                <div class="col-sm-6">
                  <label for="is_active" class="col-sm-6 control-label">FAQ Type <span class="red">*</span></label> 
                  <select name="faqtype" id="faqtype"class="form-control">
                    <option value="">Select Type</option>
                    <?php foreach($Faqtype as $row){ ?>
                    <option value="<?= $row['id']?>" <?= (set_value('id') == $row['id'])?'selected': '' ?> ><?= $row['name']?></option>
                    <?php } ?>
                  </select>
                </div>
           
                <div class="col-sm-6">
                   <label for="faq_question" class="col-sm-6 control-label">FAQ Question <span class="red">*</span></label>
                  <input type="text" name="faq_question" class="form-control" id="faq_question" placeholder="" value="<?= set_value('faq_question'); ?>">
                </div>
              </div> 
               
              <div class="form-group row"> 
                <label for="answer" class="col-sm-6 control-label">Answer <span class="red">*</span></label>
                <div class="col-sm-12">
                  <textarea name="answer" class="form-control textarea" id="answer" placeholder=""><?= set_value('answer'); ?></textarea> 
                </div>
              </div>

              <div class="form-group row"> 
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order'); ?>">
                </div>                
                <div class="col-sm-6">
                  <label for="is_active" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>
                  <select name="status"id="status"  class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('is_active') == '1')?'selected': '' ?> >Active</option>
                    <option value="0" <?= (set_value('is_active') == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add FAQ" class="btn btn-submit btn-info pull-right">
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
     $("#faqForm").validate({
        rules: {
            faqtype:"required",
            faq_question: "required",
            answer: "required",
            sort_order: "required",
            status: "required",
            slug: "required",
            
         },
        messages: {
            faqtype:"Please Select FAQ Type",
            faq_question:"Please Enter Question",
            answer: "Please Enter Answer",
            slug: "Please Enter SEO URL",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#faqForm").valid()){
            $("#faqForm").submit();
        }
    });
  });  
</script>