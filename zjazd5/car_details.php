<?php

// Display menu
echo "<nav>
    <a href='main.php'>Main</a> |
    <a href='all_cars.php'>All cars</a> |
    <a href='add_car.php'>Add car</a>
</nav>";

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid car ID.</p>";
    exit;
}

$car_id = $_GET['id'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "mojabaza");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the query with a parameter to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM samochody WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo "<p>Car not found.</p>";
    $stmt->close();
    $conn->close();
    exit;
}

// Get car data
$car = $result->fetch_assoc();

// Display car details
echo "<h2>Szczegóły samochodu</h2>";
echo "<div class='car-details'>";
echo "<p><strong>ID:</strong> " . $car['id'] . "</p>";
echo "<p><strong>Marka:</strong> " . $car['marka'] . "</p>";
echo "<p><strong>Model:</strong> " . $car['model'] . "</p>";
echo "<p><strong>Cena:</strong> " . $car['cena'] . " zł</p>";
echo "<p><strong>Rok:</strong> " . $car['rok'] . "</p>";
echo "<p><strong>Opis:</strong> " . $car['opis'] . "</p>";
echo "</div>";

echo "<p><a href='main.php'>Powrót do listy</a></p>";

// Close connections
$stmt->close();
$conn->close();

?>