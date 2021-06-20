<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  function getMailer($value)
  {
    require_once("configs/config.php");

    $update = date("h:ia - Y.m.d");

    if($value == "TEMPLATE"){
      return "<div style='width: 75%;margin: auto;border-radius: 25px;background-color: #ecf0f1;'>
            <img style='position: relative; top: 5px; left: 45%;' height='75' width='75' src='https://downloads.lacodev.de/logo.png' alt='StaffCore Logo'>
            <p style='color: #bdc3c7;text-align: center;'>This is an Email Template for StaffCore-UI by LacoDev - ".$update."</p>
            <div style='width: 75%;margin: auto;'>
              <h1 style='color: #bdc3c7;text-align: center;'>Thanks for using StaffCore-UI!</h1>
              <p style='color: #7f8c8d;'>
                This is the Mail Content Text which can be change in whatever you want!<br>
                StaffCore-UI offers you additional features which make your expierence with our StaffManager Plugin even greater!<br><br>
                This is just an template for what the Emails your users can receive will look like!<br>
                You are allowed to completly redesign this mail-template and even submit your own designs to us and we publish it for everyone!<br><br>
                StaffCore is one of the most popular Staff-Management Plugins out there on spigotmc.org!<br>
                We offer tons of features which make your whole Staff expierence unique and super easy to handle!<br>
                Do you use Matrix or Spartan as your Anticheat? We got you covered with an awesome integrated module to automatically report users which were detected as cheaters!
              </p>
            </div>
            <div style='width: 75%;margin-top: 15px;padding-bottom: 10px;margin-left: auto;margin-right: auto;'>
              <p style='color: #bdc3c7;text-align: center;'>This Email was sent by StaffCore-UI operated by ".SERVERNAME."</p>
              <p style='color: #bdc3c7;text-align: center;'>StaffCore and StaffCore-UI made by <a href='https://www.lacodev.de' style='color: #e74c3c;'>LacoDev</a></p>
            </div>
          </div>";
    } else if($value == "BANNED"){
      return "<div style='width: 75%;margin: auto;border-radius: 25px;background-color: #ecf0f1;'>
            <img style='position: relative; top: 5px; left: 45%;' height='75' width='75' src='https://downloads.lacodev.de/logo.png' alt='StaffCore Logo'>
            <p style='color: #bdc3c7;text-align: center;'>This is an automatically generated email - ".$update."</p>
            <div style='width: 75%;margin: auto;'>
              <h1 style='color: #bdc3c7;text-align: center;'>You were banned from ".SERVERNAME."</h1>
              <p style='color: #7f8c8d;'>
                Our Staffteam decided to exclude you from our server, because your
                account was in violation of our Serverrules or the rules of Mojang!
              </p>
            </div>
            <div style='width: 75%;margin-top: 15px;padding-bottom: 10px;margin-left: auto;margin-right: auto;'>
              <p style='color: #bdc3c7;text-align: center;'>This Email was sent by StaffCore-UI operated by ".SERVERNAME."</p>
              <p style='color: #bdc3c7;text-align: center;'>StaffCore and StaffCore-UI made by <a href='https://www.lacodev.de' style='color: #e74c3c;'>LacoDev</a></p>
            </div>
          </div>";
    } else if($value == "MUTED"){
      return "<div style='width: 75%;margin: auto;border-radius: 25px;background-color: #ecf0f1;'>
            <img style='position: relative; top: 5px; left: 45%;' height='75' width='75' src='https://downloads.lacodev.de/logo.png' alt='StaffCore Logo'>
            <p style='color: #bdc3c7;text-align: center;'>This is an automatically generated email - ".$update."</p>
            <div style='width: 75%;margin: auto;'>
              <h1 style='color: #bdc3c7;text-align: center;'>You were muted from the chat on ".SERVERNAME."</h1>
              <p style='color: #7f8c8d;'>
                Our Staffteam decided to exclude you from our chat, because your
                account was in violation of our Serverrules or the rules of Mojang!
              </p>
            </div>
            <div style='width: 75%;margin-top: 15px;padding-bottom: 10px;margin-left: auto;margin-right: auto;'>
              <p style='color: #bdc3c7;text-align: center;'>This Email was sent by StaffCore-UI operated by ".SERVERNAME."</p>
              <p style='color: #bdc3c7;text-align: center;'>StaffCore and StaffCore-UI made by <a href='https://www.lacodev.de' style='color: #e74c3c;'>LacoDev</a></p>
            </div>
          </div>";
    }
  }

  function sendMail($to,$value)
  {
    require_once("functions.php");
    require_once("configs/config.php");

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if($value == "BAN_PLAYER"){
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = getSetting("SMTP_HOST");                // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = getSetting("SMTP_USERNAME");            // SMTP username
          $mail->Password   = getSetting("SMTP_PASSWORD");            // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = getSetting("SMTP_PORT");                // TCP port 587 to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

          $fromaddress = getSetting("EMAIL_FROM");
          $sender = getUsernameByID($_SESSION['user_id']);

          $replyaddress = getSetting("EMAIL_REPLY_ADDRESS");
          $replier = getSetting("EMAIL_REPLIER");

          //Recipients
          $mail->setFrom($fromaddress, $sender);
          $mail->addAddress($to);     // Add a recipient name is optional ,'Lukas Sommerfeld'
          $mail->addReplyTo($replyaddress, $replier);

          // Attachments
          // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'You got banned! - StaffCoreUI';
          $mail->Body    = getMailer("BANNED");
          $mail->AltBody = 'Your Mailclient is not compatible with this email!';

          $mail->send();
      } catch (Exception $e) {
        header("Location: ../admin/settings/email/?msg=Message%20could%20not%20be%20sent.%20Mailer%20Error%20{$mail->ErrorInfo}");
      }
    } else if($value == "MUTE_PLAYER"){
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = getSetting("SMTP_HOST");                // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = getSetting("SMTP_USERNAME");            // SMTP username
          $mail->Password   = getSetting("SMTP_PASSWORD");            // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = getSetting("SMTP_PORT");                // TCP port 587 to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

          $fromaddress = getSetting("EMAIL_FROM");
          $sender = getUsernameByID($_SESSION['user_id']);

          $replyaddress = getSetting("EMAIL_REPLY_ADDRESS");
          $replier = getSetting("EMAIL_REPLIER");

          //Recipients
          $mail->setFrom($fromaddress, $sender);
          $mail->addAddress($to);     // Add a recipient name is optional ,'Lukas Sommerfeld'
          $mail->addReplyTo($replyaddress, $replier);

          // Attachments
          // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'You got muted! - StaffCoreUI';
          $mail->Body    = getMailer("MUTED");
          $mail->AltBody = 'Your Mailclient is not compatible with this email!';

          $mail->send();
      } catch (Exception $e) {
        header("Location: ../admin/settings/email/?msg=Message%20could%20not%20be%20sent.%20Mailer%20Error%20{$mail->ErrorInfo}");
      }
    }
  }

?>
