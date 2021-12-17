<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/select2.min.css">

<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->

    <section class="content">

      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-edit"></i>

              Update Portfolio </h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('portfolio'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Portfolio List</a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->

            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('portfolio/edit/'.$pro['id']), 'class="form-horizontal" id="portfolioForm"');  ?> 
                      
              <div class="form-group row">
                <div class="col-sm-6">
                <label for="name" class="col-sm-6 control-label">Name <span class="red">*</span></label>  
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value="<?= set_value('name',$pro['name']); ?>">
                </div>
                 <div class="col-md-6">
                  <label for="status" class="col-sm-6 control-label">Select Status <span class="red">*</span></label>                  
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1" <?= (set_value('status',$pro['is_active']) == '1')?'selected': '' ?>>Active</option>
                    <option value="0" <?= (set_value('status',$pro['is_active']) == '0')?'selected': '' ?>>Deactive</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-12">
                <label for="sort_description" class="col-sm-6 control-label">Sort Description <span class="red">*</span></label>   
                  <textarea name="sort_description" class="form-control" id="description" placeholder="" ><?= set_value('sort_description', $pro['sort_description']); ?></textarea> 
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                <label for="meta_title" class="col-sm-6 control-label">Meta Title <span class="red">*</span></label>  
                  <input type="text" name="meta_title" class="form-control" id="meta_title" placeholder="" value="<?= set_value('meta_title',$pro['meta_title']); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="meta_keyword " class="col-sm-6 control-label">Meta Keyword  <span class="red">*</span></label>
                  <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" placeholder="" value="<?= set_value('meta_keyword',$pro['meta_keyword']); ?>">
                </div>
              </div>
               <div class="form-group row"> 
                <div class="col-sm-12">
                  <label for="meta_description" class="col-sm-6 control-label">Meta Description <span class="red">*</span></label>
                  <textarea name="meta_description" class="form-control" id="meta_description" ><?= set_value('meta_description',$pro['meta_description']); ?></textarea> 
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6">
                 <label for="slug" class="col-sm-6 control-label">Seo Url <span class="red">*</span></label>  
                  <input type="text" name="slug" class="form-control" id="slug" placeholder="" value="<?= set_value('slug',$pro['slug']); ?>">
                </div>
                <div class="col-sm-6">
                  <label for="sort_order" class="col-sm-6 control-label">Sort Order <span class="red">*</span></label>
                  <input type="text" name="sort_order" class="form-control" id="sort_order" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')" value="<?= set_value('sort_order',$pro['sort_order']); ?>">
                </div>
              </div>
              <div class="form-group row">               
                <div class="col-sm-12">
                   <label for="description" class="col-sm-6 control-label">Description <span class="red">*</span></label>
                   <textarea name="description" class="form-control textarea" id="description" placeholder="" ><?= set_value('description',$pro['description']); ?></textarea> 
                </div>  
              </div>
              <div class="form-group row">               
                <div class="col-sm-12">
                   <label for="feature" class="col-sm-6 control-label">Feature <span class="red">*</span></label>
                   <textarea name="feature" class="form-control textarea" id="feature" placeholder="" ><?= set_value('feature',$pro['feature']); ?></textarea> 
                </div>  
              </div>
             

              <div class="form-group row">  
                                  
               
              </div>

              <div class="form-group row">
        
                <?php $image_row = 0; ?>
                <div class="col-md-12">    
                 <label class="control-label">Image</label><br/>   
                 <div class="row"><div class="col-sm-5"><input type="file" name="image[<?=$image_row?>][image]" id="image"> <small class="text-success" style="vertical-align: top;">Allowed Types: gif, jpg, png, jpeg</small></div>
                <?php 
                $htmlData = '';
                  foreach ($proimage as $ikey => $ivalue) {  
                    if($ikey==0){
                     
                          if(!empty($ivalue['image'])){ 
                              $htmlData.= '<div class="col-sm-6"><img src="'.base_url($ivalue['image']).'" class="image logosmallimg"></div>';
                          } 
                          $htmlData.= '</div> <input type="hidden" name="img_order['.$image_row.']" class="form-control" id="img_order['.$image_row.']" placeholder="" value="'.$ivalue['sort_order'].'"> <input type="hidden" name="old_image['.$image_row.'][image]" value="'.html_escape($ivalue['image']).'">';
                          $image_row++;
                          echo $htmlData;
                    }
                  }
                ?>  
                <?php $image_row++; ?> <input type="button" name="addimg" value="Add New Image" class="btn btn-primary addimg"  style="float: right;"> </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12" id="images">    
                  <table class="table table-bordered" id="product_image_id">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Sort Order</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php foreach ($proimage as $ikey => $ivalue) {  
                        if($ikey>0){
                        $htmlData = '<tr id="image-row'.$image_row.'"><td><div class="row">';   
                          if(!empty($ivalue['image'])){ 
                              $htmlData.= '<div class="col-sm-6"><img src="'.base_url($ivalue['image']).'" class="image logosmallimg"></div>';
                          } 
                          $htmlData.= '</div></td><td><input type="text" name="img_order['.$image_row.']" class="form-control" id="img_order['.$image_row.']" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, \' \')" value="'.@$ivalue['sort_order'].'"> <input type="hidden" name="old_image['.$image_row.'][image]" value="'.html_escape($ivalue['image']).'"></td><td><span class="removeimg" cid="'.$image_row.'"><i class="fa fa-trash"></i></span></td></tr>';
                          $image_row++;
                          echo $htmlData;
                        }
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Portfolio" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div>
    
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/select2.full.min.js"></script>

<script type="text/javascript"> 
  $(function () { 
    var image_row = <?php echo $image_row ?>;

    //Initialize Select2 Elements
    $('.select2').select2();

    $('.addimg').on('click', function() {  
      var html ='<tr id="image-row' + image_row + '"><td><input type="file" name="image[' + image_row + '][image]" > <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p></td><td><input type="text" name="img_order[' + image_row + ']" class="form-control" id="img_order[' + image_row + ']" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, \'\')" value="1"></td><td><span class="removeimg" cid="' + image_row + '"><i class="fa fa-trash"></i></span></td></tr>';

      $('#images tbody').append(html);
      image_row++;
    });   
    $('#product_image_id').delegate('.removeimg', 'click', function() { 
      var pid = $(this).attr('cid');
      $('#image-row'+pid).remove();
    });

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
     $("#portfolioForm").validate({
        rules: {
            feature:"required",
            name:"required",
            sort_description: "required",
            meta_title:"required",
            meta_keyword:"required",         
            meta_description:"required",
            description: "required",
            sort_order: "required",
            status: "required",
          
            image:{
                    extension:"jpg|png|gif|jpeg",
                    },
         },
        messages: {            
            feature:"Please Enter feature",
      
            name:"Please Enter Product Name",
            sort_description: "Please Product Sort Description",
            meta_title: "Please Meta Title",
            meta_keyword:"Please Enter Meta keyword",   
            meta_description:"Please Enter Meta Description",
            description: "Please  Enter Description",
            sort_order: "Please Enter Sort Order", 
            status: "Please Select Status",
         
            image:{
                    extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                     },
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#portfolioForm").valid()){
            $("#portfolioForm").submit();
        }
    });
  });  
</script>