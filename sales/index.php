<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

$query = "SELECT sales.*, products.name
          FROM sales
          JOIN products
          ON sales.product_id = products.id
          WHERE sales.seller_id='$seller_id'
          ORDER BY sales.id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center">

            <h2>Sales History</h2>

            <a href="add.php" class="btn btn-success">
                Sell Product
            </a>

        </div>

        <hr>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['name']; ?></td>

                    <td><?php echo $row['quantity_sold']; ?></td>

                    <td>₹<?php echo $row['total_price']; ?></td>

                    <td><?php echo $row['sale_date']; ?></td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>