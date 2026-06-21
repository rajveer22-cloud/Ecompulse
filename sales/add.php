<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

$productQuery = "SELECT * FROM products WHERE seller_id='$seller_id'";
$productResult = mysqli_query($conn, $productQuery);

$message = "";

if (isset($_POST['sell_product'])) {

    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity_sold'];

    // Get Product
    $getProduct = "SELECT * FROM products WHERE id='$product_id'";
    $productResult2 = mysqli_query($conn, $getProduct);

    $product = mysqli_fetch_assoc($productResult2);

    $current_stock = $product['stock'];
    $price = $product['price'];

    // Check stock
    if ($quantity_sold > $current_stock) {

        $message = "<div class='alert alert-danger'>
                        Not enough stock!
                    </div>";

    } else {

        // Calculate total price
        $total_price = $price * $quantity_sold;

        // Insert sale
        $saleQuery = "INSERT INTO sales
                     (seller_id, product_id, quantity_sold, total_price)
                     VALUES
                     ('$seller_id', '$product_id', '$quantity_sold', '$total_price')";

        mysqli_query($conn, $saleQuery);

        // Update stock
        $new_stock = $current_stock - $quantity_sold;

        $updateStock = "UPDATE products
                        SET stock='$new_stock'
                        WHERE id='$product_id'";

        mysqli_query($conn, $updateStock);

        $message = "<div class='alert alert-success'>
                        Sale Recorded Successfully!
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sell Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2>Sell Product</h2>

        <hr>

        <?php echo $message; ?>

        <form method="POST">

            <div class="mb-3">

                <label>Select Product</label>

                <select name="product_id"
                        class="form-control"
                        required>

                    <option value="">
                        Choose Product
                    </option>

                    <?php while($row = mysqli_fetch_assoc($productResult)) { ?>

                        <option value="<?php echo $row['id']; ?>">

                            <?php echo $row['name']; ?>

                            (Stock: <?php echo $row['stock']; ?>)

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label>Quantity Sold</label>

                <input type="number"
                       name="quantity_sold"
                       class="form-control"
                       required>

            </div>

            <button type="submit"
                    name="sell_product"
                    class="btn btn-primary">

                Record Sale

            </button>

        </form>

    </div>

</div>

</body>
</html>