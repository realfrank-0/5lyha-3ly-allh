<?php
$conn = mysqli_connect("localhost", "root", "killuazoldyck", "webapp");

if (!$conn) {
    echo mysqli_connect_error();
    exit;
}
?>
<?php
$query="SELECT * FROM users";
$result =mysqli_query($conn,$query);
?>
<html>
    <head>
        <title>admin::list users</title>
    </head>
    <body>
        <h1>list users</h1>
        
        <table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= ($row['admin']) ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
    <tr>
    <td colspan="2" style="text-align: center">
        <?= mysqli_num_rows($result) ?> users
    </td>
    <td colspan="3" style="text-align: center">
        <a href="add.php">ADD users</a>
    </td>
    </tr>
</tfoot>

</ttable>
    </tbody>

</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>