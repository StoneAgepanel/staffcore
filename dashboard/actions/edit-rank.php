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
    $name = $_POST['name'];
    $value = $_POST['rankvalue'];
    $oldname = $_POST['oldname'];
    $update = date("h:ia - Y.m.d");

    $sql = "UPDATE staffcoreui_ranks SET RANK_NAME = '".$name."', RANK_VALUE = '".$value."' WHERE id = '".$id."'";
    if(mysqli_query($conn,$sql)){
      $sql2 = "SELECT * FROM staffcoreui_accounts WHERE USER_RANK = '".$oldname."'";
      $result = mysqli_query($conn,$sql2);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          $sql3 = "UPDATE staffcoreui_accounts SET USER_RANK = '".$name."' WHERE id = '".$row['id']."'";
          mysqli_query($conn,$sql3);
        }
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','updated a Rank with the ID #".$id."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../admin/manage/ranks/?success=Rank%20was%20updated!");
        } else {
          header("Location: ../admin/manage/ranks/?success=Rank%20was%20updated!");
        }
      } else {
        $sql4 = "INSERT INTO staffcoreui_staff_activities(USER_ID,ACTIVITY_TEXT,PERFORMED) VALUES ('".$_SESSION['user_id']."','updated a Rank with the ID #".$id."','".$update."')";
        if(mysqli_query($conn,$sql4)){
          header("Location: ../admin/manage/ranks/?success=Rank%20was%20updated!");
        } else {
          header("Location: ../admin/manage/ranks/?success=Rank%20was%20updated!");
        }
      }
    } else {
      header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/ranks");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/ranks");
  }

?>
