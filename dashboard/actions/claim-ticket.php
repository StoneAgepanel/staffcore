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

    $team = getPlayerUUID($_SESSION['user_id']);

    $sql = "UPDATE ReportSystem_ticketdb SET TEAM_UUID = '".$team."' WHERE id = '".$_GET['id']."'";
    if(mysqli_query($conn,$sql)){
      header("Location: ../tickets/view/?id=".$_GET['id']."&success=You%20claimed%20this%20ticket%21");
    } else {
      header("Location: ../tickets/all/?error=Server%20failed%20to%20process%20your%20request%21");
      exit();
    }

  } else {
    header("Location: ../tickets/all/?error=No%20ID%20was%20found%21");
    exit();
  }

?>
