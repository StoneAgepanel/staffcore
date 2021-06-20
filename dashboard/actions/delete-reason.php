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

    $sql = "DELETE FROM ReportSystem_reasonsdb WHERE id = '".$_GET['id']."'";

    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','deleted a Reason with the ID #".$id."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        if($_GET['type'] == "report"){
          header("Location: ../admin/manager/report/?success=Reason%20was%20deleted%21");
        } else if($_GET['type'] == "ban"){
          header("Location: ../admin/manager/ban/?success=Reason%20was%20deleted%21");
        } else if($_GET['type'] == "mute"){
          header("Location: ../admin/manager/muted/?success=Reason%20was%20deleted%21");
        }
      } else {
        if($_GET['type'] == "report"){
          header("Location: ../admin/manager/report/?success=Reason%20was%20deleted%21");
        } else if($_GET['type'] == "ban"){
          header("Location: ../admin/manager/ban/?success=Reason%20was%20deleted%21");
        } else if($_GET['type'] == "mute"){
          header("Location: ../admin/manager/muted/?success=Reason%20was%20deleted%21");
        }
      }
    } else {
      if($_GET['type'] == "report"){
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/report");
        exit();
      } else if($_GET['type'] == "ban"){
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/ban");
        exit();
      } else if($_GET['type'] == "mute"){
        header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/mute");
        exit();
      }
    }

  } else {
    if($_GET['type'] == "report"){
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/report");
      exit();
    } else if($_GET['type'] == "ban"){
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/ban");
      exit();
    } else if($_GET['type'] == "mute"){
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manager/mute");
      exit();
    }
  }
?>
