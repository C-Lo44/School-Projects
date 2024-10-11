<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = $_POST['movie_id'];
    $movie_title = $_POST['movie_title'];

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

    // SQL to fetch the movie to check if it exists before deletion
    $stmt = $conn->prepare("SELECT title FROM movies WHERE movie_id = ? AND title = ?");
    $stmt->bind_param("is", $movie_id, $movie_title);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // The movie exists, now we can prompt for confirmation or directly delete
        $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Movie deleted successfully.";
        } else {
            echo "Error deleting movie.";
        }
    } else {
        echo "Movie not found or title does not match.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Form has not been submitted, display an error or redirect
    echo "Error: You must submit the form to delete a movie.";
}
?>
