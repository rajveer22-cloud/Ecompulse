<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

/* Seller Details */

$query = "SELECT * FROM sellers WHERE id='$seller_id'";
$result = mysqli_query($conn, $query);

$seller = mysqli_fetch_assoc($result);

/* Total Products */

$productQuery = "SELECT COUNT(*) AS total_products
                 FROM products
                 WHERE seller_id='$seller_id'";

$productResult = mysqli_query($conn, $productQuery);

$productData = mysqli_fetch_assoc($productResult);

/* Total Revenue */

$revenueQuery = "SELECT SUM(total_price) AS total_revenue
                 FROM sales
                 WHERE seller_id='$seller_id'";

$revenueResult = mysqli_query($conn, $revenueQuery);

$revenueData = mysqli_fetch_assoc($revenueResult);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-5">

        <div class="text-center">

            <i class="bi bi-person-circle"
               style="font-size:100px;"></i>

            <h2 class="mt-3">

                <?php echo $seller['name']; ?>

            </h2>

            <p class="text-muted">

                Seller Dashboard Account

            </p>

        </div>

        <hr>

        <div class="row mt-4">

            <div class="col-md-6">

                <h5>Email</h5>

                <p>
                    <?php echo $seller['email']; ?>
                </p>

            </div>

            <div class="col-md-6">

                <h5>Seller UID</h5>

                <p>
                    <?php echo $seller['seller_uid']; ?>
                </p>

            </div>

            <div class="col-md-6 mt-4">

                <h5>Total Products</h5>

                <p>
                    <?php echo $productData['total_products']; ?>
                </p>

            </div>

            <div class="col-md-6 mt-4">

                <h5>Total Revenue</h5>

                <p>

                    ₹<?php echo $revenueData['total_revenue'] ?? 0; ?>

                </p>

            </div>

            <div class="col-md-6 mt-4">

                <h5>Account Created</h5>

                <p>
                    <?php echo $seller['created_at']; ?>
                </p>

            </div>

        </div>

        <div class="text-center mt-4">

            <a href="../dashboard/index.php"
               class="btn btn-dark">

               Back to Dashboard

            </a>

        </div>

    </div>

</div>

</body>
</html>