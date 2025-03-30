<?php 

// Include function files
include 'add_function.php';
include 'substract_function.php';
include 'multiply_function.php';
include 'divide_function.php';

// Simple PHP calc using two numbers and an operator

$result = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['operator'])) {
    $num1 = $_GET['num1'];
    $num2 = $_GET['num2'];
    $operator = $_GET['operator'];
    
    switch($operator) {
        case '+':
            $result = add($num1, $num2);
            break;
        case '-':
            $result = substract($num1, $num2);
            break;
        case '*':
            $result = multiply($num1, $num2);
            break;
        case '/':
            $result = divide($num1, $num2);
            break;
        default:
            $result = "Invalid operator";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Calculator</title>
</head>
<body>
    <h2>Simple Calculator</h2>
    <form action="calc.php" method="GET">
        <input type="number" name="num1" placeholder="Enter first number" required>
        
        <select name="operator" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        
        <input type="number" name="num2" placeholder="Enter second number" required>
        
        <button type="submit">Calculate</button>
    </form>

    <p>Result: <?php echo $result; ?></p>

</body>
</html>