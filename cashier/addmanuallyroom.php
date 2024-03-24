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
                <span><i class="bi bi-file-text-fill me-2"></i></span> Rooms
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Modal HTML -->

                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Description</th>
                                    <th>Maximum # of Person</th>
                                    <th>Maximum # of Extra Pax</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $results = $cashiering->GetAllRoomTypes();
                                while ($rows = (mysqli_fetch_assoc($results))) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $rows['name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $rows['description'] ?>
                                        </td>
                                        <td>
                                            <?php echo $rows['max_adult'] ?>
                                        </td>
                                        <td>
                                            <?php echo $rows['max_child'] ?>
                                        </td>
                                        <td>
                                            <?php echo "₱" . $rows['cost_per_day']  ?>
                                        </td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex">
                                                <a href="#edit<?php echo $rows['id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm me-md-2"><span class="me-2"><i class="bi bi-pencil"></i></span> Book Room</a>
                                            </div>
                                            <!-- Edit Modal HTML -->
                                            <div id="edit<?php echo $rows['id']; ?>" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form id="update_form" method="POST">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Book Room</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="number" id="id" name="id" value="<?php echo $rows['id']; ?>" class="form-control" autocomplete="off" hidden>
                                                                    <input type="number" id="max_guests" name="max_guests" value="<?php echo $rows['max_adult']; ?>" class="form-control" autocomplete="off" hidden>
                                                                    <input type="number" id="max_exceed" name="max_exceed" value="<?php echo $rows['max_child']; ?>" class="form-control" autocomplete="off" hidden>
                                                                    <input type="number" id="cost" name="cost" value="<?php echo $rows['cost_per_day']; ?>" class="form-control" autocomplete="off" hidden>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Room Name</label>
                                                                    <input type="text" value="<?php echo $rows['name'] ?>" class="form-control" autocomplete="off" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Room Booker</label>
                                                                    <input type="text" id="booker" name="booker" class="form-control" autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Room Number</label>
                                                                    <!-- <input type="text" id="item_price" name="item_price" value="<?php echo $rows['room_cost'] ?>" class="form-control" autocomplete="off"> -->
                                                                    <select class="form-select" aria-label="Default select example" name="room_number" id="room_number">
                                                                        <option selected>-- Please Select Room Number --</option>
                                                                        <?php $RoomNumbersResult = $cashiering->GetAllRoomNumber($rows['id']);
                                                                        while ($number = (mysqli_fetch_assoc($RoomNumbersResult))) { ?>
                                                                            <option value="<?php echo $number['room_number'] ?>"><?php echo $number['room_number'] ?></option>
                                                                        <?php } ?>
                                                                        <!-- <option value="1">One</option>
                                                                        <option value="2">Two</option>
                                                                        <option value="3">Three</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Number of days</label>
                                                                    <input type="number" id="number_of_days" name="number_of_days" class="form-control" autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Number of Adults</label>
                                                                    <input type="number" id="number_of_adults" name="number_of_adults" class="form-control" autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Number of Children(Above 2 years old)</label>
                                                                    <input type="number" id="number_of_children" name="number_of_children" class="form-control" autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Number of Children(Below 2 years old)</label>
                                                                    <input type="number" id="number_of_children2" name="number_of_children2" class="form-control" autocomplete="off" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Payment Amount</label>
                                                                    <input type="text" id="payment_amount" name="payment_amount" class="form-control" autocomplete="off" disabled>
                                                                    <input type="text" id="total_cost" name="total_cost" class="form-control" autocomplete="off" hidden>
                                                                </div>
                                                                <label style="color: red" id="error<?php echo $rows['id']; ?>" name="error"></label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" value="2" name="type">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <button class="btn btn-info" id="AddPayment" type="submit" name="submit">Book Room</button>
                                                            </div>
                                                        </form>
                                                        <?php
                                                        if (array_key_exists('submit', $_POST)) {
                                                            $cashiering->BookRoomManually($_POST['booker'], $_POST['room_number'], $_POST['total_cost'], $_POST['number_of_days']);
                                                            unset($_POST);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Edit Modal -->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
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
        $(document).on('change', '#number_of_children', function() {
            var $row = $(this).closest('tr'); // Get the closest table row
            var id = $row.find('#id').val();
            let labelElement = document.getElementById("error".concat(id));
            labelElement.innerHTML = "";
            var no_of_adults = $row.find('#number_of_adults').val();
            var max_guests = $row.find('#max_guests').val();
            var max_exceeding_guets = $row.find('#max_exceed').val();
            var payment = $row.find('#cost').val();
            var days = $row.find('#number_of_days').val();
            days = days === "" ? 0 : parseFloat(days);
            no_of_adults = no_of_adults === "" ? 0 : parseFloat(no_of_adults);
            var no_of_children = parseFloat($(this).val());
            var total_guest = no_of_adults + no_of_children;
            var error, total;
            if (total_guest <= max_guests) {
                total = payment * days;
                $row.find('#payment_amount').val("₱".concat(total.toFixed(2))); // Update the change field in the same row
                $row.find('#total_cost').val(total);
            } else {
                var number_of_exceeding_guests = total_guest - max_guests;
                if (number_of_exceeding_guests > max_exceeding_guets) {
                    labelElement.innerHTML = "Guests Numbers exceeds total amount of guests.";
                } else {
                    total = (payment * days) + (number_of_exceeding_guests * 250);
                    $row.find('#payment_amount').val("₱".concat(total.toFixed(2)));
                    $row.find('#total_cost').val(total);
                }
            }
        });
        $(document).on('change', '#number_of_adults', function() {
            var $row = $(this).closest('tr'); // Get the closest table row
            var id = $row.find('#id').val();
            let labelElement = document.getElementById("error".concat(id));
            labelElement.innerHTML = "";
            var no_of_adults = parseFloat($(this).val());
            var max_guests = $row.find('#max_guests').val();
            var max_exceeding_guets = $row.find('#max_exceed').val();
            var payment = $row.find('#cost').val();
            var days = $row.find('#number_of_days').val();
            var no_of_children = $row.find('#number_of_children').val();
            no_of_children = no_of_children === "" ? 0 : parseFloat(no_of_children);
            days = days === "" ? 0 : parseFloat(days);
            var total_guest = no_of_adults + no_of_children;
            var error, total;
            if (total_guest <= max_guests) {
                total = payment * days;
                $row.find('#payment_amount').val("₱".concat(total.toFixed(2))); // Update the change field in the same row
                $row.find('#total_cost').val(total);
            } else {
                var number_of_exceeding_guests = total_guest - max_guests;
                if (number_of_exceeding_guests > max_exceeding_guets) {
                    labelElement.innerHTML = "Guests Numbers exceeds total amount of guests.";
                } else {
                    total = (payment * days) + (number_of_exceeding_guests * 250);
                    $row.find('#payment_amount').val("₱".concat(total.toFixed(2)));
                    $row.find('#total_cost').val(total);
                }
            }
        });
        $(document).on('change', '#number_of_days', function() {
            var $row = $(this).closest('tr'); // Get the closest table row
            var id = $row.find('#id').val();
            let labelElement = document.getElementById("error".concat(id));
            labelElement.innerHTML = "";
            var no_of_adults = $row.find('#number_of_adults').val();
            var max_guests = $row.find('#max_guests').val();
            var max_exceeding_guets = $row.find('#max_exceed').val();
            var payment = $row.find('#cost').val();
            var days = parseFloat($(this).val());
            var no_of_children = $row.find('#number_of_children').val();
            no_of_children = no_of_children === "" ? 0 : parseFloat(no_of_children);
            days = days === "" ? 0 : parseFloat(days);
            var total_guest = no_of_adults + no_of_children;
            var error, total;
            if (total_guest <= max_guests) {
                total = payment * days;
                $row.find('#payment_amount').val("₱".concat(total.toFixed(2))); // Update the change field in the same row
                $row.find('#total_cost').val(total);
            } else {
                var number_of_exceeding_guests = total_guest - max_guests;
                if (number_of_exceeding_guests > max_exceeding_guets) {
                    labelElement.innerHTML = "Guests Numbers exceeds total amount of guests.";
                } else {
                    total = (payment * days) + (number_of_exceeding_guests * 250);
                    $row.find('#payment_amount').val("₱".concat(total.toFixed(2)));
                    $row.find('#total_cost').val(total);
                }
            }
        });
    </script>

</body>

</html>