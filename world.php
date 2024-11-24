<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

if (isset($_GET['country'])) {
    $country = $_GET['country'];
    echo "Country parameter: " . htmlspecialchars($country) . "<br>";

    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>" . htmlspecialchars($row['name']) . " is ruled by " . htmlspecialchars($row['head_of_state']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No results found for '$country'.";
    }
} else {
    echo "No country parameter provided.";
}
?>
