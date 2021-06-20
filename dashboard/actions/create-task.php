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
    $id = $_POST['id'];
    $recipient = $_POST['recipient'];
    $status = $_POST['status'];
    $assigned_by = getPlayername(getPlayerUUID($_SESSION['user_id']));
    $update = date("h:ia - Y.m.d");

    $sql = "INSERT INTO staffcoreui_tasks(RECIPIENT,TASK_ID,ASSIGNED_BY,STATUS,last_update) VALUES ('".$recipient."','".$id."','".$assigned_by."','".$status."','".$update."')";
    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','created a task with the ID #".$id."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        header("Location: ../task/?id=".$id);
      } else {
        header("Location: ../task/?id=".$id);
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/srstaff/tasks/");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/srstaff/tasks/");
  }

?>
