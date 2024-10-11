<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $person_id = $_POST['person_id'];
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;

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

    // Prepare an update statement
    $sql = "UPDATE People SET name=?, role=?, contact_details=? WHERE person_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $role, $contact, $person_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Person updated successfully.";
        } else {
            echo "No changes made or person not found.";
        }
    } else {
        echo "Error updating person: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: You must submit the form to update a person.";
}
?>
