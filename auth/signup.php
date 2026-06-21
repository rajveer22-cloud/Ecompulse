<?php
session_start();
include("../config/db.php");

$message = "";

if (isset($_POST['signup'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Generate Unique Seller ID
    $seller_uid = "SELLER" . rand(1000, 9999);

    // Hash Password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = "SELECT * FROM sellers WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {

        $message = "<div class='alert alert-danger'>Email already exists!</div>";

    } else {

        // Insert Data
        $query = "INSERT INTO sellers (seller_uid, name, email, password)
                  VALUES ('$seller_uid', '$name', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $query)) {

            $message = "<div class='alert alert-success'>
                            Registration Successful! Your Seller ID is: <b>$seller_uid</b>
                        </div>";

        } else {

            $message = "<div class='alert alert-danger'>Something went wrong!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Signup</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">Seller Signup</h2>

                <?php echo $message; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" name="signup" class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php">Already have an account? Login</a>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>