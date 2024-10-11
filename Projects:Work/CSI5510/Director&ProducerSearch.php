<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["searchName"])) {
    $searchName = $_POST["searchName"];

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

    // SQL to find director or producer by name
    $sql = "SELECT m.title, p.name, r.role_name
            FROM movies_people mp
            JOIN movies m ON mp.movie_id = m.movie_id
            JOIN people p ON mp.person_id = p.person_id
            JOIN roles r ON mp.role_id = r.role_id
            WHERE p.name LIKE ? AND r.role_name IN ('Director', 'Producer')";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchName . "%";
    $stmt->bind_param("s", $searchTerm);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check results and display
    echo "<h2>Results:</h2>";
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>Title</th><th>Name</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["title"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["role_name"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<a href="search.html">Back to Search</a>
