<?php
session_start();
include "../dbcon.php";
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
                        <button class="btn btn text-white mb-2" onclick="loading()" style="background-color: #064663; width: full-width">Add</button>
                        <div class="m-2">
                            <thead class>
                                <tr>
                                    <th>Event type</th>
                                    <th>Number of Poeple</th>
                                    <th>Usage (Hours)</th>
                                    <th>Amount</th>
                                    <th>Paid on</th>

                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>
                                            <?php echo "Party " ?>
                                        </td>
                                        <td>
                                            <?php echo "150" ?>
                                        </td>
                                        <td>
                                            <?php echo "8" ?>
                                        </td>
                                        <td>
                                            <?php echo "₱150"  ?>
                                        </td>
                                        <td>
                                            <?php echo date("M d,Y h:i:sa")  ?>
                                        </td>
                                        <!-- <td>
                                            <?php echo "asdf"  ?>
                                        </td>
                                        <td>
                                            <?php echo "asdf"  ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 300px;">

                                            <?php echo "asdf" ?>
                                        </td> -->
                                    </tr>
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
        $(document).ready(function () {
            $("#myBtn").click(function () {
                $("#myModal").modal("toggle");
            });
        });
    </script>

</body>

</html>