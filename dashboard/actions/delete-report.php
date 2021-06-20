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

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $update = date("h:ia - Y.m.d");

    $sql = "DELETE FROM ReportSystem_reportsdb WHERE id = '".$id."'";
    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','deleted a Report with the ID #".$id."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        header("Location: ../reports/archive/?success=The%20Report%20was%20deleted");
      } else {
        header("Location: ../reports/archive/?success=The%20Report%20was%20deleted");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/reports/active");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/reports/active");
  }
?>
