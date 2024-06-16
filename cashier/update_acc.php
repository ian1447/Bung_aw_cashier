<?php
session_start();
include "../dbcon.php";

// Generate a random string for remember_token
function str_random($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body class="fixed-left" style="background-color: #ECB365">

    <!-- Top Bar Start -->
    <?php include('includes/navbar.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <main class="mt-5 pt-4">
        <div class="container">
            <h3 class="fw-bold">Update Account</h3>
            <div class="card border-secondary mb-3">
                <form class="needs-validation" method="POST" action="">
                    <div class="form-row">
                        <div class="col-md-6 m-3">
                            <label for="id">Email <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" id="id" value="<?php echo $_SESSION['email']; ?>" disabled>
                            <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                        </div>
                        <div class="col-md-6 m-3">
                            <label for="validationCustom01">New Password <span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" name="newpassword" id="validationCustom01"
                                placeholder="Enter new password" required>
                        </div>
                        <div class="col-md-6 m-3">
                            <label for="validationCustom02">Confirm Password <span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" name="retypepassword" id="validationCustom02"
                                placeholder="Confirm new password" required>
                        </div>
                    </div>
                    <div class="m-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Cancel</button>
                    </div>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($_POST['newpassword'] != $_POST['retypepassword']) {
                        echo '<script>alert("Passwords do not match!") 
                            window.location.href="update_acc.php"</script>';
                    } else {
                        // Hash the new password using bcrypt
                        $hashedPassword = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
                        // Generate a random remember_token
                        $rememberToken = str_random(10);

                        $sql = "UPDATE users 
                                SET `password` = ?, `remember_token` = ? 
                                WHERE `email` = ?";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("sss", $hashedPassword, $rememberToken, $_POST['email']);
                            if ($stmt->execute()) {
                                // Destroy the session and redirect to login page
                                session_destroy();
                                echo '<script>alert("Credentials Changed Successfully! Please log in again.") 
                                    window.location.href="../index.php"</script>';
                            } else {
                                echo '<script>alert("Changing Credentials Failed!\n Please Check SQL Connection String!") 
                                    window.location.href="update_acc.php"</script>';
                            }
                            $stmt->close();
                        } else {
                            echo '<script>alert("Failed to prepare statement!") 
                                window.location.href="update_acc.php"</script>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

</body>

</html>
