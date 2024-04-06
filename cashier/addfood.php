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
    <?php include 'includes/navbar.php';?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include 'includes/sidebar.php';?>
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
            <input type="text" id="item_count" name="item_count" value="<?php echo count($_SESSION["foodarr"]) ?>" class="bi bi-file-text-fill me-2" autocomplete="off" disabled>
            <button class="btn btn text-white m-lg-2" id="myBtn2" style="background-color: #556B2F" name="reset_button">Clear Orders</button>
            <button class="btn btn text-white m-lg-2" id="myBtn2" data-bs-toggle="modal" data-bs-target="#myModal2" style="background-color: #556B2F" name="another_button">View Orders</button>
            <?php
                if (array_key_exists('finalize', $_POST)) {
                    $cashiering->FinalizeFoodOrder($_SESSION['bulkid']);
                    unset($_POST);
                }
            ?>
        </div>
        <div class="table-responsive">
            <table id="example" class="table table-hover data-table" style="width: 100%">
                <div class="m-2">
                    <thead>
                        <tr>
                            <th>Food Type</th>
                            <th>Food Name</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $results = $cashiering->GetAllFoodItems();
                        while ($rows = (mysqli_fetch_assoc($results))) {?>
                            <tr onclick="addToOrder(<?php echo $rows['id']; ?>)">
                                <td>
                                    <?php echo $rows['type'] ?>
                                </td>
                                <td>
                                    <?php echo $rows['name'] ?>
                                </td>
                                <td>
                                    <?php echo $rows['price'] ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </div>
            </table>
        </div>
    </div>
</div>
<!-- Second Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Ordered Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="orderedItemsList"></ul>
                <?php $results = $cashiering->ViewOrders();?>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <button class="btn btn text-white m-lg-2" id="myBtn" onclick="loading()" style="background-color: #556B2F; " type="submit" name="finalize">Finalize Order</button>
                </form>
            </div>
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
        function addToOrder(itemId) {
            // Add the item to the orders array
            <?php $rows = mysqli_fetch_assoc($cashiering->GetAllFoodItems()); ?>
            <?php array_push($_SESSION['foodarr'], $rows['id']); ?>
            // Update the item count
            document.getElementById('item_count').value = <?php echo count($_SESSION['foodarr']); ?>;
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#myBtn").click(function() {
                $("#myModal").modal("toggle");
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

    <script>
         $(document).ready(function() {
            $("#myBtn2").click(function() {
                $("#myModal2").modal("toggle");
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
        var myModal2 = document.getElementById('myModal2');
        myModal2.addEventListener('show.bs.modal', function(event) {
            var orderedItemsList = document.getElementById('orderedItemsList');
            orderedItemsList.innerHTML = ''; // Clear previous content
            <?php foreach ($_SESSION['foodarr'] as $item_id): ?>
                <?php $item = $cashiering->GetFoodItemById($item_id);?>
                var li = document.createElement('li');
                li.textContent = '<?php echo $item['name']; ?> - $<?php echo $item['price']; ?>';
                orderedItemsList.appendChild(li);
            <?php endforeach;?>
        });
    });
    </script>

</body>

</html>