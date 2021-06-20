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
    $uuid = $_POST['uuid'];
    $userid = getUserIDByUUID($uuid);
    $reason = $_POST['reason'];
    $end = "";

    $d = DateTime::createFromFormat('h:ia - Y.m.d', $_POST['time']);
    if ($d === false) {
        die("Incorrect date string");
    } else {
        $end = $d->getTimestamp() * 1000;
    }
    $update = date("h:ia - Y.m.d");

    $sql = "UPDATE ReportSystem_bansdb SET REASON = '".$reason."', BAN_END = '".$end."' WHERE id = '".$id."'";
    $sql2 = "UPDATE ReportSystem_banhistory SET REASON = '".$reason."', BAN_END = '".$end."' WHERE id = '".$id."'";
    if(mysqli_query($conn,$sql) && mysqli_query($conn,$sql2)){
      $url = BASE_URL."dashboard/banhistory";
      $sql3 = "INSERT INTO staffcoreui_notifications(USER_ID,NOTIFY_TEXT,NOTIFY_LINK,SEEN) VALUES ('".$userid."','Your Ban was updated','".$url."','0')";
      if(mysqli_query($conn,$sql3)){
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','updated a Ban with the ID #".$id."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../bans/active/?success=Ban%20was%20updated!");
        } else {
          header("Location: ../bans/active/?success=Ban%20was%20updated!");
        }
      } else {
        header("Location: ../bans/active/?success=Ban%20was%20updated!");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/bans/active");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/bans/active");
  }

?>
