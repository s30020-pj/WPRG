<?php

$beginnig = 1;
$end = 100;

for ($i = $beginnig; $i <= $end; $i++) {
    $isPrime = true;
    for ($j = 2; $j < $i; $j++) {
        if ($i % $j == 0) {
            $isPrime = false;
            break;
        }
    }
    if ($isPrime) {
        echo $i . "\n";
    }
}

?>