<?php

// Display menu

echo "<nav>
    <a href='main.php'>Main</a> |
    <a href='all_cars.php'>All cars</a> |
    <a href='add_car.php'>Add car</a>
</nav>";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    $conn = new mysqli("localhost", "root", "", "mojabaza");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO samochody (marka, model, cena, rok, opis) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $marka, $model, $cena, $rok, $opis);
    
    // Set parameters and execute
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $cena = $_POST['cena'];
    $rok = $_POST['rok'];
    $opis = $_POST['opis'];
    
    if ($stmt->execute()) {
        echo "<p class='success'>Nowy samochód został dodany pomyślnie!</p>";
    } else {
        echo "<p class='error'>Błąd: " . $stmt->error . "</p>";
    }
    
    $stmt->close();
    $conn->close();
}

// Display the form
?>

<h2>Dodaj nowy samochód</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="marka">Marka:</label>
        <br>
        <input type="text" name="marka" id="marka" required>
    </div>
    
    <div class="form-group">
        <label for="model">Model:</label>
        <br>
        <input type="text" name="model" id="model" required>
    </div>
    
    <div class="form-group">
        <label for="cena">Cena (zł):</label>
        <br>
        <input type="number" name="cena" id="cena" step="0.01" min="0" required>
    </div>
    
    <div class="form-group">
        <label for="rok">Rok produkcji:</label>
        <br>
        <input type="number" name="rok" id="rok" min="1900" max="2030" required>
    </div>
    
    <div class="form-group">
        <label for="opis">Opis:</label>
        <br>
        <textarea name="opis" id="opis" rows="4" cols="50"></textarea>
    </div>
    
    <div class="form-group">
        <input type="submit" value="Dodaj samochód">
    </div>
</form>