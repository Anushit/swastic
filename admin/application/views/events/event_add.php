  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Add New Events </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('events'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Events List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('events/add'), 'class="form-horizontal" id="eventForm"');  ?> 
              <div class="form-group row">                
                <div class="col-sm-6">
                  <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name'); ?>">
                </div>
                <div class="col-sm-6">
                <label for="date" class="col-sm-6 control-label">Event Date<span class="red">*</span></label>  
                  <input type="date" name="event_date" class="form-control" id="event_date" placeholder="" value="<?= set_value('event_date'); ?>">
                </div>
              </div>            
              <div class="form-group row">                
                <div class="col-sm-6">
                  <label for="event_location" class="col-sm-6 control-label">Event Location <span class="red">*</span></label>
                  <input type="text" name="event_location" class="form-control" id="text" placeholder="" value="<?= set_value('event_location'); ?>">
                </div>                
                <div class="col-sm-6">
                <label for="sort_description" class="col-sm-6 control-label">Sort Description<span class="red">*</span></label>  
                  <input type="text" name="sort_description" class="form-control" id="sort_description" placeholder="" value="<?= set_value('sort_description'); ?>">
                </div>
              </div>
              <div class="form-group row">               
                <div class="col-sm-6">
                   <label for="event_start_time" class="col-sm-6 control-label">Event Start Time<span class="red">*</span></label>
                  <input type="time" name="event_start_time" class="form-control" id="event_start_time" placeholder="" value="<?= set_value('event_start_time'); ?>">
                </div>
                <div class="col-sm-6">
                   <label for="event_end_time" class="col-sm-6 control-label">Event event_end_time Time<span class="red">*</span></label>
                  <input type="time" name="event_end_time" class="form-control" id="event_end_time" placeholder="" value="<?= set_value('event_end_time'); ?>">
                </div>  
              </div>

              <div class="form-group row">  
                <div class="col-sm-6">
                  <label for="sort_order " class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order'); ?>">
                </div>   
                <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" id="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status') == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status') == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div> 
              
              <div class="form-group row"> 
                <div class="col-md-12">
                  <label for="description" class="col-sm-6 control-label">Description <span class="red">*</span></label>
                  <textarea name="description" class="form-control textarea" id="description" placeholder=""><?= set_value('description'); ?></textarea> 
                </div>
              </div>
              <div class="form-group row"> 
                <div class="col-sm-6">
                  <label for="slug" class="col-sm-6 control-label">SEO URL <span class="red">*</span></label>
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug'); ?>"> 
                </div>
                <div class="col-md-6">
                <label class="control-label">Image</label><br/>
                 <input type="file" name="image" id="image">
                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$event['image']); ?>">
               </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Add Event" class="btn btn-submit btn-info pull-right">
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
     $("#eventForm").validate({
        rules: {
            
            name:"required",
            event_date:"required",
            event_location:"required",
            sort_description: "required",
            event_start_time:"required",
            event_end_time:"required",
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
            name:"Please Enter Event Name",
            event_date:"Please Select Event date",
            event_location: "Please Event Location",
            sort_description: "Please Event Sort Description",
            event_start_time:"Please Enter Event Start Time",
            event_end_time:"Please Event Event End Time",
            description: "Please  Enter Description",
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
        if ($("#eventForm").valid()){
            $("#eventForm").submit();
        }
    });
  });  
</script>