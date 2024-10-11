<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace the variables below with your actual database connection details
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "csi5510";

    // Create a new database connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO movies (title, release_date, synopsis, rating, length, category, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiid", $title, $release_date, $synopsis, $rating, $length, $category, $amount);

    // Set parameters and execute
    $title = $_POST['title'];
    $release_date = $_POST['release_date'];
    $synopsis = $_POST['synopsis'];
    $rating = $_POST['rating'];
    $length = (int)$_POST['length'];
    $category = $_POST['category'];
    $amount = (float)str_replace(array('$', ','), '', $_POST['amount']); // Remove $ and commas, then convert to float

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
