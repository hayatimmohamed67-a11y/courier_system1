<?php
include 'config.php';

if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    $allowed = ['pending', 'in_transit', 'delivered', 'cancelled'];
    
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE packages SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: orders.php");
    exit();
} else {
    header("Location: orders.php");
    exit();
}
?>