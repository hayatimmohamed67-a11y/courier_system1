<a href="index.php">Home</a>
<?php
include 'db.php';

$sql = "SELECT * FROM package";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Packages</title>
</head>
<body>

<h2>All Packages</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Sender</th>
        <th>Receiver</th>
        <th>Phone</th>
        <th>Destination</th>
        <th>Tracking ID</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php
    while($row = mysqli_fetch_assoc($result))
    {
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['sender_name']; ?></td>
        <td><?php echo $row['receiver_name']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['destination']; ?></td>
        <td><?php echo $row['tracking_id']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
<a href="delete.php?id=<?php echo $row['id']; ?>">
Delete
<br>
<a href="update.php?id=<?php echo $row['id']; ?>">
Update
</a>
</a>
</td>
    </tr>

    <?php
    }
    ?>

</table>

</body>
</html>