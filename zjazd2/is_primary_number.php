<?php
function isPrime($number) {
    if ($number <= 1) {
        return false;
    }
    $counter = 0; // Initialize counter
    for ($i = 2; $i <= sqrt($number); $i++) {
        $counter++; // Increment counter
        if ($number % $i == 0) {
            echo "<p>Loop iterations: $counter</p>"; // Echo counter
            return false;
        }
    }
    echo "<p>Loop iterations: $counter</p>"; // Echo counter
    return true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prime Number Checker</title>
</head>
<body>
    <form method="get" action="">
        <label for="number">Enter a number:</label>
        <input type="number" id="number" name="number" required>
        <input type="submit" value="Check">
    </form>

    <?php
    if (isset($_GET['number'])) {
        $number = intval($_GET['number']);
        if (isPrime($number)) {
            echo "<p>$number is a prime number.</p>";
        } else {
            echo "<p>$number is not a prime number.</p>";
        }
    } else {
        echo "<p>Please provide a number.</p>";
    }
    ?>
</body>
</html>