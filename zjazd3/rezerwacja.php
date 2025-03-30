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

    <form action="rezerwacja.php" method="get">
        <input type="hidden" name="view" value="1">
        <input type="submit" class="view-button" value="View All Reservations">
    </form>

<?php
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

        $csv_file = 'reservations.csv';
        $file_exists = file_exists($csv_file);
        
        $file = fopen($csv_file, 'a');
        
        if (!$file_exists) {
            $headers = "Person Amount,Name,Surname,Address,Card Number,Arrival Date,Departure Date,Air Conditioning,Breakfast\n";
            fwrite($file, $headers);
        }
        
        $data_line = "$person_amount,$name,$surname,$address,$card_number,$arrival,$departure,$climate,$breakfast\n";
        
        fwrite($file, $data_line);
        fclose($file);
        
        echo "<p>Reservation has been saved to the database.</p>";
    }

    if (isset($_GET['view']) && $_GET['view'] == 1) {
        $csv_file = 'reservations.csv';
        
        if (file_exists($csv_file)) {
            $file = fopen($csv_file, 'r');
            
            echo "<h3>All Reservations</h3>";
            echo "<table>";
            
            $header = fgetcsv($file, 0, ',');
            
            echo "<tr>";
            foreach ($header as $col) {
                echo "<th>" . htmlspecialchars($col) . "</th>";
            }
            echo "</tr>";
            
            while (($row = fgetcsv($file, 0, ',')) !== false) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
            fclose($file);
        } else {
            echo "<p>No reservations have been made yet.</p>";
        }
    }
?>

</body>
</html>
