<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
              <div class="d-inline-block">
                  <h3 class="card-title"> <i class="fa fa-plus"></i>
                  General Settings </h3>
              </div>
            </div>
            <div class="card-body">   
                 <!-- For Messages -->
                <?php $this->load->view('includes/_messages.php') ?>

                <?php echo form_open_multipart(base_url('general_settings/add')); ?>	
                <!-- Nav tabs -->

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <?php  
                foreach ($parent_setting['type'] as $key => $value) {
                  if($key==1){
                    $istrue = 'true';
                    $isactive = 'active';
                  }else{
                    $istrue = 'false';
                    $isactive = '';   
                  }
                 ?>
                  <li class="nav-item">
                    <a class="nav-link <?php echo $isactive; ?>" id="pills-home-tab" data-toggle="pill" href="#<?php echo $value; ?>" role="tab" aria-controls="<?php echo $value; ?>" aria-selected="<?php echo $istrue; ?>"><?php echo $parent_setting['name'][$key]; ?></a>
                  </li> 
                 <?php } ?>  
                </ul>

                 <!-- Tab panes -->
                <div class="tab-content">
                  <?php  
                  foreach ($parent_setting['type'] as $key => $value) {
                    if($key==1){
                      $istrue = 'true';
                      $isactive = 'active';
                    }else{
                      $istrue = 'false';
                      $isactive = '';   
                    }
                   ?> 
                    <div role="tabpanel" class="tab-pane <?php echo $isactive; ?>" id="<?php echo $value; ?>"> 
                      <?php foreach ($general_settings[$key] as $skey => $svalue) { 
                        switch ($svalue['filed_type']) {
                        case "file":  ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $svalue['filed_label']; ?></label><br/>
                            <?php if(!empty($svalue['filed_name'])): ?>
                               <p><img src="<?= base_url($svalue['filed_value']); ?>" class="<?php echo $svalue['filed_name'] ?> <?php echo $svalue['filed_name'].'smallimg' ?>"></p>
                           <?php endif; ?>
                           <input type="file" name="<?php echo $svalue['filed_name'].'_'.$svalue['id']; ?>" accept=".png, .jpg, .jpeg, .gif, .svg">
                           <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                           <input type="hidden" name="SettingOld[filedval][<?php echo $svalue['id'] ?>] ?>" value="<?php echo html_escape($svalue['filed_value']); ?>">
                       </div>
                      <?php  
                        break;
                        case "text": ?> 
                          <div class="form-group">
                            <label class="control-label"><?php echo $svalue['filed_label']; ?></label>
                            <input type="text" class="form-control" name="Setting[filedval][<?php echo $svalue['id'] ?>]" placeholder="<?php echo $svalue['filed_label']; ?>" value="<?php echo html_escape($svalue['filed_value']); ?>">
                          </div>
                          <?php 
                          if($svalue['filed_name']=='timezone'){
                            echo '<a href="http://php.net/manual/en/timezones.php" target="_blank">Timeszones</a>';
                          }
                          ?>
                      <?php  
                        break;
                        case "password":
                        ?>
                          <div class="form-group">
                            <label class="control-label"><?php echo $svalue['filed_label']; ?></label>
                            <input type="password" class="form-control" name="Setting[filedval][<?php echo $svalue['id'] ?>]" placeholder="<?php echo $svalue['filed_label']; ?>" value="<?php echo html_escape($svalue['filed_value']); ?>">
                          </div>
                    <?php  
                        break;
                        case "textarea":
                        ?>
                          <div class="form-group">
                            <label class="control-label"><?php echo $svalue['filed_label']; ?></label>
                            <textarea class="form-control" name="Setting[filedval][<?php echo $svalue['id'] ?>]" placeholder="<?php echo $svalue['filed_label'];?>" ><?php echo html_escape($svalue['filed_value']); ?></textarea> 
                          </div>      
                    <?php } 
                      } ?>  
                    </div>
                  <?php } ?>   

                </div> 
                <div class="box-footer">
                    <input type="submit" name="submit" value="Save Changes" class="btn btn-primary pull-right">
                </div>	
                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>

<script>
    $("#setting").addClass('active');
    $('#myTabs a').click(function (e) {
     e.preventDefault()
     $(this).tab('show')
 })
</script>
