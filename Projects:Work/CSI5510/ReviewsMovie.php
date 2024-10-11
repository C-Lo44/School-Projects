<?php
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

// SQL query to select all reviews, ordering by rating in descending order, then by review date
$sql = "SELECT review_id, movie_id, user_id, rating, review_text, review_date FROM reviews ORDER BY rating DESC, review_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Begin the table
    echo "<table border='1'>";
    echo "<tr><th>Review ID</th><th>Movie ID</th><th>User ID</th><th>Rating</th><th>Review Text</th><th>Review Date</th></tr>";
    
    // Output the data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["review_id"] . "</td>";
        echo "<td>" . $row["movie_id"] . "</td>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["rating"] . "</td>";
        echo "<td>" . htmlspecialchars($row["review_text"]) . "</td>";
        echo "<td>" . $row["review_date"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
