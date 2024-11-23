<?php

include '../config/db.php';
    if(isset($_POST['register'])){

        $username = $_POST['username'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        $status = "unverified";

        $otp = rand(100000, 999999);

        $sql = "SELECT * FROM `user` WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num > 0){
            "echo alert('This email already exist!'); ";
            header("location: ../frontend/register.php?error=email_exists");
            exit();
        }else{
            if($password == $confirmpassword){

                include '../includes/sendotp.php';
                sendOTP($email, $otp);

                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `user` (`username`,`password`, `email`, `contact_number`,`otp`, `status`) VALUES ('$username', '$hash', '$email', '$contact', $otp, '$status')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    header("location: ../frontend/verifyaccount.php?email=$email&Register=Success");
                    
                }else{
                    header("location: ../frontend/register.php?Register=Failed");
                }
        }else{
            header("Location: ../frontend/register.php?error=password_mismatch");
            exit();
        }

    }

}

// if(isset($_POST['register'])){

//     $user_exist_query = "SELECT * FROM `user` WHERE email = '$_POST[email]' OR username = '$_POST[username]'";
//     $result = mysqli_query($conn, $user_exist_query);

//     if($result){
//         if(mysqli_num_rows($result) > 0){
//             $result_fetch = mysqli_fetch_assoc($result);
//             if($result_fetch['email'] == $_POST['email']){
//                 echo "<script>
//                     alert('$result_fetch[email] email already taken!');
//                     window.location.href = '../frontend/register.php?error=email_exists';
//                 </script>";
//             }else{
//                 echo "<script>
//                 alert('$result_fetch[username] username already taken!');
//                 window.location.href = '../frontend/register.php?error=username_exists';
//             </script>";
//             }
//         }else{
//             $query = "INSERT INTO `user`(`username`, `password`, `email`, `contact_number`, `status`) VALUES ('$_POST[username]', '$_POST[password]', '$_POST[email]', '$_POST[contact]', 'unverified')";
//             if(mysqli_query($conn, $query)){
//                 echo "<script>
//                     alert('Registered successfully');
//                     window.location.href = '../frontend/login.php';
//                 </script>";
//             }
//             else{
//                 echo "<script>
//                     alert('Cannot run query');
//                     window.location.href = '../frontend/register.php';
//                 </script>";
//             }
//         }
//     }else{
//         echo "<script>
//             alert('Cannot run query');
//             window.location.href = '../frontend/register.php';
//         </script>";
//     }
// }

?>
