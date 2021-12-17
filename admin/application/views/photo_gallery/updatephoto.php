  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">

        <div class="card-header">

          <div class="d-inline-block">

              <h3 class="card-title"> <i class="fa fa-plus"></i>

              Photos of  <?= @$gallery['album']; ?> List</h3>

          </div>

          <div class="d-inline-block float-right">

            <a href="<?= base_url('gallery/photo'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  Photo Gallery List </a>

          </div>

        </div>

        <div class="card-body">   

           <!-- For Messages -->
            <?php $this->load->view('includes/_messages.php') ?>
            <?php echo form_open_multipart(base_url('gallery/updatephoto/'.$id), 'class="form-horizontal"');  ?> 
            <?php $image_row = 0; ?> 
            
              <div class="row" style="margin-bottom:10px;"><div class="col-md-6"> &nbsp; </div> <div class="col-md-6" style="text-align: right;"> <input type="button" name="addimg" value="Add Image" class="btn btn-warning addimg"> </div> </div>
              <div class="row">
                <div class="col-md-12" id="images" >    
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
                        $htmlData = '<tr id="image-row'.$image_row.'"><td><div class="row">';   
                          if(!empty($ivalue['value'])){ 
                              $htmlData.= '<div class="col-sm-6"><img src="'.base_url($ivalue['value']).'" class="image logosmallimg"></div>';
                          } 
                          $htmlData.= '</div></td><td><input type="text" name="img_order['.$image_row.']" class="form-control" id="img_order['.$image_row.']" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, \' \')" value="'.@$ivalue['sort_order'].'"> <input type="hidden" name="old_image['.$image_row.'][value]" value="'.html_escape($ivalue['value']).'"></td><td><span class="removeimg" cid="'.$image_row.'"><i class="fa fa-trash"></i></span></td></tr>';
                          $image_row++;
                          echo $htmlData; 
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
 
              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Submit Photos" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          <!-- /.box-body -->
        </div>
    </section> 
  </div> 
  
<script type="text/javascript"> 
  $(function () { 
    var image_row = <?php echo $image_row ?>;
    
    $('.addimg').on('click', function() {  
      var html ='<tr id="image-row' + image_row + '"><td><input type="file" name="image[' + image_row + '][image]" accept=".png, .jpg, .jpeg, .gif, .svg"> <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p></td><td><input type="text" name="img_order[' + image_row + ']" class="form-control" id="img_order[' + image_row + ']" placeholder="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, \'\')" value="1"></td><td><span class="removeimg" cid="' + image_row + '"><i class="fa fa-trash"></i></span></td></tr>';

      $('#images tbody').append(html);
      image_row++;
    });   
    $('#product_image_id').delegate('.removeimg', 'click', function() { 
      var pid = $(this).attr('cid');
      $('#image-row'+pid).remove();
    });
  });
</script>