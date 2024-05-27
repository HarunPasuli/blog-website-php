<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
    session_start();
    ini_set('display_errors', 0);
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../mail/Send email/PHPMailer/src/Exception.php';
    require '../mail/Send email/PHPMailer/src/PHPMailer.php';
    require '../mail/Send email/PHPMailer/src/SMTP.php';
    require 'C:/xampp/phpMyAdmin/vendor/autoload.php';
    function secure($x) {
        $x = htmlspecialchars($x); 
        $x = trim($x);  
        $x = stripslashes($x);  
        return $x;
    }

    // Initialization of variables
    $name = "";
    $email = "";
    $password = "";
    $errors = array();

    include('connect.php');

    if(isset($_SESSION['Email'])) {
        session_destroy();
        echo "<script>
        Swal.fire({
          title: 'Error!',
          text: 'You must be logged out before registering!',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then((result) => {
          window.open('register.php','_self');
        });
        </script>";
        exit();
    }

    if(isset($_POST['login'])) {
        $name = secure(mysqli_real_escape_string($connect,$_POST['Username']));
        $email = secure(mysqli_real_escape_string($connect,$_POST['Email']));
        $password = secure(mysqli_real_escape_string($connect,$_POST['Password']));

        $stmt = $connect->prepare("SELECT * FROM `userregistration` WHERE Email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = mysqli_fetch_assoc($result);

        if (empty($name) || empty($email) || empty($password)) 
        {
            array_push($errors, "All fields are required!");
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'One of the fields is empty!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
              return false;
            });
            </script>";
            exit();
        }

        if ($user) {
            if (strtolower($user['Email']) === strtolower($email)) {
                array_push($errors, "Email is already taken!");
                echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Email is already taken!',
                  icon: 'error',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  window.open('register.php','_self');
                });
                </script>";
                exit();
            }
        }

        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format!");
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'Invalid email format!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
                window.open('register.php','_self');
            });
            </script>";
            exit();
        }

        $mail = new PHPMailer;

        $mail->SMTPDebug = false;
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'mitlapiz@gmail.com';
        $mail->Password = 'sfajfxfddgdtmoim';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mitlapiz@gmail.com','gmail');
        $mail->addAddress($email);
        $mail->addReplyTo('mitlapiz@gmail.com');

        $otp = substr(number_format(time() * rand(),0,'',''), 0, 6);

        $mail->isHTML(true);
        $mail->Subject = "Email verification";

        $mail->Body = 
        "<p>Your Verification Code is: <b style = 'font-size: 30px;'> $otp </b></p>:";
// $mail->Body = $email p;
        // if(count($errors) == 0) {
        // $mail->send();
        // }
        if (!$mail -> send()) {
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'Email could not be sent!',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then((result) => {
                window.open('register.php','_self');
            });
            </script>";
            exit();
            // echo 'Error: ' . $mail->ErrorInfo;
        }   

        if (count($errors) == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            // Kujdes te vecant ne insertimin e te dhenave
            $stmt = $connect->prepare("INSERT INTO userregistration (Username, Email, Password, verification_code,email_verified_at) VALUES (?, ?, ?, ?, NULL)");
            $stmt->bind_param("sssi", $name, $email, $password,$otp);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // header("Location: email-verification.php?email=" . $email);
                echo "<script>
                Swal.fire({
                  title: 'Registration Successful!',
                  text: 'Successfully registered! Please check your email address to confirm your account!',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then((result) => {
                    if(result.isConfirmed) {
                    window.open('email-verification.php','_self');
                }
                });
                </script>";
                $_SESSION['Email'] = $email;
            }
            else {
                echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Registration failed!',
                  icon: 'error',
                  confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('register.php','_self');
                });
                </script>";
                exit();
            }

            $stmt = $connect->prepare("SELECT * FROM userregistration WHERE Email = ? AND Password = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_num_rows($result) > 0)
            {
                echo "<script>
                Swal.fire({
                  title: 'Registration Successful!',
                  text: 'Successfully registered! Please check your email address to confirm your account!',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then((result) => {
                    if(result.isConfirmed) {
                    window.open('email-verification.php','_self');
                }
                });
                </script>";
                $_SESSION['Username'] = $name;
                $email_verified_at = $_SESSION['email_verified_at'];
                exit();
            }
        }
    }
?>