<?php
session_start();
include "dbcon.php";

if (isset($_POST['email']) && isset($_POST['user_password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['user_password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['bulkid'] = "";
                if ($row['role'] === "cashier") {
                    header("Location: cashier/index.php");
                    exit();
                }
            } else {
                echo "<script>
                alert('Incorrect password.');
                window.location.href='index.php';
                </script>";
            }
        } else {
            echo "<script>
            alert('No account registered under this email.');
            window.location.href='index.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
        alert('Failed to prepare statement!');
        window.location.href='index.php';
        </script>";
    }
}
?>
