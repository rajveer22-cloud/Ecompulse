<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $query = "SELECT * FROM products
              WHERE seller_id='$seller_id'
              AND name LIKE '%$search%'";

} else {

    $query = "SELECT * FROM products
              WHERE seller_id='$seller_id'";
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center">

            <h2>Your Products</h2>

            <a href="add.php" class="btn btn-success">
                Add Product
            </a>

        </div>

        <hr>

        <form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-10">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search Product..."
                   value="<?php echo $search; ?>">

        </div>

        <div class="col-md-2">

                <button type="submit"
                        class="btn btn-primary w-100">

                    Search

                </button>

            </div>

        </div>

</form>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['name']; ?></td>

                    <td><?php echo $row['category']; ?></td>

                    <td>₹<?php echo $row['price']; ?></td>

                    <td><?php echo $row['stock']; ?></td>

                    <td>

                        <a href="edit.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-warning btn-sm">
                        Edit
                        </a>

                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?')">

                            Delete

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>