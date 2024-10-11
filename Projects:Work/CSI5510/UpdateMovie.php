<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $movie_id = $_POST['movie_id'];
    $title = $_POST['movie_title'];
    $synopsis = $_POST['movie_synopsis'];
    $release_date = $_POST['movie_release_date'];
    $length = $_POST['movie_length'];
    $category = $_POST['movie_category'];
    $rating = $_POST['movie_rating'];
    $amount = $_POST['movie_amount']; // Retrieve the amount from the form

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
    $sql = "UPDATE movies SET title=?, synopsis=?, release_date=?, length=?, category=?, rating=?, amount=? WHERE movie_id=?";
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters
    $stmt->bind_param("sssissdi", $title, $synopsis, $release_date, $length, $category, $rating, $amount, $movie_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Movie updated successfully.";
    } else {
        echo "Error updating movie: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: You must submit the form to update a movie.";
}
?>
