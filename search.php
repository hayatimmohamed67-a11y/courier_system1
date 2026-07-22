<a href="index.php">Home</a>
<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Package</title>
</head>
<body>

<h2>Search Package</h2>

<form method="POST">
    Enter Tracking ID:
    <input type="text" name="tracking_id" required>

    <button type="submit" name="search">
        Search
    </button>
</form>

<br>

<?php

if(isset($_POST['search']))
{
    $tracking = $_POST['tracking_id'];

    $sql = "SELECT * FROM package WHERE tracking_id='$tracking'";

    $result = mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($result))
    {
        echo "Sender Name: ".$row['sender_name']."<br>";
        echo "Receiver Name: ".$row['receiver_name']."<br>";
        echo "Phone: ".$row['phone']."<br>";
        echo "Destination: ".$row['destination']."<br>";
        echo "Tracking ID: ".$row['tracking_id']."<br>";
        echo "Status: ".$row['status']."<br>";
    }
}
?>

</body>
</html>