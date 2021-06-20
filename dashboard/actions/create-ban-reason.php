<?php

  session_start();

  require_once("../../staffcore/configs/config.php");
  require_once("../../staffcore/mysql.php");

  if(!isset($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>">
    <?php
    exit();
  }

  require_once("../../staffcore/functions.php");

  if(isset($_POST['submit'])){
    if(!existsBanReason($_POST['reason_name'])){

      $time = 0;

      if($_POST['time_unit'] == "d"){
        $time = 1000*60*60*24;
        $length = $time * $_POST['time_value'];
      } else if($_POST['time_unit'] == "h"){
        $time = 1000*60*60;
        $length = $time * $_POST['time_value'];
      } else if($_POST['time_unit'] == "m"){
        $time = 1000*60;
        $length = $time * $_POST['time_value'];
      } else if($_POST['time_unit'] == "perma"){
        $length = -1;
      }

      $sql = "INSERT INTO ReportSystem_reasonsdb(TYPE,NAME,BAN_LENGTH) VALUES ('BAN','".$_POST['reason_name']."','".$length."')";
      if(mysqli_query($conn,$sql)){
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','created a new Ban-Reason with the Name ".$_POST['reason_name']."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../admin/manager/ban/?success=Reason%20was%20created%21");
        } else {
          header("Location: ../admin/manager/ban/?success=Reason%20was%20created%21");
        }
      } else {
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/ban");
      }

    } else {
      header("Location: ../admin/manager/ban/?error=Reason%20already%20exists%21");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/ban");
  }
?>
