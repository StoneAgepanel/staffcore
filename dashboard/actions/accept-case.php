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

  if(isset($_GET['case'])){
    $team = getPlayerUUID($_SESSION['user_id']);
    $sql = "UPDATE ReportSystem_reportsdb SET STATUS = '1',TEAM_UUID = '".$team."' WHERE id = '".$_GET['case']."'";
    if(mysqli_query($conn,$sql)){
      if(isset($_GET['target'])){
        $target = $_GET['target'];
        $targetname = getPlayername($target);
        $executor = getUsername(getPlayerUUID($_SESSION['user_id']));

        $update = date("h:ia - Y.m.d");

        $sql = "INSERT INTO staffcoreui_sync(SYNC_TYPE,TARGET_UUID,DESCRIPTION,EXECUTOR_UUID) VALUES ('CLAIM_REPORT','".$target."','NONE','".$executor."')";
        if(mysqli_query($conn,$sql)){
          $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','just claimed the Reports of ".$targetname."','".$update."')";
          if(mysqli_query($conn,$sql4)){
            header("Location: ../reports/view/?case=".$_GET['case']);
          } else {
            header("Location: ../reports/view/?case=".$_GET['case']);
          }
        } else {
          header("Location: ../error/500/?return_url=".BASE_URL."dashboard/reports");
        }
      } else {
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/reports");
      }
    } else {
      header("Location: ../reports/?error=Your%20Case%20couldn't%20be%20opened%21%20Please%20try%20again%21");
    }
  } else {
    header("Location: ../reports/?error=Your%20Case%20couldn't%20be%20opened%21%20Please%20try%20again%21");
  }

?>
