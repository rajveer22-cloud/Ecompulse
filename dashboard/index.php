<?php



session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

/* Total Revenue */

$revenueQuery = "SELECT SUM(total_price) AS total_revenue
                 FROM sales
                 WHERE seller_id='$seller_id'";

$revenueResult = mysqli_query($conn, $revenueQuery);

$revenueData = mysqli_fetch_assoc($revenueResult);


/* Total Products */
$productQuery = "SELECT COUNT(*) AS total_products FROM products WHERE seller_id='$seller_id'";
$productResult = mysqli_query($conn, $productQuery);
$productData = mysqli_fetch_assoc($productResult);

/* Total Stock */
$stockQuery = "SELECT SUM(stock) AS total_stock FROM products WHERE seller_id='$seller_id'";
$stockResult = mysqli_query($conn, $stockQuery);
$stockData = mysqli_fetch_assoc($stockResult);

/* Low Stock Products */
$lowStockQuery = "SELECT * FROM products WHERE stock < 5 AND seller_id='$seller_id'";
$lowStockResult = mysqli_query($conn, $lowStockQuery);


/* Low Stock Products */
$lowStockQuery = "SELECT * FROM products WHERE stock < 5 AND seller_id='$seller_id'";
$lowStockResult = mysqli_query($conn, $lowStockQuery);

/* Product Names + Stock */

$chartQuery = "SELECT name, stock
               FROM products
               WHERE seller_id='$seller_id'";

$chartResult = mysqli_query($conn, $chartQuery);

$productNames = [];
$productStocks = [];

while($chartRow = mysqli_fetch_assoc($chartResult)) {

    $productNames[] = $chartRow['name'];

    $productStocks[] = $chartRow['stock'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcomPulse Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>



        body{
            background:#f4f6f9;
        }

        .sidebar{
            height:100vh;
            background:#212529;
            padding-top:20px;
        }

        .sidebar a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px 20px;
            margin-bottom:10px;
            border-radius:8px;
        }

        .sidebar a:hover{
            background:#0d6efd;
        }

        .card-box{

        border-radius:20px;
        color:white;
        padding:30px;
        transition:0.3s;
        position:relative;
        overflow:hidden;
        }

        .card-box:hover{

            transform:translateY(-5px);
        }

        .card-box i{

            font-size:50px;
            position:absolute;
            right:20px;
            top:20px;
            opacity:0.3;
        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        <!-- Sidebar -->

        <div class="col-md-2 sidebar">

            <h3 class="text-white text-center mb-4">
                EcomPulse
            </h3>

            <a href="../dashboard/index.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="../products/add.php">
                <i class="bi bi-plus-circle"></i>
                Add Product
            </a>

            <a href="../products/index.php">
                <i class="bi bi-box-seam"></i>
                View Products
            </a>

            <a href="../sales/add.php">
                <i class="bi bi-cart-plus"></i>
                Sell Product
            </a>

            <a href="../sales/index.php">
                <i class="bi bi-graph-up"></i>
                Sales History
            </a>

            <a href="../profile/index.php">
                <i class="bi bi-person-circle"></i>
                 Profile
            </a>

            <a href="../auth/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </div>

        <!-- Main Content -->

        <div class="col-md-10 p-4">

            
                <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h2>
                        Welcome,
                        <?php echo $_SESSION['seller_name']; ?> 👋
                    </h2>

                    <p class="text-muted">
                        Manage your inventory and sales efficiently.
                    </p>

                </div>

                <div>

                    <span class="badge bg-dark p-3">
                        Seller UID:
                        <?php echo $_SESSION['seller_uid']; ?>
                    </span>

                </div>

            </div>
            

            <hr>

            <!-- Cards -->

            <div class="row mt-4">

                <div class="col-md-4">

                    <div class="card-box bg-primary shadow">

                        <h4>Total Products</h4>

                        <h2>
                            <?php echo $productData['total_products']; ?>
                        </h2>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card-box bg-success shadow">

                        <h4>Total Stock</h4>

                        <h2>
                            <?php echo $stockData['total_stock'] ?? 0; ?>
                        </h2>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card-box bg-danger shadow">

                        <h4>Low Stock Items</h4>

                        <h2>
                            <?php echo mysqli_num_rows($lowStockResult); ?>
                        </h2>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card-box bg-warning shadow">

                        <h4>Total Revenue</h4>

                        <h2>

                            ₹<?php echo $revenueData['total_revenue'] ?? 0; ?>

                        </h2>

                </div>

            </div>

            

            </div>

            <!-- Low Stock Table -->

            <div class="card shadow mt-5 p-4">

                <h4>Product Stock Distribution</h4>

                <hr>

                <div style="width: 400px; height: 400px; margin:auto;">

                    <canvas id="stockChart"></canvas>

                </div>

            </div>

            <div class="card shadow mt-5 p-4">

                <h4>Low Stock Products</h4>

                <hr>

                <table class="table table-bordered table-hover shadow-sm">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Stock</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($lowStockResult)) { ?>

                        <tr>

                            <td><?php echo $row['id']; ?></td>

                            <td><?php echo $row['name']; ?></td>

                            <td><?php echo $row['stock']; ?></td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
 

</div>
            <footer class="text-center mt-5 mb-3 text-muted">

                © 2026 EcomPulse | Seller Management System

            </footer>

            <script>

            const ctx = document.getElementById('stockChart');

            new Chart(ctx, {

                type: 'pie',

                data: {

                    labels: <?php echo json_encode($productNames); ?>,

                    datasets: [{

                        label: 'Stock Quantity',

                        data: <?php echo json_encode($productStocks); ?>,

                        backgroundColor: [

                            '#58cad7',
                            '#4ee8a0',
                            '#dc7cf2',
                            '#dc3545',
                            '#6f42c1',
                            '#20c997',
                            '#fd7e14'

                        ],

                        borderWidth: 1

                    }]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    scales: {

                        y: {

                            beginAtZero: true
                        }
                    }
                }
            });

            </script>
</body>
</html>