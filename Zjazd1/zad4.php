<?php

$text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

$table = explode(" ", $text);

for ($i = 0; $i < count($table); $i++) {
    if (str_contains($table[$i], ".") || str_contains($table[$i], ",")) {
        for ($j = $i; $j < count($table) - 1; $j++) {
            $table[$j] = $table[$j + 1];
        }
        array_pop($table);
        $i--;
    }
}

$assocArray = [];
foreach ($table as $index => $value) {
    if ($index % 2 == 0 && isset($table[$index + 1])) {
        $assocArray[$value] = $table[$index + 1];
    }
}

foreach ($assocArray as $key => $val) {
    echo "$key => $val\n";
}

?>