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
    $userid = $_POST['id'];
    $rank = $_POST['rank'];
    $update = date("h:ia - Y.m.d");

    $username = getUsernameByID($userid);

    $sql = "UPDATE staffcoreui_accounts SET USER_RANK = '".$rank."' WHERE id = '".$userid."'";
    if(mysqli_query($conn,$sql)){
      $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','assigned a the Rank ".$rank." to ".$username."','".$update."')";
      if(mysqli_query($conn,$sql4)){
        header("Location: ../admin/manage/accounts/?success=The%20rank%20was%20successfully%20assigned%21");
      } else {
        header("Location: ../admin/manage/accounts/?success=The%20rank%20was%20successfully%20assigned%21");
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/accounts");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/accounts");
  }

?>
