<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'users';


$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    

    $sql = "INSERT INTO items (name, description) VALUES ('$name', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "New item added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $sql = "DELETE FROM items WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Item removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Items</title>
</head>
<body>
    <h2>Add New Item</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Name: <input type="text" name="name"><br>
        Description: <textarea name="description"></textarea><br>
        <input type="submit" name="add" value="Add Item">
    </form>
    
    <h2>Items List</h2>
    <ul>
    <?php

$sql = "SELECT * FROM items";
$result = $conn->query($sql);

if ($result === false) {

    echo "Error executing query: " . $conn->error;
} else {
    // Check if any items were found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - {$row['description']} (<a href='?remove={$row['id']}'>Remove</a>)</li>";
        }
    } else {
        echo "0 items found";
    }
}

$conn->close();
?>

