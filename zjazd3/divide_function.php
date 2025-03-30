<?php

function divide($num1, $num2) {
    
    if ($num2 == 0) {
        return "Division by zero error";
    }

    return $num1 / $num2;
}

?>