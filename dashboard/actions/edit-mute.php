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

    $sql = "UPDATE ReportSystem_mutesdb SET REASON = '".$reason."', MUTE_END = '".$end."' WHERE id = '".$id."'";
    if(mysqli_query($conn,$sql)){
      $url = BASE_URL."dashboard/appeals/current";
      $sql3 = "INSERT INTO staffcoreui_notifications(USER_ID,NOTIFY_TEXT,NOTIFY_LINK,SEEN) VALUES ('".$userid."','Your Mute was updated','".$url."','0')";
      if(mysqli_query($conn,$sql3)){
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','updated a Mute with the ID #".$id."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../mutes/active/?success=Mute%20was%20updated!");
        } else {
          header("Location: ../mutes/active/?success=Mute%20was%20updated!");
        }
      } else {
        header("Location: ../mutes/active/?success=Mute%20was%20updated!");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/mutes/active");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/mutes/active");
  }

?>
