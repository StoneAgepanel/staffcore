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
    $permission = $_POST['permission'];
    $rank = $_POST['rank'];
    $update = date("h:ia - Y.m.d");

    $sql = "INSERT INTO staffcoreui_ranks_permissions(PERMISSION,MIN_RANK_VALUE) VALUES ('".$permission."','".$rank."')";
    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','created a new Permission with the Type ".$permission."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        header("Location: ../admin/manage/ranks/?success=Permission%20was%20successfully%20created%21");
      } else {
        header("Location: ../admin/manage/ranks/?success=Permission%20was%20successfully%20created%21");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/ranks");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/ranks");
  }

?>
