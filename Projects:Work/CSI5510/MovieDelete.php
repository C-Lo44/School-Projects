<?php
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $movie_id = $_GET['movie_id'];

    // Database connection variables
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "csi5510";

    // Create connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete the movie
    $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Movie deleted successfully.";
    } else {
        echo "Error deleting movie.";
    }
    $stmt->close();
    $conn->close();
}
?>
