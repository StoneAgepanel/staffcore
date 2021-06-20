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

    $activate_email_notify = $_POST['activate_email_notify'];
    $email_from = $_POST['email_from'];
    $email_reply_address = $_POST['email_reply_address'];
    $email_reply_name = $_POST['email_reply_name'];

    if(existsSetting("ACTIVATE_EMAIL_NOTIFY")){
      $sql = "UPDATE staffcoreui_settings SET VALUE = '".$activate_email_notify."' WHERE TYPE = 'ACTIVATE_EMAIL_NOTIFY'";
      mysqli_query($conn,$sql);
    } else {
      $sql = "INSERT INTO staffcoreui_settings(TYPE,VALUE) VALUES ('ACTIVATE_EMAIL_NOTIFY','".$activate_email_notify."')";
      mysqli_query($conn,$sql);
    }

    if(existsSetting("EMAIL_FROM")){
      $sql = "UPDATE staffcoreui_settings SET VALUE = '".$email_from."' WHERE TYPE = 'EMAIL_FROM'";
      mysqli_query($conn,$sql);
    } else {
      $sql = "INSERT INTO staffcoreui_settings(TYPE,VALUE) VALUES ('EMAIL_FROM','".$email_from."')";
      mysqli_query($conn,$sql);
    }

    if(existsSetting("EMAIL_REPLY_ADDRESS")){
      $sql = "UPDATE staffcoreui_settings SET VALUE = '".$email_reply_address."' WHERE TYPE = 'EMAIL_REPLY_ADDRESS'";
      mysqli_query($conn,$sql);
    } else {
      $sql = "INSERT INTO staffcoreui_settings(TYPE,VALUE) VALUES ('EMAIL_REPLY_ADDRESS','".$email_reply_address."')";
      mysqli_query($conn,$sql);
    }

    if(existsSetting("EMAIL_REPLIER")){
      $sql = "UPDATE staffcoreui_settings SET VALUE = '".$email_reply_name."' WHERE TYPE = 'EMAIL_REPLIER'";
      mysqli_query($conn,$sql);
    } else {
      $sql = "INSERT INTO staffcoreui_settings(TYPE,VALUE) VALUES ('EMAIL_REPLIER','".$email_reply_name."')";
      mysqli_query($conn,$sql);
    }

    header("Location: ../admin/settings/general/?success=Changes%20were%20saved");

  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/settings/general");
  }
?>
