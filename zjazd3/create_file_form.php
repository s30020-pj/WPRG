<?php
// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $field1 = $_POST['field1'] ?? '';
    $field2 = $_POST['field2'] ?? '';
    
    // Validate inputs
    if (empty($field1) || empty($field2)) {
        $message = "Please fill out both fields.";
    } else {
        // Format data to be saved
        $data = $field1 . ", " . $field2 . PHP_EOL;
        
        // Define file path
        $file_path = "form_data.txt";
        
        // Attempt to write to file
        if (file_put_contents($file_path, $data, FILE_APPEND | LOCK_EX) !== false) {
            $message = "Data successfully saved to file.";
        } else {
            $message = "Error: Unable to save data to file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Data to File</title>
</head>
<body>
    <h2>Save Data to File</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="field1">Field 1:</label>
            <input type="text" id="field1" name="field1" required>
        </div>
        
        <div class="form-group">
            <label for="field2">Field 2:</label>
            <input type="text" id="field2" name="field2" required>
        </div>
        
        <input type="submit" value="Save to File">
    </form>
</body>
</html>