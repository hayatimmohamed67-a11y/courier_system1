<?php
include 'db.php';

if(isset($_POST['save']))
{
    $sender = $_POST['sender_name'];
    $receiver = $_POST['receiver_name'];
    $phone = $_POST['phone'];
    $destination = $_POST['destination'];
    $tracking = $_POST['tracking_id'];
    $status = $_POST['status'];

    $sql = "INSERT INTO package(sender_name,receiver_name,phone,destination,tracking_id,status)
    VALUES('$sender','$receiver','$phone','$destination','$tracking','$status')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Package</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

<div class="card shadow-lg p-4 rounded-4">

<h2 class="text-center text-success">
➕ Add Package
</h2>

<form method="POST">

<input type="text"
name="sender_name"
class="form-control mb-3"
placeholder="Sender Name" required>

<input type="text"
name="receiver_name"
class="form-control mb-3"
placeholder="Receiver Name" required>

<input type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone Number" required>

<input type="text"
name="destination"
class="form-control mb-3"
placeholder="Destination" required>

<input type="text"
name="tracking_id"
class="form-control mb-3"
placeholder="Tracking ID" required>

<select name="status"
class="form-control mb-3">

<option>Pending</option>
<option>In Transit</option>
<option>Delivered</option>

</select>

<button type="submit"
name="save"
class="btn btn-success w-100">

Save Package

</button>

<br><br>

<a href="index.php"
class="btn btn-dark w-100">

Back Home

</a>

</form>

</div>

</div>

</body>
</html>