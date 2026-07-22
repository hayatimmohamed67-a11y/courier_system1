<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Courier Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background:url('images/bg.jpg') no-repeat center center/cover;
}

.overlay{
    background:rgba(0,0,50,0.7);
    min-height:100vh;
}

.navbar{
    padding:20px;
}

.navbar-brand{
    color:white !important;
    font-size:28px;
    font-weight:bold;
}

.nav-link{
    color:white !important;
    margin-left:20px;
}

.hero{
    color:white;
    padding:100px 50px;
}

.hero h1{
    font-size:55px;
    font-weight:bold;
}

.hero p{
    font-size:20px;
}

.card-box{
    background:white;
    border-radius:20px;
    padding:30px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,.2);
    transition:.3s;
}

.card-box:hover{
    transform:translateY(-10px);
}

.icon{
    font-size:50px;
    margin-bottom:15px;
}

.footer{
    text-align:center;
    color:white;
    padding:20px;
}

</style>
</head>
<body>

<div class="overlay">

<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand" href="#">
🚚 Courier System
</a>

<div>
<a class="nav-link d-inline" href="index.php">Home</a>
<a class="nav-link d-inline" href="report.php">Report</a>
<a class="nav-link d-inline" href="logout.php">Logout</a>
</div>

</div>
</nav>

<div class="container hero">

<h1>Fast Courier Delivery Management</h1>

<p>
Manage your packages easily and track deliveries in real time.
</p>

<a href="add_package.php" class="btn btn-primary btn-lg">
Get Started
</a>

</div>

<div class="container pb-5">

<div class="row g-4">

<div class="col-md-3">
<div class="card-box">
<div class="icon">➕</div>
<h4>Add Package</h4>
<a href="add_package.php" class="btn btn-success w-100">Open</a>
</div>
</div>

<div class="col-md-3">
<div class="card-box">
<div class="icon">📦</div>
<h4>View Packages</h4>
<a href="view_package.php" class="btn btn-info w-100">Open</a>
</div>
</div>

<div class="col-md-3">
<div class="card-box">
<div class="icon">🔍</div>
<h4>Search Package</h4>
<a href="search.php" class="btn btn-warning w-100">Open</a>
</div>
</div>

<div class="col-md-3">
<div class="card-box">
<div class="icon">📄</div>
<h4>Project Report</h4>
<a href="report.php" class="btn btn-secondary w-100">Open</a>
</div>
</div>

</div>

</div>

<div class="footer">
© 2026 Local Courier Delivery Management System
</div>

</div>

</body>
</html>