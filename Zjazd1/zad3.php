<?php 

function fibonacci($n) {
    $fib = array();
    $fib[0] = 0;
    $fib[1] = 1;
    for ($i = 2; $i < $n; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
    }
    return $fib;
}

$x = 1;

foreach (fibonacci(100) as $number) {
    
    if ($number % 2 != 0) {
        echo $x . ". " . $number . "\n";
        $x++;
    }

    
}

?>