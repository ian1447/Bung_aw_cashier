<?php
session_start();
include "../dbcon.php";
include 'backend.php';
$cashiering = new Cashiering();
$cashiering->setDb($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body class="fixed-left">

    <!-- Top Bar Start -->
    <?php include('includes/navbar.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <main class="mt-5 pt-3 px-4">

        <!-- for header -->
        <div class="card shadow-lg" style="background-color: #04293A; border-radius: 8px;">
            <div class="card-body" style="background-color: #04293A; border-radius: 8px; ">
                <div class="row g-0">
                    <div class="col-md-4" style="background-color: #04293A;">
                        <img src="../logo.png" class="img-fluid" alt="..." style="width: 50px; height:50px;">
                    </div>
                    <div class="col-md-4 fw-bold">
                        <h4 style="color: white">Bung-aw Cashiering</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of header -->

        <div class="card shadow-lg">
            <div class="card-header">
                <span><i class="bi bi-file-text-fill me-2"></i></span> Foods Payments Logs
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-hover data-table" style="width: 100%">
                        <button class="btn btn text-white m-lg-2" id="myBtn" onclick="loading()" style="background-color: #064663; width: full-width">Add Order</button>
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Food Name</th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $test = $cashiering->GetAllFoodPayments($_SESSION['bulkid']);
                                $total_price = 0;
                                while ($rows = (mysqli_fetch_assoc($test))) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $rows['name'] ?>
                                        </td>
                                        <td>
                                            <?php echo "₱" . $rows['price'];
                                            $total_price += $rows['price']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <td></td>
                                <th>Total Amount: ₱<?php echo $total_price; ?> <span class="totalAmount"></span></th>
                                <td></td>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myBtn").click(function() {
                document.location.href = "addfood.php";
            });
        });
    </script>

</body>

</html>