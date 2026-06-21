<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

$message = "";

if (isset($_POST['update_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $updateQuery = "UPDATE products
                    SET
                    name='$name',
                    category='$category',
                    price='$price',
                    stock='$stock'
                    WHERE id='$id'";

    if (mysqli_query($conn, $updateQuery)) {

        header("Location: index.php");
        exit();

    } else {

        $message = "<div class='alert alert-danger'>
                        Failed to Update Product!
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2>Edit Product</h2>

        <hr>

        <?php echo $message; ?>

        <form method="POST">

            <div class="mb-3">

                <label>Product Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?php echo $product['name']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label>Category</label>

                <input type="text"
                       name="category"
                       class="form-control"
                       value="<?php echo $product['category']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label>Price</label>

                <input type="number"
                       step="0.01"
                       name="price"
                       class="form-control"
                       value="<?php echo $product['price']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label>Stock Quantity</label>

                <input type="number"
                       name="stock"
                       class="form-control"
                       value="<?php echo $product['stock']; ?>"
                       required>

            </div>

            <button type="submit"
                    name="update_product"
                    class="btn btn-primary">

                Update Product

            </button>

            <a href="index.php" class="btn btn-dark">
                Back
            </a>

        </form>

    </div>

</div>

</body>
</html>