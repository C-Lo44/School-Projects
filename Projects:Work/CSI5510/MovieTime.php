<?php
$hostname = "localhost";
$username = "root";
$password = ""; // Update to use the correct database password
$database = "csi5510";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $showtime = $_POST['showtime'];
    $theater = $_POST['theater'];

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE MovieShowtimes SET Showtime = :showtime, TheaterID = 
        (SELECT TheaterID FROM Theaters WHERE TheaterName = :theater) WHERE MovieID = :movie_id");

        // Bind parameters
        $stmt->bindParam(':movie_id', $movie_id);
        $stmt->bindParam(':showtime', $showtime);
        $stmt->bindParam(':theater', $theater);

        // Execute the query
        $stmt->execute();

        echo "Showtime updated successfully.";

    } catch (PDOException $e) {
        die("Error updating the database: " . $e->getMessage());
    }
}
?>
