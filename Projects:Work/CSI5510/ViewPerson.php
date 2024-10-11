<?php
// Replace the variables below with your actual database connection details
$hostname = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "csi5510"; // Your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all people, including their money, ordered by highest pay
$sql = "SELECT person_id, name, role, contact_details, money FROM People ORDER BY money DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Begin the table
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Role</th><th>Contact Details</th><th>Money</th></tr>";
    
    // Output the data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["person_id"] . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["contact_details"]) . "</td>";
        echo "<td>$" . number_format($row["money"], 2) . "</td>"; // Formatting money as currency
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
