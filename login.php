<?php
    session_start();
    include "dbcon.php";
    // include_once "loading.php";
    if (isset($_POST['email']) && isset($_POST['user_password']))
    {
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email =$_POST['email'];
        $password = $_POST['user_password'];

        $sql = "SELECT * FROM users WHERE email='$email' and `password`=password('$password');";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1)
        {
            $row = mysqli_fetch_assoc($result);
            // $password = md5($password);
                // if($row['privilege'] === $privilege)
                // {
            $_SESSION['email'] = $row['email'];
            $_SESSION['bulkid'] = "";
            if($row['role']==="cashier")
            {
                header("Location: cashier/index.php");
            }
        } 
        else{
            echo "<script>
            alert('NO Account Registered under said credentials.');
            window.location.href='index.php';
            </script>";
        }
    }
?>