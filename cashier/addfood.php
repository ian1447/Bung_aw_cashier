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
    <?php include 'includes/navbar.php'; ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include 'includes/sidebar.php'; ?>
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
                <span><i class="bi bi-file-text-fill me-2"></i></span> Foods
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Item Count:</label>
                    <input type="text" id="item_count" name="item_count" value="<?php echo $cashiering->CountOrders(); ?>" class="bi bi-file-text-fill me-2" autocomplete="off" disabled>
                    <!-- <button class="btn btn text-white m-lg-2" id="resetBtn" style="background-color: #556B2F" name="reset_button">Clear Orders</button> -->
                    <!-- <button class="btn btn text-white m-lg-2" id="myBtn2" data-bs-toggle="modal" data-bs-target="#myModal2" style="background-color: #556B2F" name="another_button">View
                        Orders</button> -->
                    <?php
                    // if (array_key_exists('finalize', $_POST)) {
                    //     $cashiering->FinalizeFoodOrder($_SESSION['bulkid']);
                    //     unset($_POST);
                    // }
                    ?>
                </div>
                <div class="table-responsive">
                    <table id="example" class="table table-hover data-table" style="width: 100%">
                        <div class="m-2">
                            <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Food Type</th>
                                    <th>Food Name</th>
                                    <th>Amount</th>
                                    <th style="width: 2px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form method="POST">
                                    <?php
                                    foreach ($_SESSION['foodarr'] as $rows) { ?>
                                        <tr>
                                            <td hidden>
                                                <?php echo $rows['item_id'] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['item_type'] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['item_name'] ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['item_price'] ?>
                                            </td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex">
                                                    <!-- <input type="checkbox" name="selected_items[]" value="" /> -->
                                                    <div><input type='number' class="item_quan" id=<?php echo "quantity_{$rows['item_id']}"; ?> class='form-control' onChange=<?php echo "quantity_{$rows['item_id']}"; ?> value=<?php echo "{$rows['qty']}"; ?>></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4">
                                            <input type="submit" class="btn btn-info" name="add_to_order" value="Add to Order">
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </div>
                    </table>
                </div>
                <?php
                if (array_key_exists('add_to_order', $_POST)) {
                    $cashiering->FinalizeFoodOrder($_SESSION['bulkid']);
                    unset($_POST);
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
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $("#myBtn").click(function() {
                $("#myModal").modal("toggle");
            });
        });
        // $(document).on('change', '#payment_amount', function() {
        //     var $row = $(this).closest('tr'); // Get the closest table row
        //     var item_price = parseFloat($row.find('#item_price').val());
        //     var payment_amount = parseFloat($(this).val());
        //     var change = payment_amount - item_price;
        //     $row.find('#change').val("₱".concat(change.toFixed(2))); // Update the change field in the same row
        // });
    </script>

    <script>
        $(document).ready(function() {
            $("#myBtn2").click(function() {
                $("#myModal2").modal("toggle");
            });
        });

        $(document).ready(function() {
            var table = $('#example').DataTable();
            $('#example').on('input', '.item_quan', function() {
                // var rowData = table.row($(this).closest('tr')).data();
                var closestRow = this.closest('tr'); // Directly find closest table row
                //console.log("closestRow:", closestRow); // Debugging
                var rowData = [];
                closestRow.querySelectorAll('td').forEach(function(cell) {
                    rowData.push(cell.textContent.trim());
                });
               // console.log("rowData:", rowData); // Debugging
                var newValue = $(this).val();
                var old_count = parseFloat($('#item_count').val());
                $('#item_count').val(old_count + 1);
                addQuantity(rowData[0], newValue);
            });

            function addQuantity(itemId, newquan) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_quantity.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        //console.log("response",xhr.responseText);
                        xhr.responseText
                    }
                };
                xhr.send('item_id=' + itemId + '&quantity=' + newquan);
            }
        });

        // function addQuantity(itemId) {
        //     //var quantity = document.getElementById('quantity_' + itemId).value;
        //     console.log("quantity");
        //     var quantity = $(this).val();
        //     console.log(quantity);
        //     // Send AJAX request to update session variable
        //     var xhr = new XMLHttpRequest();
        //     xhr.open('POST', 'update_quantity.php', true);
        //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //     xhr.onreadystatechange = function() {
        //         if (xhr.readyState == 4 && xhr.status == 200) {
        //             // Handle response if needed
        //             console.log(xhr.responseText);
        //         }
        //     };
        //     xhr.send('item_id=' + itemId + '&quantity=' + quantity);
        // }
    </script>

</body>

</html>