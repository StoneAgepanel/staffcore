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
    $name = $_POST['reason_name'];
    $material = $_POST['material'];
    $update = date("h:ia - Y.m.d");

    $sql = "INSERT INTO ReportSystem_reasonsdb(TYPE,NAME,REPORT_ITEM) VALUES ('REPORT','".$name."','".$material."')";
    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','created a new Report-Reason with the Name ".$name."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        header("Location: ../admin/manager/report/?success=Reason%20was%20created%21");
      } else {
        header("Location: ../admin/manager/report/?success=Reason%20was%20created%21");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/report");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/report");
  }

?>
