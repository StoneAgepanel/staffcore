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

  if(isset($_GET['id']) && isset($_GET['action'])){
    if($_GET['action'] == "finish"){
      $sql = "UPDATE ReportSystem_reportsdb SET STATUS = '2' WHERE id = '".$_GET['id']."'";
      if(mysqli_query($conn,$sql)){
        header("Location: ../bans/create/?success=You%20finished%20the%20Case%21");
      } else {
        header("Location: ../reports/view/?case=".$_GET['id']."&error=Your%20Case%20couldn't%20be%20updated%21%20Please%20try%20again%21");
      }
    } else if($_GET['action'] == "cancel"){
      $sql = "UPDATE ReportSystem_reportsdb SET STATUS = '-1' WHERE id = '".$_GET['id']."'";
      if(mysqli_query($conn,$sql)){
        header("Location: ../reports/?success=You%20denied%20the%20Case%21");
      } else {
        header("Location: ../reports/view/?case=".$_GET['id']."&error=Your%20Case%20couldn't%20be%20updated%21%20Please%20try%20again%21");
      }
    }
  } else {
    header("Location: ../reports/?error=Your%20Case%20couldn't%20be%20updated%21%20Please%20try%20again%21");
  }

?>
