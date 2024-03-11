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

        <!-- Datatable for memo records -->
        <div class="card shadow-lg">
            <div class="card-header">
                <span><i class="bi bi-file-text-fill me-2"></i></span> Rooms
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <button class="btn btn text-white mb-2" id="myBtn" onclick="loading()" style="background-color: #064663; width: full-width">Add</button>
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Room Name</th>
                                    <th>Amount Paid</th>
                                    <th>Remaining Balance</th>
                                    <th>Paid on</th>
                                    <th>Payment Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $test = $cashiering->GetAllRoomPayments();
                                $total_price = 0;
                                while ($rows = (mysqli_fetch_assoc($test))) { ?>
                                <tr>
                                    <td>
                                        <?php echo $rows["item_name"] ?>
                                    </td>
                                    <td>
                                        <?php echo "₱" . $rows["amount"]; $total_price += $rows["amount"]; ?>
                                    </td>
                                    <td>
                                        <?php echo "₱" . $rows["remaining_balance"] ?>
                                    </td>
                                    <td>
                                        <?php echo date("M d,Y h:i:sa", strtotime($rows['transdate'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($rows["payment_type"] === '1'){
                                            echo "Fully Paid";
                                        }
                                        else{
                                            echo "Partially Paid";
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($rows["payment_type"] === '1'){ ?>
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href=<?php echo "generate_receipt.php?type=Room&item_name={$rows['item_name']}&no_of_people=0&amount={$rows['amount']}" ?> target="_blank" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-printer"></i></span> Print Receipt </a>
                                        </div>
                                        <?php }else{?>
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href="#edit<?php echo $rows['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil"></i></span> Edit Payment</a>
                                        </div>
                                        <!-- Edit Modal HTML -->
                                        <div id="edit<?php echo $rows['id']; ?>" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="update_form" method="POST">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Payment To fully paid</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type="text" id="id" name="booking_id" value="<?php echo $rows['item_id'] ?>" class="form-control" autocomplete="off" hidden>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" id="id" name="item_id" value="<?php echo $rows['id'] ?>" class="form-control" autocomplete="off" hidden>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Item Name</label>
                                                                <input type="text" id="item_name" name="item_name" value="<?php echo $rows['item_name'] ?>" class="form-control" autocomplete="off" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Item Price</label>
                                                                <input type="text" id="item_price" name="item_price" value="<?php echo $rows['remaining_balance'] ?>" class="form-control" autocomplete="off" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Payment Amount</label>
                                                                <input type="text" id="payment_amount" name="payment_amount" class="form-control" autocomplete="off" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Change</label>
                                                                <input type="text" id="change" name="change" class="form-control" autocomplete="off" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" value="2" name="type">
                                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                            <button class="btn btn-info" id="AddPayment" type="submit" name="submit">Add Payment</button>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    if (array_key_exists('submit', $_POST)) {
                                                        $cashiering->UpdateRoomPayment($_POST['item_id'], $_POST['payment_amount'],$_POST['booking_id'], $_POST['item_price']);
                                                        unset($_POST);
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Edit Modal -->
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <td></td>
                                <th>Total: ₱<?php echo $total_price; ?> <span class="totalAmount"></span></th>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- end of memo datatable -->
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
                document.location.href = "addroom.php";
            });
        });
        $(document).on('change', '#payment_amount', function() {
            var $row = $(this).closest('tr'); // Get the closest table row
            var item_price = parseFloat($row.find('#item_price').val());
            var payment_amount = parseFloat($(this).val());
            var change = payment_amount - item_price;
            $row.find('#change').val("₱".concat(change.toFixed(2))); // Update the change field in the same row
        });
    </script>

</body>

</html>