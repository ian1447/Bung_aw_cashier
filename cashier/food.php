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
                <span><i class="bi bi-file-text-fill me-2"></i></span> Foods Order
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-hover data-table" style="width: 100%">
                        <button class="btn btn text-white mb-2" id="myBtn" onclick="loading()"
                            style="background-color: #064663; width: full-width">Add Order</button>
                        <!-- Modal HTML -->
                        <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Order</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form class="needs-validation" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-2">
                                                    <label for="event_name">Customer Name:</label>
                                                    <input type="text" class="form-control" id="customer_name"
                                                        name="customer_name" autocomplete="off"
                                                        placeholder="Enter Customer Name" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button class="btn btn-success" name="addOrder">Save</button>
                                            </div>
                                        </form>
                                        <?php
                                        if (array_key_exists('addOrder', $_POST)) {
                                            $cashiering->FoodAddOrder($_POST['customer_name']);
                                            unset($_POST);
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th>Ordered On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $test = $cashiering->GetAllFoodOrders();
                                $total_price = 0;
                                while ($rows = (mysqli_fetch_assoc($test))) { ?>
                                <tr>
                                    <td>
                                        <?php echo $rows['customer_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo "₱" . $rows['total_amount'];
                                            $total_price += $rows['total_amount']; ?>
                                    </td>
                                    <td>
                                        <?php echo date("M d,Y", strtotime($rows['transdate'])); ?>
                                    </td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href=<?php echo "generate_food_receipt.php?id={$rows['id']}&name={$rows['customer_name']}" ?>
                                                target="_blank" class="btn btn-primary btn-sm me-md-2"><span
                                                    class="me-2"><i class="bi bi-printer"></i></span> Print Receipt </a>
                                        </div>
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
            $("#myModal").modal("toggle");
        });
    });
    </script>

</body>

</html>