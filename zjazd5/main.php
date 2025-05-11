<?php

// Display menu

echo "<nav>
    <a href='main.php'>Main</a> |
    <a href='all_cars.php'>All cars</a> |
    <a href='add_car.php'>Add car</a>
</nav>";

// Connect to database

$conn = new mysqli("localhost", "root", "", "mojabaza");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM samochody ORDER BY cena ASC LIMIT 5");

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Display the results in a table
echo "<h2>Lista samochodów</h2>";
echo "<table border='1'>
<tr>
    <th>ID</th>
    <th>Marka</th>
    <th>Model</th>
    <th>Cena</th>
</tr>";

// Fetch and display each row
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='car_details.php?id=" . $row['id'] . "'>" . $row['id'] . "</a></td>";
    echo "<td>" . $row['marka'] . "</td>";
    echo "<td>" . $row['model'] . "</td>";
    echo "<td>" . $row['cena'] . " zł</td>";
    echo "</tr>";
}

echo "</table>";

// Close the connection
$conn->close();

?>