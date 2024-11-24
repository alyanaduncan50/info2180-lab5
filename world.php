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

if (isset($_GET['country']) && isset($_GET['lookup'])) {
    $country = $_GET['country'];
    $lookupType = $_GET['lookup'];

    if ($lookupType === 'country') {
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
            echo "<thead>";
            echo "<tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
            echo "</thead><tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td>" . htmlspecialchars($row['independence_year']) . "</td>";
                echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No results found for '" . htmlspecialchars($country) . "'</p>";
        }
    } elseif ($lookupType === 'cities') {
        $stmt = $conn->prepare(
            "SELECT cities.name AS city_name, cities.district, cities.population 
             FROM cities 
             JOIN countries ON cities.country_code = countries.code 
             WHERE countries.name LIKE :country"
        );
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
            echo "<thead>";
            echo "<tr><th>City</th><th>District</th><th>Population</th></tr>";
            echo "</thead><tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No cities found for '" . htmlspecialchars($country) . "'</p>";
        }
    } else {
        echo "<p>Invalid lookup type.</p>";
    }
} else {
    echo "<p>Missing parameters. Please provide a country and a lookup type.</p>";
}
?>
