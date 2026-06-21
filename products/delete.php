<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM products WHERE id='$id'";

mysqli_query($conn, $query);

header("Location: index.php");
exit();
?>