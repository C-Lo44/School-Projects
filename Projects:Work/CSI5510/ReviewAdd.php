<?php
// Replace the variables below with your actual database connection details
$hostname = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "csi5510"; // Your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the SQL statement for insertion
    $stmt = $conn->prepare("INSERT INTO reviews (movie_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)");
    
    // Bind the parameters from the form data
    $movie_id = $_POST['movie_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating']; // Rating can now be a decimal value
    $review_text = $_POST['review_text'];
    
    // Double-check that rating is indeed a decimal or float
    $rating = floatval($rating);
    
    // Bind and execute
    $stmt->bind_param("iids", $movie_id, $user_id, $rating, $review_text);
    if ($stmt->execute()) {
        echo "Review added successfully.";
    } else {
        echo "Error adding review: " . $stmt->error;
    }
    
    // Close the statement and connection
    $stmt->close();
} else {
    echo "No data submitted.";
}

$conn->close();
?>
