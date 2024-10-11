<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $person_id = $_POST['person_id'];
    $name = $_POST['name'];

    // Database connection variables
    $hostname = "localhost";
    $username = "root"; // Replace with your actual database username
    $password = "";     // Replace with your actual database password
    $database = "csi5510"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $sql = "DELETE FROM People WHERE person_id = ? AND name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $person_id, $name);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "Person deleted successfully.";
        } else {
            echo "No person found with the specified ID and Name.";
        }
    } else {
        echo "Error deleting person: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: You must submit the form to delete a person.";
}
?>
