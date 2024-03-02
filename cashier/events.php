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
                <span><i class="bi bi-file-text-fill me-2"></i></span> Events
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <button class="btn btn text-white mb-2" id="myBtn" onclick="loading()" style="background-color: #064663; width: full-width">Add</button>
                        <!-- Modal HTML -->
                        <div id="myModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Events</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form class="needs-validation" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-2">
                                                    <label for="event_name">Event Name:</label>
                                                    <input type="text" class="form-control" id="event_name" name="event_name" autocomplete="off" placeholder="Enter Event Name" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label for="event_venue">Event Venue</label>
                                                    <input type="text" class="form-control" id="event_venue" name="event_venue" autocomplete="off" placeholder="Enter Event Venue" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label for="event_description">Event Description</label>
                                                    <input type="text" class="form-control" id="event_description" name="event_description" autocomplete="off" placeholder="Enter Description" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label for="no_of_people">Number of People</label>
                                                    <input type="number" class="form-control" id="no_of_people" name="no_of_people" autocomplete="off" placeholder="Enter Number of People" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label for="no_of_people">Date of Use</label>
                                                    <input type="date" class="form-control" id="no_of_people" name="date_of_use" autocomplete="off" placeholder="Enter Date of use" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label for="no_of_people">Amount</label>
                                                    <input type="number" class="form-control" id="no_of_people" name="amount" autocomplete="off" placeholder="Enter Amount" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button class="btn btn-success" name="AddEvent">Save</button>
                                            </div>
                                        </form>
                                        <?php
                                        if (array_key_exists('AddEvent', $_POST)) {
                                            $cashiering->SaveEvents($_POST['event_name'], $_POST['event_venue'], $_POST['event_description'], $_POST['no_of_people'], $_POST['date_of_use'], $_POST['amount']);
                                            unset($_POST);
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="m-2">
                    <thead class>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Venue</th>
                            <th>Event Description</th>
                            <th>Number of People</th>
                            <th>To be used on</th>
                            <th>Amount</th>
                            <th>Paid on</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $results = $cashiering->GetAllEvents();
                        $total_price = 0;
                        while ($rows = (mysqli_fetch_assoc($results))) { ?>
                            <tr>
                                <td>
                                    <?php echo $rows['name'] ?>
                                </td>
                                <td>
                                    <?php echo $rows['venue'] ?>
                                </td>
                                <td>
                                    <?php echo $rows['description'] ?>
                                </td>
                                <td>
                                    <?php echo $rows['capacity'] ?>
                                </td>
                                <td>
                                    <?php echo date("M d,Y", strtotime($rows['date'])) ?>
                                </td>
                                <td>
                                    <?php echo $rows['price'];
                                    $total_price +=  $rows['price'];  ?>
                                </td>
                                <td>
                                    <?php if ($rows['paid_on'] === "Not Paid") {
                                        echo "Not Paid";
                                    } else {
                                        echo date("M d,Y", strtotime($rows['date']));
                                    } ?>
                                </td>
                                <td>

                                    <?php if ($rows['paid_on'] === "Not Paid") { ?>
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href="#update<?php echo $rows['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil"></i></span> Set as paid</a>
                                        </div>
                                    <?php } else {
                                        echo "Already Paid";
                                    } ?>
                                    <!-- Update Modal HTML -->
                                    <div id="update<?php echo $rows['id']; ?>" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form id="update_form" method="POST">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update Payment</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="text" id="item_id" name="item_id" value="<?php echo $rows['id'] ?>" class="form-control" autocomplete="off" hidden>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Event Name</label>
                                                            <input type="text" id="event_name" name="event_name" value="<?php echo $rows['name'] ?>" class="form-control" autocomplete="off" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Amount</label>
                                                            <input type="text" id="event_price" name="event_price" value="<?php echo $rows['price'] ?>" class="form-control" autocomplete="off" disabled>
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
                                                        <button class="btn btn-info" id="AddPayment" type="submit" name="submit">Confirm Update</button>
                                                    </div>
                                                </form>
                                                <?php
                                                if (array_key_exists('submit', $_POST)) {
                                                    $cashiering->SetPaidEvents($_POST['item_id'], $_POST['payment_amount']);
                                                    unset($_POST);
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Update Modal -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Total: ₱<?php echo $total_price; ?> <span class="totalAmount"></span></th>
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
        $(document).on('change', '#payment_amount', function() {
            var $row = $(this).closest('tr'); // Get the closest table row
            var item_price = parseFloat($row.find('#event_price').val());
            var payment_amount = parseFloat($(this).val());
            var change = payment_amount - item_price;
            $row.find('#change').val("₱".concat(change.toFixed(2))); // Update the change field in the same row
        });
    </script>

</body>

</html>