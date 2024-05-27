<?php 
    session_start();
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/favicon2.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/email-verfication.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <form method="post">
            <div class="input-container">
                <label for="password">New Password:</label>
                <div>
                    <input type="password" id="password" name="Password" required>
                </div>
            </div>
            <div class="input-container">
                <label for="confirm_password">Confirm New Password:</label>
                <div>
                    <input type="password" id="confirm_password" name="ConfirmPassword" required>
                </div>
            </div>
            <button type="submit" name="resetPassword" value="resetPassword">Reset Password</button>
        </form>
    </div>

    <?php 
        if(isset($_POST['resetPassword'])) {
            // Retrieve token and new password
            $token = $_GET['token'];
            $password = $_POST['Password'];
            $confirmPassword = $_POST['ConfirmPassword'];

            // Validation
            if ($password != $confirmPassword) {
                echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Passwords do not match! Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('resetPassword.php?token=$token','_self');
                });
                </script>";
                exit();
            }
            
            if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password)) {
                echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Password must be at least 8 characters long and contain at least one number and one letter!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('resetPassword.php?token=$token','_self');
                });
                </script>";
                exit();
            }

            if (!$user) {
                echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Invalid token! Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.open('forgotPassword.php','_self');
                });
                </script>";
            }

            echo "<script>
            Swal.fire({
                title: 'Password Changed!',
                text: '',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.open('login.php','_self');
            });
            </script>";

            $password = password_hash($password, PASSWORD_DEFAULT);
            // Update user's password
            include('connect.php');
            // Update user's password
            $stmt = $connect->prepare("UPDATE `userregistration` SET password = ? WHERE token = ?");
            $stmt->bind_param("ss", $password, $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = mysqli_fetch_assoc($result);
    }
?>
</body> 
</html>

