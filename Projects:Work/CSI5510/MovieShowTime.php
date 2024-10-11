<?php
$hostname = "localhost";
$username = "root";
$password = ""; // Update to use the correct database password
$database = "csi5510";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT m.movie_id, m.title, ms.Showtime, t.TheaterName FROM MovieShowtimes ms INNER JOIN Movies m ON ms.MovieID = m.movie_id INNER JOIN Theaters t ON ms.TheaterID = t.TheaterID ORDER BY ms.ShowtimeID");
    $stmt->execute();
    $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Showtimes</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* This is a clean, web-safe font */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Use vh (viewport height) units to ensure it takes the full window height */
        }

        table {
            width: 80%; /* Adjust the width as necessary */
            margin-top: 50px; /* Add some top margin */
            font-size: 1.25em; /* Increase the font size */
            border-collapse: collapse; /* Optional: removes the double border between cells */
        }

        th, td {
            padding: 10px; /* Add some padding for a better visual appearance */
            border: 1px solid #ddd; /* Add a border to each cell */
        }

        th {
            background-color: #f2f2f2; /* A light grey background for the header cells */
        }

        h1 {
            text-align: center;
            margin-top: 50px; /* Provide some space above the title */
        }
.container {
        width: 80%; /* Adjust the width as necessary */
        margin: 0 auto; /* Center the container */
        margin-top: 50px; /* Add some top margin for each section */
    }

    /* ... other styles ... */

    #coming-soon {
        padding: 15px;
        background-color: #f9f9f9; /* Light background for the section */
        border: 1px solid #ddd; /* Border to match the table */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    #coming-soon p {
        font-size: 1em; /* Match the font size of the table */
        margin: 10px 0; /* Add some space between the title and release date */
    }
	
    </style>
</head>
<body>
    <h1>Movie Showtimes</h1>
    <table>
        <thead>
            <tr>
                <th>Movie ID</th>
                <th>Title</th>
                <th>Showtime</th>
                <th>Theater</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($showtimes as $showtime): ?>
                <tr>
                    <td><?= htmlspecialchars($showtime['movie_id']) ?></td>
                    <td><?= htmlspecialchars($showtime['title']) ?></td>
                    <td><?= htmlspecialchars($showtime['Showtime']) ?></td>
                    <td><?= htmlspecialchars($showtime['TheaterName']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Coming Soon to Theaters section -->
    <h2>Coming Soon to Theaters</h2>
    <div id="coming-soon">
        <p><strong>Movie Title:</strong> The Next Big Hit</p>
        <p><strong>Release Date:</strong> July 4, 2024</p>
    </div>

</body>
</html>
