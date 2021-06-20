<?php

  session_start();

  require_once("../../staffcore/configs/config.php");
  require_once("../../staffcore/mysql.php");

  if(!isset($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>">
    <?php
  }

  require_once("../../staffcore/functions.php");

  if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['reason_name'];

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

    $update = date("h:ia - Y.m.d");

      $sql = "UPDATE ReportSystem_reasonsdb SET NAME = '".$name."', BAN_LENGTH = '".$length."' WHERE id = '".$id."'";
      if(mysqli_query($conn,$sql)){
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','updated a Mute-Reason with the Name ".$_POST['oldname']."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../admin/manager/mute/?success=Reason%20was%20updated%21");
        } else {
          header("Location: ../admin/manager/mute/?success=Reason%20was%20updated%21");
        }
      } else {
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/mute");
        exit();
      }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/mute");
    exit();
  }

?>
