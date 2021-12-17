 
 <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content">
      <div class="card card-default color-palette-bo ">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-arrow-up"></i>
             Apply User Detail &nbsp <span class="badge badge-primary"><?= $job_data['first_name']?></span></h3>
          </div>
        </div>
      </div>
      <div class="card card-default color-palette-bo">
      <div class="card-header">
          <div class="d-inline-block">
            <h4><i class="fa fa-info-circle"></i>

              User Detail</h4>
          </div>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                 <b>User Name </b>
                </div>
                <div class="col-sm-6">
                 :  <?= $job_data['first_name'].' '.$job_data['last_name'];?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                  <b>Email </b>
                </div>
                <div class="col-sm-6">
               : <?= $job_data['email'];?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                  <b> Phone </b>
                </div>
                <div class="col-sm-6">
               : <?= $job_data['mobile'];?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                  <b> Experience </b>
                </div>
                <div class="col-sm-6">
               : <?= $job_data['experience'] ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                  <b>Job Title </b>
                </div>
                <div class="col-sm-6">
               : <?= $job_data['career_id'] ?>
                </div>
              </div>
            </div>
           <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                  <b> Apply Date </b>
                </div>
                <div class="col-sm-6">
                  : <?= date_time($job_data['created_at']);?>
                </div>
              </div>
            </div>
          </div>
    
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                 <b> Job Status</b>
                </div>
                <div class="col-sm-6">
                   : &nbsp <?php if($job_data['is_job_result']==0){echo "<big><span class='badge badge-pill badge-warning'>Pending</span></big>"; }
                   if($job_data['is_job_result']==1){echo "<big><span class='badge badge-success badge-pill'>Selected</span></big>"; }
                   if($job_data['is_job_result']==2){echo "<big><span class='badge badge-danger badge-pill'>Reject</span></big>"; } ?>
               
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-4">
                 <b> Interview Status</b>
                </div>
                <div class="col-sm-6">
                   : &nbsp <?php if($job_data['is_schudule_Interview']==0){echo "<big><span class='badge badge-pill badge-danger'>Not Scheduled</span></big>"; }
                   if($job_data['is_schudule_Interview']==1){echo "<big><span class='badge badge-success badge-pill'>Scheduled</span></big>"; }
                ?>
                </div>
              </div>
            </div>
          </div>
      
          <div class="row">
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-4">
                   <b> Job Title</b>
                  </div>
                  <div class="col-sm-6">
                     : &nbsp<?= $job_data['job_name'] ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-4">
                   <b> CV </b>
                  </div>
                  <div class="col-sm-6">
                    <?php if(!empty($job_data['cv'])){?>
                      : &nbsp<a href="<?= base_url().$job_data['cv'] ?>" download><i class="fa fa-download"></i></a>
                    <?php }else{?>
                           : &nbsp Not Uploaded
                    <?php }  ?>
                     
                 
                  </div>
                </div>
              </div>
             
            </div>
           <div class="row">
             <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                   <b>  Description </b>
                  </div>
                  <div class="col-sm-9">
                    :
                 <?= $job_data['description'];?>
                  </div>
                </div>
              </div>
           </div>
      </div>
    </section> 
    <section class="content">
     <div class="row">
        <div class="col-12">
          <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3"><i class="fa fa-paper-plane"></i> Schedule Interview </h3>
                
              </div> 
            <div class="card-body ">   
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <?php if($job_data['is_job_result']==0){?>
                    <div class="card-body ">   
                      <!-- For Messages -->
                      <div class="error"> </div>
                        <?php $this->load->view('includes/_messages.php') ?>
                        <?php echo form_open_multipart(base_url('career/view_jobdetail/'.$job_data['id']), 'class="form-horizontal" id ="myform"');  ?>
                          <div class="form-group row">
                            <div class="col-sm-12 card-header"> <h5><b>HR Schedule</b></h5></div>
                            <div class="col-sm-6">
                              <label for="hr_schedule_date" class="col-sm-12 control-label">Schedule Date<span class="red">*</span></label>
                              <input type="datetime-local" <?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> class="form-control" id="hr_schedule_date" value="<?php if(!empty($schedule_data)){ echo $schedule_data['hr_schudule_date'];}?>" name="hr_schedule_date">
                            </div>                
                            <div class="col-sm-6">
                              <label for="hr_perform" class="col-sm-12 control-label"> Interview Perform <span class="red">*</span></label>
                              <input type="text"<?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> name="hr_perform" class="form-control" id="hr_perform" placeholder="" value="<?php if(!empty($schedule_data)){ echo $schedule_data['hr_schudule_perform'];}?>"><?= set_value('hr_perform'); ?>
                            </div>
                            
                          </div>  
                          <div class="form-group row">  
                            <div class="col-sm-12 card-header"> <h5><b>Technical Schedule</b></h5></div>
                            <div class="col-sm-6">
                              <label for="technical_schedule_date" class="col-sm-12 control-label"> Schedule Date<span class="red">*</span></label>
                              <input type="datetime-local" <?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> class="form-control" id="technical_schedule_date"  value="<?php if(!empty($schedule_data)){ echo  $schedule_data['technical_schudule_date'];}?>" name="technical_schedule_date">
                            </div>
                            <div class="col-sm-6">
                              <label for="technical_perform"  class="col-sm-12 control-label"> Interview Perform <span class="red">*</span></label>
                              <input type="text" <?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> name="technical_perform" class="form-control" id="technical_perform" placeholder="" value="<?php if(!empty($schedule_data)){ echo $schedule_data['technical_schudule_perform'];}?>"><?= set_value('technical_perform'); ?>
                            </div>
                          </div>  
                          <div class="form-group row">  
                          <div class="col-sm-12 card-header"> <h5><b>Final Schedule</b></h5></div>              
                            <div class="col-sm-6">
                              <label for="final_schedule_date" class="col-sm-12 control-label"> Schedule Date<span class="red">*</span></label>
                              <input type="datetime-local" <?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> class="form-control" id="final_schedule_date" value="<?php if(!empty($schedule_data)){ echo $schedule_data['technical_schudule_date'];}?>" name="final_schedule_date">
                            </div>
                            <div class="col-sm-6">
                              <label for="final_perform" class="col-sm-12 control-label"> Interview Perform <span class="red">*</span></label>
                              <input type="text" <?php if($schedule_data['is_job_result']!=0){ echo 'readonly' ;}?> name="final_perform" class="form-control" id="final_perform" placeholder="" value="<?php if(!empty($schedule_data)){ echo $schedule_data['final_schudule_perform'];}?>"><?= set_value('final_perform'); ?>
                            </div>
                          </div>  
                     
                          <div class="form-group">
                            <div class="col-md-12">
                              <input type="submit"   name="submit"value="Set Schedule" class="btn btn-info pull-right">
                            </div>
                          </div>
                        <?php echo form_close( ); ?>
                      <!-- box-body -->
                    </div>
                  <?php } else {?>
                   <div class="card-body ">   
                          <div class="form-group row">
                            <div class="col-sm-12 card-header"> <h5><b> HR Schedule</b></h5></div>
                            <div class="col-sm-6">
                              <label for="hr_schedule_date" class="col-sm-12 control-label">Schedule Date </label>
                              <div class="form-control" ><?= $schedule_data['hr_schudule_date'] ?> </div>
                            </div>  
                            <div class="col-sm-6">
                              <label for="hr_schedule_date" class="col-sm-12 control-label">Interview Perform</label>
                              <div class="form-control"><?php echo $schedule_data['hr_schudule_perform']; ?> </div>
                            </div>               
                          </div>  
                          <div class="form-group row">
                            <div class="col-sm-12 card-header"> <h5><b>Technical Schedule</b></h5></div>
                            <div class="col-sm-6">
                              <label  class="col-sm-12 control-label">Schedule Date </label>
                              <div  class="form-control"><?php echo $schedule_data['technical_schudule_date']; ?> </div>
                            </div>  
                            <div class="col-sm-6">
                              <label for="technical_schedule_date" class="col-sm-12 control-label">Interview Perform</label>
                              <div class="form-control"><?php echo $schedule_data['technical_schudule_perform']; ?> </div>
                            </div>               
                          </div>  
                            <div class="form-group row">
                            <div class="col-sm-12 card-header"> <h5><b>Final Schedule</b></h5></div>
                            <div class="col-sm-6">
                              <label  class="col-sm-12 control-label">Schedule Date </label>
                              <div  class="form-control"><?php echo $schedule_data['final_schudule_date']; ?> </div>
                            </div>  
                            <div class="col-sm-6">
                              <label for="technical_schedule_date" class="col-sm-12 control-label">Interview Perform</label>
                              <div class="form-control"><?= $schedule_data['final_schudule_perform']; ?> </div>
                            </div>               
                          </div> 
                      <!-- box-body -->
                    </div>
                  <?php } ?>
                  </div>

                 
                </div>
            </div> 
          </div>
        </div>   
      </div>
    </section>
    <section class="content">
       <?php  if($job_data['is_schudule_Interview']==1 AND $job_data['is_job_result']==0){ ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                  <h3 class="card-title p-3"><i class="fa fa-list-alt"></i> Result</h3>
                  
                </div> 

              <div class="card-body ">   
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                      <div class="card-body ">   
                        <!-- For Messages -->
                        <div class="error"> </div>
                          <?php $this->load->view('includes/_messages.php') ?>
                          <?php echo form_open_multipart(base_url('career/jobresult/'.$job_data['id']), 'class="form-horizontal" id ="resultform"');  ?>
                           <div class="form-group row">                
                              <div class="col-sm-6">
                                <label for="job_result" class="col-sm-12 control-label">Result <span class="red">*</span></label>
                                <select class="form-control" name="job_result" id="job_result">
                                  <option value=""> Choose </option>
                                  <option value="1" 
                                  <?php if(!empty($schedule_data['is_job_result'] AND $schedule_data['is_job_result']==1)){ echo 'Selected';}?>> Select </option>
                                  <option value="2"<?php if(!empty($schedule_data['is_job_result'] AND $schedule_data['is_job_result']==2)){ echo 'Selected';}?>> Reject </option>
                                </select>
                              </div>
                              <div class="col-sm-6">
                                <label for="attachment" class="col-sm-12 control-label">Upload Doc <span class="red">*</span></label>
                                <input type="file"  class="form-control" name="attachment">
                                <span> <small class="text-success">Allowed Types: gif, jpg, png, jpeg, pdf</small></span>
                              </div>
                            </div>  
                            <div class="form-group row">                
                              <div class="col-sm-12">
                                <label for="message" class="col-sm-12 control-label">Comments <span class="red">*</span></label>
                                <textarea name="message" class="form-control" id="message" placeholder="" value=""><?php if(!empty($schedule_data['comments'])){ echo $schedule_data['comments'];}?><?= set_value('message'); ?></textarea>
                              </div>
                            </div>  
                            <div class="form-group">
                              <div class="col-md-12">
                                <input type="submit" name="submit" value="submit" class="btn btn-info btn-result pull-right">
                              </div>
                            </div>
                          <?php echo form_close( ); ?>
                        <!-- box-body -->
                      </div>
                    </div>
                  </div>
              </div> 
            </div>
          </div>   
        </div>
      <?php  } else{  ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                  <h3 class="card-title p-3"><i class="fa fa-list-alt"></i> Result</h3>
                  
                </div> 

              <div class="card-body ">   
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                      <div class="card-body ">   
                           <div class="form-group row">                
                              <div class="col-sm-6">
                                <label for="job_result" class="col-sm-12 control-label">Result </label>
                                <?php if($job_data['is_job_result']==1){ ?>
                                <div class="control-label"><h4> <i class="text-success fa fa-check "></i>Congratulation,<span> <?= $job_data['first_name'].' '.$job_data['last_name']?></span> </h4>
                                </div>
                                <div class=""> You are Selected in <?= $this->general_settings['application_name']; ?>
                                </div>
                                <?php } ?>
                                <?php if($job_data['is_job_result']==2){ ?> 
                                <div class="control-label"><h4> <i class="text-danger fa fa-times "></i>Sorry,<span> <?= $job_data['first_name'].' '.$job_data['last_name']?></span> </h4>
                                </div>
                                <div class=""> You are Rejected in <?= $this->general_settings['application_name']; ?>
                                </div>
                                <?php } ?>
                              </div>
                              <div class="col-sm-6">
                                <label class="col-sm-12 control-label">Upload Doc</label>
                                <div > <?php if(!empty($job_data['image'])){?>
                                  
                                  <object data="<?= base_url().$job_data['image'] ?>" type="application/pdf"  download width="100%" height="100%">
                                </object>
                                <a href="<?= base_url().$job_data['image'] ?>" download><h3><i class="fa fa-download"></i></h3>
                                  </a>
                                <?php }else{?>
                                        Not Uploaded
                                <?php }  ?>   </div>
                              </div>  
                              <div class="form-group row">                
                                <div class="col-sm-12">
                                  <label class="col-sm-12 control-label">Comment</label>
                                  <div class="form-control"> <?= $job_data['comments']?>      </div>
                                </div>
                              </div>  
                          
                          <?php echo form_close( ); ?>
                        <!-- box-body -->
                      </div>
                    </div>
                  </div>
              </div> 
            </div>
          </div>   
        </div>
      <?php  } ?>
</section>
</div>
<script type="text/javascript">
  $(document).ready(function(){     
     $("#myform").validate({
        rules: {
            hr_schedule_date:"required",
            hr_perform:"required",
            technical_schedule_date:"required",
            technical_perform:"required",
            final_schedule_date:"required",
            final_perform:"required",

        },
        messages: {
            hr_schedule_date:"Please Choose Hr Schedule Date",
            hr_perform:"Please Enter Hr Perform",
            technical_schedule_date:"Please Choose Technical Schedule Date",
            technical_perform:"Please Enter Technical Perform",
            final_schedule_date:"Please Choose Final Schedule Date",
            final_perform:"Please Enter Final Perform",
        
        }
    });
  $("body").on("click", ".btn-submit", function(e){
          if ($("#myform").valid()){
              $("#myform").submit();
          }
      });
     $("#resultform").validate({
        rules: {
            job_result:"required",
            message:"required",
           attachment:{
                  extension:"jpg|png|gif|jpeg|pdf",
                  },
           

        },
        messages: {
            job_result:"Please Choose Result",
            message:"Please Enter Messages",
            attachment:{
                extension:"Please upload file in these format only (jpg, jpeg, png, gif, pdf)",
                 },
            
        
        }
    });
    $("body").on("click", ".btn-result", function(e){
        if ($("#resultform").valid()){
            $("#resultform").submit();
        }
    });
  });  
</script>