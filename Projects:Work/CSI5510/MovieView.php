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

// SQL query to select all movies including the amount
$sql = "SELECT movie_id, title, release_date, synopsis, rating, length, category, amount FROM movies";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Begin the table
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Title</th><th>Release Date</th><th>Synopsis</th><th>Rating</th><th>Length (min)</th><th>Category</th><th>Amount</th></tr>";
    
    // Output the data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["movie_id"]. "</td>";
        echo "<td>" . htmlspecialchars($row["title"]). "</td>";
        echo "<td>" . $row["release_date"]. "</td>";
        echo "<td>" . htmlspecialchars($row["synopsis"]). "</td>";
        echo "<td>" . $row["rating"]. "</td>";
        echo "<td>" . $row["length"]. "</td>";
        echo "<td>" . htmlspecialchars($row["category"]). "</td>";
        echo "<td>" . number_format($row["amount"], 2). "</td>"; // Added amount field here, formatted as a number
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
