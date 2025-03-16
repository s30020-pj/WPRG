<?php
$formSubmitted = false;
$personSelectSubmitted = false;
$formData = [];
$person_amount = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_person_amount'])) {
    $person_amount = $_POST['person_amount'];
    $personSelectSubmitted = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_reservation'])) {
    $formSubmitted = true;
    $person_amount = $_POST['person_amount'];
    
    $formData = [
        'person_amount' => $person_amount,
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'address' => $_POST['address'],
        'card_number' => $_POST['card_number'],
        'arrival' => $_POST['arrival'],
        'departure' => $_POST['departure'],
        'climate' => isset($_POST['climate']) ? "Yes" : "No",
        'breakfast' => isset($_POST['breakfast']) ? "Yes" : "No"
    ];
    
    $formData['additional_people'] = [];
    for ($i = 2; $i <= $person_amount; $i++) {
        if (isset($_POST["name_$i"]) && isset($_POST["surname_$i"])) {
            $formData['additional_people'][] = [
                'name' => $_POST["name_$i"],
                'surname' => $_POST["surname_$i"],
                'age' => $_POST["age_$i"]
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Reservation</title>
</head>
<body>
    <h2>Hotel Reservation Form</h2>
    
    <?php if (!$personSelectSubmitted && !$formSubmitted): ?>
    <form action="rezerwacja_3.php" method="post">
        <label for="person_amount">How many people will be staying?</label>
        <input type="number" id="person_amount" name="person_amount" min="1" max="4" value="1" required><br><br>
        
        <input type="submit" name="submit_person_amount" value="Continue">
    </form>
    
    <?php elseif ($personSelectSubmitted && !$formSubmitted): ?>
    <form action="rezerwacja_3.php" method="post">
        <input type="hidden" name="person_amount" value="<?php echo $person_amount; ?>">
        
        <h3>Main Guest Information</h3>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required><br><br>
        
        <?php for ($i = 2; $i <= $person_amount; $i++): ?>
        <div class="additional-person">
            <h3>Person <?php echo $i; ?> Information</h3>
            <label for="name_<?php echo $i; ?>">Name:</label>
            <input type="text" id="name_<?php echo $i; ?>" name="name_<?php echo $i; ?>" required><br><br>
            
            <label for="surname_<?php echo $i; ?>">Surname:</label>
            <input type="text" id="surname_<?php echo $i; ?>" name="surname_<?php echo $i; ?>" required><br><br>
            
            <label for="age_<?php echo $i; ?>">Age:</label>
            <input type="number" id="age_<?php echo $i; ?>" name="age_<?php echo $i; ?>" min="1" max="120" required><br><br>
        </div>
        <?php endfor; ?>
        
        <h3>Reservation Details</h3>
        <label for="arrival">Arrival:</label>
        <input type="date" id="arrival" name="arrival" required><br><br>
        
        <label for="departure">Departure:</label>
        <input type="date" id="departure" name="departure" required><br><br>
        
        <label for="climate">Air conditioning in room:</label>
        <input type="checkbox" id="climate" name="climate"><br><br>
        
        <label for="breakfast">Breakfast Needed:</label>
        <input type="checkbox" id="breakfast" name="breakfast"><br><br>
        
        <input type="submit" name="submit_reservation" value="Complete Reservation">
    </form>
    
    <?php else: ?>
        <h3>Reservation Details</h3>
        <table>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Person Amount</td><td><?php echo $formData['person_amount']; ?></td></tr>
            <tr><td colspan="2"><strong>Main Guest Information</strong></td></tr>
            <tr><td>Name</td><td><?php echo $formData['name']; ?></td></tr>
            <tr><td>Surname</td><td><?php echo $formData['surname']; ?></td></tr>
            <tr><td>Address</td><td><?php echo $formData['address']; ?></td></tr>
            <tr><td>Card Number</td><td><?php echo $formData['card_number']; ?></td></tr>
            
            <?php if (!empty($formData['additional_people'])): ?>
                <tr><td colspan="2"><strong>Additional Guests</strong></td></tr>
                <?php foreach ($formData['additional_people'] as $index => $person): ?>
                    <tr><td>Person <?php echo $index + 2; ?> Name</td><td><?php echo $person['name']; ?></td></tr>
                    <tr><td>Person <?php echo $index + 2; ?> Surname</td><td><?php echo $person['surname']; ?></td></tr>
                    <tr><td>Person <?php echo $index + 2; ?> Age</td><td><?php echo $person['age']; ?></td></tr>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <tr><td colspan="2"><strong>Stay Details</strong></td></tr>
            <tr><td>Arrival Date</td><td><?php echo $formData['arrival']; ?></td></tr>
            <tr><td>Departure Date</td><td><?php echo $formData['departure']; ?></td></tr>
            <tr><td>Air Conditioning</td><td><?php echo $formData['climate']; ?></td></tr>
            <tr><td>Breakfast</td><td><?php echo $formData['breakfast']; ?></td></tr>
        </table>
        
        <a href="rezerwacja_3.php">Make another reservation</a>
    <?php endif; ?>
</body>
</html>
