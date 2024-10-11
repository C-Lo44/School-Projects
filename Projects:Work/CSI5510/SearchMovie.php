<?php
// Replace with your actual database details
$hostname = "localhost";
$username = "root"; // Replace with your actual database username
$password = "";     // Replace with your actual database password
$database = "csi5510"; // Replace with your actual database name

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['year'])) {
        // Search based on year, and also retrieve the amount (price)
        $year = $_POST['year'];
        $stmt = $conn->prepare("SELECT title, release_date, amount FROM movies WHERE YEAR(release_date) = :year ORDER BY release_date ASC");
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    } elseif (isset($_POST['price'])) {
        // Search based on amount (price)
        $price = $_POST['price'];
        $stmt = $conn->prepare("SELECT title, amount FROM movies WHERE amount <= :price ORDER BY amount ASC");
        $stmt->bindParam(':price', $price);
    } else {
        throw new Exception("Invalid form submission.");
    }
    
    // ... (The rest of your PHP script stays the same, just ensure you handle the amount when displaying results)
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "<ul>";
        foreach ($results as $movie) {
            echo "<li>" . htmlspecialchars($movie['title']) . " - Released on " . htmlspecialchars($movie['release_date']);
            if (isset($movie['amount'])) {
                echo " - $" . htmlspecialchars($movie['amount']);
            }
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No movies found for the given search criteria.</p>";
    }
}
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
