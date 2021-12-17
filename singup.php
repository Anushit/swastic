<?php require_once('config.php');?>

<?php
if(isset($_POST['email'])){ 
     $data = $_POST;
     $saveData = postData('savenewsletter',$data);
     if($saveData['status']==1){
     	echo "subscribe successfully";

     }
     else
     	echo "Filled is required !please try again:";

   }

?>