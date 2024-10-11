<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "csi5510";

// Create a connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to find all directors and producers linked to movies
$sql1 = "SELECT m.title, p.name, r.role_name 
         FROM movies_people mp
         JOIN movies m ON mp.movie_id = m.movie_id
         JOIN people p ON mp.person_id = p.person_id
         JOIN roles r ON mp.role_id = r.role_id
         WHERE r.role_name IN ('Director', 'Producer')";
$result1 = $conn->query($sql1);

// Query to find all directors and producers not linked to any movies
$sql2 = "SELECT p.name, p.role
         FROM people p
         LEFT JOIN movies_people mp ON p.person_id = mp.person_id
         WHERE mp.movie_id IS NULL AND p.role IN ('Director', 'Producer')";
$result2 = $conn->query($sql2);

// Display the first table
echo "<h2>Directors and Producers Linked to Movies:</h2>";
if ($result1->num_rows > 0) {
    echo "<table border='1'><tr><th>Title</th><th>Name</th><th>Role</th></tr>";
    while ($row = $result1->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["title"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["role_name"]) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No directors or producers are linked to any movies.";
}

echo "<br>";

// Display the second table
echo "<h2>Directors and Producers Not Linked to Any Movies:</h2>";
if ($result2->num_rows > 0) {
    echo "<table border='1'><tr><th>Name</th><th>Role</th></tr>";
    while ($row = $result2->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["role"]) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "All directors and producers are linked to movies.";
}

// Close the connection
$conn->close();
?>
