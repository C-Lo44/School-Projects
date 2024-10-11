<?php
// Replace the variables below with your actual database connection details
$hostname = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "csi5510"; // Your database name

// Check if the form data is set
if(isset($_POST['name']) && isset($_POST['role']) && isset($_POST['contact'])) {

    // Create a new database connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape the user input for security
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']);
    $contact = $conn->real_escape_string($_POST['contact']);

    // SQL query to insert the new person
    $sql = "INSERT INTO People (name, role, contact_details) VALUES ('$name', '$role', '$contact')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "New person added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "All fields are required.";
}
?>
