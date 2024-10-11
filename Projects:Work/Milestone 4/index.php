<?php
$user = "milestone4";
$password = "Csi4160#";
$database = "csi4160";
$table = "pong_data";

try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    echo "<h2 style='text-align: center;'>Pong Data</h2><div style='margin: auto; width: 50%;'>"; // Center the heading

    // Fetch each column name once
    $stmt = $db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?");
    $stmt->execute([$database, $table]);
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Display column names as table headers
    echo "<table border='1' style='margin: auto;'>";
    echo "<tr>";
    foreach ($columns as $column) {
        echo "<th>$column</th>";
    }
    echo "</tr>";

    // Fetch and display data rows ordered by score (assuming "score" is the column name)
    $query = "SELECT * FROM $table ORDER BY score DESC"; // Order by score in descending order (highest to lowest)
    $stmt = $db->query($query);
    foreach ($stmt as $row) {
        echo "<tr>";
        // Display data for each column
        foreach ($columns as $column) {
            echo "<td style='text-align: center;'>{$row[$column]}</td>"; // Center align the cell contents
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

