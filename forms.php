<?php
  //header('Content-type: application/json');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require __DIR__.'\PHPMailer\src\PHPMailer.php';
  require __DIR__.'\PHPMailer\src\SMTP.php';
  require __DIR__.'\PHPMailer\src\Exception.php';


  require_once (__DIR__.'/vendor/autoload.php');
  use Dotenv\Dotenv;

  $dotenv = Dotenv::createImmutable(__DIR__);
  $dotenv->load();


  $my_email_addr = getenv('EMAIL');
  $json_msg = array();

        

  $mail = new PHPMailer(TRUE);
  /* SMTP parameters. */
  /* SMTP debug level */
  $mail->SMTPDebug = 2;

  /* Tells PHPMailer to use SMTP. */
  $mail->isSMTP();
         
  /* SMTP server address. */
  $mail->Host = 'smtp.gmail.com';

  /* Use SMTP authentication. */
  $mail->SMTPAuth = TRUE;
         
  /* Set the encryption system. */
  $mail->SMTPSecure = 'tls';
         
  /* SMTP authentication username. */
  $mail->Username = $my_email_addr;
         
  /* SMTP authentication password. */
  $mail->Password = getenv('EMAIL_PASSWORD');
         
  /* Set the SMTP port. */
  $mail->Port = 587;
  


  try {
        if (isset($_POST['action'])) {

          if (getenv('DB_TECHNOLOGY') == 'mysql') {

            if (getenv('ENVIRONMENT') == 'development') {
                      
              $conn = new mysqli('localhost', 'root', '', 'biw-landing-page');

            } elseif (getenv('ENVIRONMENT') == 'production') {
              
              $conn = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DB_NAME'));

            };

          } elseif (getenv('DB_TECHNOLOGY') == 'postgresql') {
                    
            if (getenv('ENVIRONMENT') == 'development') {
              
              //echo $password;
              $conn = pg_connect('host=localhost dbname=biw-landing-page user=postgres password=' .getenv('PGSQL_PASSWORD')) or die("Could not connect");
              echo "Connected successfully";

            } elseif (getenv('ENVIRONMENT') == 'production') {
              
              $conn = pg_connect(getenv("DATABASE_URL")) or die("Could not connect");

            };
            $conn_stat = pg_connection_status($conn);

          };



          $action = $_POST['action'];
          if ($action == 'masterclass') {

            if ($_POST['name'] & $_POST['email'] & $_POST['address'] & $_POST['phone']) {

              if (getenv('DB_TECHNOLOGY') == 'mysql') {

                $name = $conn->real_escape_string($_POST['name']);
                $by = $email = $conn->real_escape_string($_POST['email']);
                $addr = $conn->real_escape_string($_POST['address']);
                $phone = $conn->real_escape_string($_POST['phone']);

                if ($conn->connect_error) {

                  die('Connection failed: ' .$conn->connect_error. '<br>');

                } else {

                  $sql_insert = 'INSERT INTO masterclass (name, email, address, phone) VALUES ("' .$name. '", "' .$email. '", "' .$addr. '", "' .$phone. '")';

                  if ($conn->query($sql_insert) === TRUE) {
                    
                    $json_msg['sql_insert'] = TRUE;

                  } else {

                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                  };
                  $conn->close();

                };

              } elseif (getenv('DB_TECHNOLOGY') == 'postgresql') {
                
                $name = pg_escape_string($_POST['name']);
                $by = $email = pg_escape_string($_POST['email']);
                $addr = pg_escape_string($_POST['address']);
                $phone = pg_escape_string($_POST['phone']);

                if ($conn_stat === PGSQL_CONNECTION_OK) {

                  echo ' PGSQL_CONNECTION_OK ';
                  $sql_insert = 'INSERT INTO masterclass (name, email, address, phone) VALUES (\'' .$name. '\', \'' .$email. '\', \'' .$addr. '\', \'' .$phone. '\')';
                  $result = pg_query($sql_insert);
                  if (!$result) {
                      
                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .' <br>Connection status ok<br> ';
                    echo " An error occurred.\n ";
                    exit;

                  } else {

                    $json_msg['sql_insert'] = TRUE;

                  };
                  pg_close($conn);

                } else {

                  die('Connection status bad');

                };

              };
              
              $mail->setFrom($my_email_addr, 'biwmodels.com masterclass registration form');
              $mail->addAddress($by, $name);
              $mail->addAddress($my_email_addr, 'Farintin Obialor');
              $mail->Subject = 'Masterclass Submission';
              $mail->Body = 'By Email: '. $by .'
'.'Name: '. $name .'
Address: '. $addr .'.
Phone No.: '. $phone;

              /* Finally send the mail. */
              if ($mail->send()) {

                $json_msg['mail_delivery'] = TRUE;

              } else {

                $json_msg['mail_delivery'] = FALSE;

              };

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } elseif ($action == 'event') {

            if ($_POST['name'] & $_POST['email'] & $_POST['phone'] & $_POST['message']) {

              if (getenv('DB_TECHNOLOGY') == 'mysql') {

                $name = $conn->real_escape_string($_POST['name']);
                $by = $email = $conn->real_escape_string($_POST['email']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $msg = $conn->real_escape_string($_POST['message']);

                if ($conn->connect_error) {

                  die('Connection failed: ' .$conn->connect_error. '<br>');

                } else {

                  $sql_insert = 'INSERT INTO event (name, email, phone, message) VALUES ("' .$name. '", "' .$email. '", "' .$phone. '", "' .$msg. '")';

                  if ($conn->query($sql_insert) === TRUE) {
                    
                    $json_msg['sql_insert'] = TRUE;

                  } else {

                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                  };
                  $conn->close();

                };

              } elseif (getenv('DB_TECHNOLOGY') == 'postgresql') {
                
                $name = pg_escape_string($_POST['name']);
                $by = $email = pg_escape_string($_POST['email']);
                $phone = pg_escape_string($_POST['phone']);
                $msg = pg_escape_string($_POST['message']);

                if ($conn_stat === PGSQL_CONNECTION_OK) {

                  echo ' PGSQL_CONNECTION_OK ';
                  $sql_insert = 'INSERT INTO event (name, email, phone, message) VALUES (\'' .$name. '\', \'' .$email. '\', \'' .$phone. '\', \'' .$msg. '\')';
                  $result = pg_query($sql_insert);
                  if (!$result) {
                      
                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .' <br>Connection status ok<br> ';
                    echo " An error occurred.\n ";
                    exit;

                  } else {

                    $json_msg['sql_insert'] = TRUE;

                  };
                  pg_close($conn);

                } else {

                  die('Connection status bad');

                };

              };
              
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

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } elseif ($action == 'newsletter') {

            if ($_POST['email']) {

              if (getenv('DB_TECHNOLOGY') == 'mysql') {

                $by = $email = $conn->real_escape_string($_POST['email']);

                if ($conn->connect_error) {

                  die('Connection failed: ' .$conn->connect_error. '<br>');

                } else {

                  $sql_insert = 'INSERT INTO newsletter (email) VALUES ("' .$email. '")';

                  if ($conn->query($sql_insert) === TRUE) {
                    
                    $json_msg['sql_insert'] = TRUE;

                  } else {

                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .'<br>'. $conn->error .'<br>';

                  };
                  $conn->close();

                };

              } elseif (getenv('DB_TECHNOLOGY') == 'postgresql') {
                
                $by = $email = pg_escape_string($_POST['email']);

                if ($conn_stat === PGSQL_CONNECTION_OK) {

                  echo ' PGSQL_CONNECTION_OK ';
                  $sql_insert = 'INSERT INTO newsletter (email) VALUES (\'' .$email. '\')';
                  $result = pg_query($sql_insert);
                  if (!$result) {
                      
                    $json_msg['sql_insert'] = FALSE;
                    $json_msg['error'] = $sql_insert .' <br>Connection status ok<br> ';
                    echo " An error occurred.\n ";
                    exit;

                  } else {

                    $json_msg['sql_insert'] = TRUE;

                  };
                  pg_close($conn);

                } else {

                  die('Connection status bad');

                };

              };
              
              $mail->setFrom($my_email_addr, 'biwmodels.com newsletter form sign up');
              $mail->addAddress($by, 'Subscriber');
              $mail->addAddress($my_email_addr, 'Farintin Obialor');
              $mail->Subject = 'Newsletter SignUp';
              $mail->Body = 'By: '. $by;

              /* Finally send the mail. */
              if ($mail->send()) {

                $json_msg['mail_delivery'] = TRUE;

              } else {

                $json_msg['mail_delivery'] = FALSE;

              };

            } else {

              $json_msg['error'] = 'Fill in completely the forms';

            };

          } else {

              $json_msg['error'] = 'Unknown form request';

          };

        };

  } catch (Exception $e) {

     //$err_array = $mail->getSMTPInstance()->getError();
     //echo '<br>1<br>'.$err_array['smtp_code'];
     $json_msg['error'] = $e->errorMessage();

  } catch (\Exception $e) {

     //echo $e->getCode().'<br>'.$e->getMessage().'<br>2<br>';
     $json_msg['error'] = $e->getMessage();

  };

  $fp = fopen('msg.json', 'w') or die("Unable to open file!");
  fwrite($fp, json_encode($json_msg));
  fclose($fp);

?>