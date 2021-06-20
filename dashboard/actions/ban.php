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
  require_once("../../staffcore/mailer.php");

  $email = getSetting("ACTIVATE_EMAIL_NOTIFY");

  if(isset($_POST['submit'])){
    $uuid = $_POST['uuid'];
    $userid = getUserIDByUUID($uuid);
    $reason = $_POST['reason'];
    $name = getPlayername($uuid);
    $executor = getPlayerUUID($_SESSION['user_id']);

    $update = date("h:ia - Y.m.d");

    $sql = "INSERT INTO staffcoreui_sync(SYNC_TYPE,TARGET_UUID,DESCRIPTION,EXECUTOR_UUID) VALUES ('BAN_PLAYER','".$uuid."','".$reason."','".$executor."')";
    if(mysqli_query($conn,$sql)){
      if($email == 1){
        if(existsEmail(getEmail($userid))){
          sendMail(getEmail($userid),"BAN_PLAYER");
        }
      }
      $url = BASE_URL."dashboard/appeals/create";
      $sql3 = "INSERT INTO staffcoreui_notifications(USER_ID,NOTIFY_TEXT,NOTIFY_LINK,SEEN) VALUES ('".$userid."','You just got banned','".$url."','0')";
      if(mysqli_query($conn,$sql3)){
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','just banned the Player ".$name."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../bans/active/?success=Ban%20was%20successfully%20sent%20to%20the%20server%21%20The%20server%20will%20update%20the%20status%20of%20this%20player%20in%20a%20few%20seconds");
        } else {
          header("Location: ../bans/active/?success=Ban%20was%20successfully%20sent%20to%20the%20server%21%20The%20server%20will%20update%20the%20status%20of%20this%20player%20in%20a%20few%20seconds");
        }
      } else {
        header("Location: ../bans/active/?success=Ban%20was%20successfully%20sent%20to%20the%20server%21%20The%20server%20will%20update%20the%20status%20of%20this%20player%20in%20a%20few%20seconds");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/bans/active");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/bans/active");
  }

?>
