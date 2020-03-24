<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer\src\PHPMailer.php';
  require 'PHPMailer\src\SMTP.php';
  require 'PHPMailer\src\Exception.php';


  require_once (__DIR__.'/vendor/autoload.php');
  use Dotenv\Dotenv;

  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->load();


  $my_email_addr = getenv('EMAIL2');
  $json_msg = array('sql_insert' => '', 'mail_delivery' => '', 'error' => '');
        

  $mail = new PHPMailer(TRUE);
  /* SMTP parameters. */
  /* SMTP debug level */
  $mail->SMTPDebug = 2;

  /* Tells PHPMailer to use SMTP. */
  $mail->isSMTP();

  /* SMTP timeout value */
  $mail->Timeout = 10;
         
  /* SMTP server address. */
  $mail->Host = 'smtp.gmail.com';

  /* Use SMTP authentication. */
  $mail->SMTPAuth = TRUE;
         
  /* Set the encryption system. */
  $mail->SMTPSecure = 'tls';
         
  /* SMTP authentication username. */
  $mail->Username = $my_email_addr;
         
  /* SMTP authentication password. */
  $mail->Password = getenv('EMAIL2_PASSWORD');
         
  /* Set the SMTP port. */
  $mail->Port = 587;
  
  try {
        if (isset($_POST['action'])) {

          $action = $_POST['action'];
          $conn = new mysqli('localhost', 'root', '', 'biw-landing-page');

          if ($action == 'masterclass') {

            $name = $conn->real_escape_string($_POST['name']);
            $by = $email = $conn->real_escape_string($_POST['email']);
            $addr = $conn->real_escape_string($_POST['address']);
            $phone = $conn->real_escape_string($_POST['phone']);

            if ($name & $email & $addr & $phone) {

              if ($conn->connect_error) {

                die('Connection failed: ' .$conn->connect_error. '<br>');

              } else {

                $sql_insert = 'INSERT INTO masterclass (name, email, address, phone) VALUES ("' .$name. '", "' .$email. '", "' .$addr. '", "' .$phone. '")';

                if ($conn->query($sql_insert)) {
                  
                  //echo "OK";
                  $json_msg['sql_insert'] = TRUE;

                } else {

                  $json_msg['sql_insert'] = FALSE;
                  $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                };
                $conn->close();

                

                $mail->setFrom($my_email_addr, 'biwmodels.com masterclass registration form');
                $mail->addAddress($by, $name);
                $mail->addAddress($my_email_addr, 'Farintin Obialor');
                $mail->Subject = 'Masterclass Submission';
                $mail->Body = 'By: '. $by .'
        '.'Name: '. $name .', Address: '. $addr .', phone: '. $phone;

                /* Finally send the mail. */
                if ($mail->send()) {

                  $json_msg['mail_delivery'] = TRUE;

                } else {

                  $json_msg['mail_delivery'] = FALSE;

                };

              };

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } elseif ($action == 'event') {

            $name = $conn->real_escape_string($_POST['name']);
            $by = $email = $conn->real_escape_string($_POST['email']);
            $phone = $conn->real_escape_string($_POST['phone']);
            $msg = $conn->real_escape_string($_POST['message']);

            if ($name & $by & $phone & $msg) {

              //$conn = new mysqli('localhost', 'root', '', 'biw-landing-page');
              if ($conn->connect_error) {

                die('Connection failed: '. $conn->connect_error .'<br>');

              } else {

                $sql_insert = 'INSERT INTO event (name, email, phone, message) VALUES ("' .$name. '", "' .$email. '", "' .$phone. '", "' .$msg. '")';

                if ($conn->query($sql_insert)) {
                  
                  //echo "OK";
                  $json_msg['sql_insert'] = TRUE;

                } else {

                  //echo "Error: " .$sql_insert. '<br>' .$conn->error. '<br>';
                  $json_msg['sql_insert'] = FALSE;
                  $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                };
                $conn->close();



                $mail->setFrom($my_email_addr, 'biwmodels.com event question form');
                $mail->addAddress($by, $name);
                $mail->addAddress($my_email_addr, 'Farintin Obialor');
                $mail->Subject = 'Events Submission';
                $mail->Body = 'By: '. $by .'
        '.'Name: '. $name .', phone: '. $phone .'

            '
            . $msg;


                /* Finally send the mail. */
                if ($mail->send()) {

                  $json_msg['mail_delivery'] = TRUE;

                } else {

                  $json_msg['mail_delivery'] = FALSE;

                };

              };

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } elseif ($action == 'newsletter') {

            $by = $email = $conn->real_escape_string($_POST['email']);

            if ($email) {

              //$conn = new mysqli('localhost', 'root', '', 'biw-landing-page');
              if ($conn->connect_error) {

                die('Connection failed: ' .$conn->connect_error. '<br>');

              } else {

                $sql_insert = 'INSERT INTO newsletter (email) VALUES ("' .$email. '")';

                if ($conn->query($sql_insert) === TRUE) {
                  
                  //echo "OK";
                  $json_msg['sql_insert'] = TRUE;

                } else {

                  //echo "Error: " .$sql_insert. '<br>' .$conn->error. '<br>';
                  $json_msg['sql_insert'] = FALSE;
                  $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                };
                $conn->close();


                $mail->setFrom($my_email_addr, 'biwmodels.com newsletter form sign up');
                $mail->addAddress($by, 'Subscriber');
                $mail->addAddress($my_email_addr, 'Farintin Obialor');
                $mail->Subject = 'Newsletter SignUp';
                $mail->Body = 'By: '. $by;

                /* Finally send the mail. */
                //$mail->send()
                if ($mail->send()) {

                  $json_msg['mail_delivery'] = TRUE;

                } else {

                  $json_msg['mail_delivery'] = FALSE;

                };

              };

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } else {

            $json_msg['error'] = 'Unknown form request';

          };

          echo json_encode($json_msg);
      
        };

  } catch (Exception $e) {

     $err_array = $mail->getSMTPInstance()->getError();
     //echo '<br>1<br>'.$err_array['smtp_code'];

  } catch (\Exception $e) {

     //echo $e->getCode().'<br>'.$e->getMessage().'<br>2<br>';

  }

?>