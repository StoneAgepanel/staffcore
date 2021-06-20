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

  $sql = "SELECT * FROM staffcoreui_accounts";
  $result = mysqli_query($conn,$sql);

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      if(!hasUUID($row['id'])){
        $sql2 = "DELETE FROM staffcoreui_accounts WHERE id = '".$row['id']."'";
        mysqli_query($conn,$sql2);
      }
    }
    header("Location: ../admin/manage/accounts/?success=All%20accounts%2C%20which%20were%20not%20verified%20to%20this%20moment%2C%20were%20removed");
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/admin/manage/accounts/");
  }
?>
