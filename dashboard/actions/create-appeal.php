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
    $team = $_POST['team'];
    $type = $_POST['type'];
    $reason = $_POST['reason'];
    $msg = $_POST['message'];
    $update = date("h:ia - Y.m.d");

    $sql = "INSERT INTO staffcoreui_appeals(BAN_ID,UUID,TEAM_UUID,TYPE,REASON,STATUS,Message,last_update) VALUES ('".$id."','".$uuid."','".$team."','".$type."','".$reason."','0','".$msg."','".$update."')";
    if(mysqli_query($conn,$sql)){
      header("Location: ../appeals/current/?success=Appeal%20was%20successfully%20sent%20!");
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/appeals/create");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/appeals/create");
  }

?>
