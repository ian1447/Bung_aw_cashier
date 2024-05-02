<?php
session_start();
include "../dbcon.php";
include 'backend.php';
$cashiering = new Cashiering();
$cashiering->setDb($conn);

// Initialize selected food items array in session if it's not already set
if (!isset($_SESSION['food_items'])) {
    $_SESSION['food_items'] = array();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all necessary fields are set
    if (isset($_POST['item_id'], $_POST['item_type'], $_POST['item_name'], $_POST['item_price'])) {
        // Add the submitted food item to the session array
        $food_item = array(
            'item_id' => $_POST['item_id'],
            'item_type' => $_POST['item_type'],
            'item_name' => $_POST['item_name'],
            'item_price' => $_POST['item_price'],
            'qty' => $_POST['item_quantity_'.$_POST['item_id']]
        );
        $_SESSION['food_items'][] = $food_item;
    }
    // Check if it's for removing an item
    elseif (isset($_POST['remove_item_index']) && is_numeric($_POST['remove_item_index'])) {
        $index = intval($_POST['remove_item_index']);
        if (isset($_SESSION['food_items'][$index])) {
            unset($_SESSION['food_items'][$index]);
        }
    }

    // Check if it's for updating the quantity of an item
    elseif (isset($_POST['update_quantity'], $_POST['item_id'], $_POST['quantity'])) {
        $itemId = $_POST['item_id'];
        $newQuantity = $_POST['quantity'];
        foreach ($_SESSION['food_items'] as &$food_item) {
            if ($food_item['item_id'] === $itemId) {
                $food_item['qty'] = $newQuantity;
                break;
            }
        }
    }
}
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
                <div class="container">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <!-- <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Name:</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1"> -->
                                </div>
                                <form method="POST">
                                    <table id="example" class="table table-hover data-table" style="width: 100%">
                                        <div class="m-2">
                                            <thead>
                                                <tr>
                                                    <th hidden>Id</th>
                                                    <th>Food Type</th>
                                                    <th>Food Name</th>
                                                    <th>Amount</th>
                                                    <th>Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($_SESSION['food_items'] as $index => $rows) { ?>
                                                    <tr>
                                                        <?php if ($index === 0) { ?>
                                                            <!-- Set the first row as empty and hidden -->
                                                            <td hidden></td>
                                                            <td hidden></td>
                                                            <td hidden></td>
                                                            <td hidden>₱0.00</td>
                                                            <td hidden></td>
                                                            <td hidden></td>
                                                        <?php } else { ?>
                                                            <td hidden><?php echo $rows['item_id'] ?></td>
                                                            <td><?php echo $rows['item_type'] ?></td>
                                                            <td><?php echo $rows['item_name'] ?></td>
                                                            <td>₱<?php echo $rows['item_price'] ?></td>
                                                            <td>
                                                                <input type="number"
                                                                    class="item_quan form-control"
                                                                    name="item_quantity_<?php echo $rows['item_id']; ?>"
                                                                    id="<?php echo "quantity_{$rows['item_id']}"; ?>"
                                                                    onchange="updateTotalAmount()"
                                                                    value="<?php echo "{$rows['qty']}"; ?>"
                                                                    min="1">
                                                            </td>
                                                            <td>
                                                                <form method="POST">
                                                                    <input type="hidden" name="remove_item_index" value="<?php echo $index ?>">
                                                                    <button type="submit" name="remove_item_index" value="<?php echo $index ?>" class="btn bi bi-x-circle" style="background-color: transparent; border: none;"></button>
                                                                </form>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td>Total Amount:</td>
                                                    <td id="totalAmount">
                                                        <!-- Total amount will be dynamically updated here -->
                                                        <?php
                                                            $total_amount = 0;
                                                            foreach ($_SESSION['food_items'] as $index => $rows) {
                                                                if ($index !== 0) {
                                                                    $total_amount += $rows['item_price'] * $rows['qty'];
                                                                }
                                                            }
                                                            echo "₱" . number_format($total_amount, 2);
                                                        ?>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <button type="submit" class="btn btn-info" name="add_to_order">Save Order</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </div>
                                    </table>
                                </form>
                            </div>
                            <?php
                            if (array_key_exists('add_to_order', $_POST)) {
                                $cashiering->FinalizeFoodOrder($_SESSION['bulkid']);
                                unset($_POST);
                            }
                            ?>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Ex. Vegetables" aria-label="Search Food Name" aria-describedby="basic-addon2" onkeyup="filterCards()">
                                </div>
                                <div class="row" style="width: auto;" id="foodCards">
                                    <?php foreach ($_SESSION['foodarr'] as $rows) { ?>
                                        <div class="col p-2 food-card" data-name="<?php echo strtolower($rows['item_name']); ?>">
                                            <div class="card text-center">
                                                <div class="d-flex justify-content-center">
                                                    <img class="card-img-top w-50" src="./images/logo.png" alt="Food Image">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $rows['item_name'] ?></h5>
                                                    <p class="card-text">₱<?php echo $rows['item_price'] ?></p>
                                                    <form method="POST">
                                                        <input type="hidden" name="item_id" value="<?php echo $rows['item_id'] ?>"/>
                                                        <input type="hidden" name="item_type" value="<?php echo $rows['item_type'] ?>"/>
                                                        <input type="hidden" name="item_name" value="<?php echo $rows['item_name'] ?>"/>
                                                        <input type="hidden" name="item_price" value="<?php echo $rows['item_price'] ?>"/>
                                                        <button type="submit" class="btn w-100" style="background-color: #041C32; color: white">Add Food</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        // function updateTotalAmount() {
        // let totalAmount = 0;
        // document.querySelectorAll('.item_quan').forEach(function(input) {
        //     const rowIndex = input.closest('tr').rowIndex;
        //     const price = parseFloat(input.closest('tr').querySelector('td:nth-child(4)').textContent.replace('₱', ''));
        //     const quantity = parseFloat(input.value);
        //     totalAmount += price * quantity;
        // });
        // document.getElementById('totalAmount').textContent = '₱' + totalAmount.toFixed(2);

        // // Update the value of the quantity input
        // const quantityInput = event.target;
        // quantityInput.value = parseFloat(quantityInput.value); // Ensure the value is parsed as a float
        // }

        function updateTotalAmount() {
    let totalAmount = 0;
    let itemCount = 0; // Track the number of items with quantity > 0
    document.querySelectorAll('.item_quan').forEach(function(input) {
        const rowIndex = input.closest('tr').rowIndex;
        const price = parseFloat(input.closest('tr').querySelector('td:nth-child(4)').textContent.replace('₱', ''));
        const quantity = parseFloat(input.value);
        if (quantity > 0) {
            totalAmount += price * quantity;
            itemCount++; // Increment item count
        }
        // Update session with new quantity
        const itemId = input.getAttribute('name').split('_')[2]; // Extract item ID from input name
        updateSession(itemId, quantity);
    });

    // Display total only if there's at least one item with quantity > 0
    if (itemCount > 0) {
        document.getElementById('totalAmount').textContent = '₱' + totalAmount.toFixed(2);
    } else {
        document.getElementById('totalAmount').textContent = '₱0.00';
    }
}

    function updateSession(itemId, newQuantity) {
        // Send AJAX request to update session variable
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addfood.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response if needed
                console.log(xhr.responseText);
            }
        };
        xhr.send('update_quantity=true&item_id=' + itemId + '&quantity=' + newQuantity);
    }

    function filterCards() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.food-card');
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            if (name.includes(input)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to calculate total amount
            function calculateTotalAmount() {
                let totalAmount = 0;
                document.querySelectorAll('#selectedItemsTable tbody tr').forEach(function (row) {
                    const price = parseFloat(row.cells[3].textContent.replace('₱', ''));
                    const quantity = parseFloat(row.querySelector('.item-quantity').value);
                    totalAmount += price * quantity;
                });
                document.getElementById('totalAmount').textContent = '₱' + totalAmount.toFixed(2);
            }

            // Event listener for quantity input change
            document.querySelectorAll('.item-quantity').forEach(function (input) {
                input.addEventListener('change', calculateTotalAmount);
            });

            // Event listener for remove item button click
            document.querySelectorAll('.remove-item').forEach(function (button) {
                button.addEventListener('click', function () {
                    const index = this.getAttribute('data-index');
                    // Remove the entire row from the table
                    document.querySelectorAll('#selectedItemsTable tbody tr')[index].remove();
                    calculateTotalAmount();
                });
            });
        });
    </script>
    
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