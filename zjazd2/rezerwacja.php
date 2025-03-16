<!DOCTYPE html>
<html>
<head>
    <title>Hotel Reservation</title>
</head>
<body>
    <h2>Hotel Reservation Form</h2>
    <form action="rezerwacja.php" method="post">
        <label for="person_amount">Person Amount:</label>
        <input type="number" id="person_amount" name="person_amount" min="1" max="4" required><br><br>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required><br><br>
        
        <label for="arrival">Arrival:</label>
        <input type="date" id="arrival" name="arrival" required><br><br>
        
        <label for="departure">Departure:</label>
        <input type="date" id="departure" name="departure" required><br><br>
        
        <label for="climate">Air conditioning in room:</label>
        <input type="checkbox" id="climate" name="climate"><br><br>
        
        <label for="breakfast">Breakfast Needed:</label>
        <input type="checkbox" id="breakfast" name="breakfast"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>

<?php
    // Simple PHP reservation system for hotel using form with data and html display of this data
    // Form: Person amount, Name, Surname, Adress, Card Number, Arrival, Departure, Climate needed, Breakfast needed
    // Display: Table showing sended data

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $person_amount = $_POST['person_amount'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $address = $_POST['address'];
        $card_number = $_POST['card_number'];
        $arrival = $_POST['arrival'];
        $departure = $_POST['departure'];
        $climate = isset($_POST['climate']) ? "Yes" : "No";
        $breakfast = isset($_POST['breakfast']) ? "Yes" : "No";
        
        // Display the submitted data in a table
        echo "<h3>Reservation Details</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>Person Amount</td><td>$person_amount</td></tr>";
        echo "<tr><td>Name</td><td>$name</td></tr>";
        echo "<tr><td>Surname</td><td>$surname</td></tr>";
        echo "<tr><td>Address</td><td>$address</td></tr>";
        echo "<tr><td>Card Number</td><td>$card_number</td></tr>";
        echo "<tr><td>Arrival Date</td><td>$arrival</td></tr>";
        echo "<tr><td>Departure Date</td><td>$departure</td></tr>";
        echo "<tr><td>Air Conditioning</td><td>$climate</td></tr>";
        echo "<tr><td>Breakfast</td><td>$breakfast</td></tr>";
        echo "</table>";
    }
    ?>
</body>
</html>
