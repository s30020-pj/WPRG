<?php
session_start();

$valid_username = "admin";
$valid_password = "password123";

if(isset($_GET['clear_cookies'])) {
    foreach($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/');
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if(isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        setcookie("username", $username, time() + (86400 * 30), "/");
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Invalid username or password";
    }
}

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if(isset($_POST['submit_reservation'])) {
    $fields = ['person_amount', 'name', 'surname', 'address', 'card_number', 'arrival', 'departure'];
    
    foreach($fields as $field) {
        if(isset($_POST[$field])) {
            setcookie("form_".$field, $_POST[$field], time() + (86400 * 30), "/");
        }
    }
    
    setcookie("form_climate", isset($_POST['climate']) ? "checked" : "", time() + (86400 * 30), "/");
    setcookie("form_breakfast", isset($_POST['breakfast']) ? "checked" : "", time() + (86400 * 30), "/");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Reservation</title>
</head>
<body>

<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <div>
        Welcome, <?php echo htmlspecialchars($_COOKIE['username'] ?? 'Guest'); ?> | 
        <a href="?logout=1">Logout</a>
    </div>

    <h2>Hotel Reservation Form</h2>
    <form action="rezerwacja.php" method="post">
        <label for="person_amount">Person Amount:</label>
        <input type="number" id="person_amount" name="person_amount" min="1" max="4" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_person_amount'] ?? ''); ?>"><br><br>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_name'] ?? ''); ?>"><br><br>
        
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_surname'] ?? ''); ?>"><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_address'] ?? ''); ?>"><br><br>
        
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_card_number'] ?? ''); ?>"><br><br>
        
        <label for="arrival">Arrival:</label>
        <input type="date" id="arrival" name="arrival" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_arrival'] ?? ''); ?>"><br><br>
        
        <label for="departure">Departure:</label>
        <input type="date" id="departure" name="departure" required 
               value="<?php echo htmlspecialchars($_COOKIE['form_departure'] ?? ''); ?>"><br><br>
        
        <label for="climate">Air conditioning in room:</label>
        <input type="checkbox" id="climate" name="climate" 
               <?php echo (isset($_COOKIE['form_climate']) && $_COOKIE['form_climate'] === 'checked') ? 'checked' : ''; ?>><br><br>
        
        <label for="breakfast">Breakfast Needed:</label>
        <input type="checkbox" id="breakfast" name="breakfast" 
               <?php echo (isset($_COOKIE['form_breakfast']) && $_COOKIE['form_breakfast'] === 'checked') ? 'checked' : ''; ?>><br><br>
        
        <input type="submit" name="submit_reservation" value="Submit">
    </form>

    <form action="rezerwacja.php" method="get">
        <input type="hidden" name="view" value="1">
        <input type="submit" class="view-button" value="View All Reservations">
    </form>
    
    <form action="rezerwacja.php" method="get">
        <input type="hidden" name="clear_cookies" value="1">
        <button type="submit" class="clear-cookies">Clear All Cookies</button>
    </form>

<?php else: ?>
    <div>
        <h2>Login Required</h2>
        <p>You need to be logged in to make a reservation.</p>
        
        <?php if(isset($login_error)): ?>
            <p><?php echo $login_error; ?></p>
        <?php endif; ?>
        
        <form method="post" action="">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div style="margin-top: 10px;">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div style="margin-top: 15px;">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
    if (isset($_POST['submit_reservation'])) {
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

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_GET['view']) && $_GET['view'] == 1) {
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
