<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if (isset($_POST['add_product'])) {

    $seller_id = $_SESSION['seller_id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $query = "INSERT INTO products (seller_id, name, category, price, stock)
              VALUES ('$seller_id', '$name', '$category', '$price', '$stock')";

    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>Product Added Successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to Add Product!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2>Add Product</h2>

        <hr>

        <?php echo $message; ?>

        <form method="POST">

            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <input type="text" name="category" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Stock Quantity</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <button type="submit" name="add_product" class="btn btn-primary">
                Add Product
            </button>

            <a href="index.php" class="btn btn-dark">
                View Products
            </a>

        </form>

    </div>

</div>

</body>
</html>