<?php
  session_start();

  require_once("../../staffcore/configs/config.php");
  require_once("../../staffcore/mysql.php");

  if(isset($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>">
    <?php
  }

  require_once("../../staffcore/functions.php");

  if(isset($_POST['submit'])){
    if(existsEmail($_POST['email'])){
      if(password_verify($_POST['password'],getPasswordhash($_POST['email']))){
        $_SESSION['user_id'] = getUserID($_POST['email']);
        $_SESSION['email'] = $_POST['email'];

        if(isset($_POST['stay_logged'])){
          $cookie_name = "email_staffcore";
          $cookie_value = $_POST['email'];
          setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        }

        $lastlogin = date("h:ia - Y.m.d");

        $sql = "UPDATE staffcoreui_accounts SET LAST_LOGIN = '".$lastlogin."' WHERE id = '".$_SESSION['user_id']."'";
        if(mysqli_query($conn,$sql)){
          ?>
          <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>?success=Welcome%20to%20the%20Dashboard%21">
          <?php
        } else {
          header("Location: ../error/500/?return_url=".BASE_URL."dashboard/login/");
        }
      } else {
        header("Location: ../login/?error=Wrong%20password");
      }
    } else {
      header("Location: ../login/?error=Account%20does%20not%20exist");
    }
  } else {
    header("Location: ../error/500/?return_url=".BASE_URL."dashboard/login/");
  }

?>
