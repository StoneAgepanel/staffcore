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

    $sql = "DELETE FROM ReportSystem_ticketdb WHERE id = '".$id."'";
    if(mysqli_query($conn,$sql)){
      header("Location: ../tickets/?success=The%20Ticket%20was%20deleted");
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/tickets");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/tickets");
  }
?>
