<?php

$list = array("jablko","banan","pomarancza");

foreach ($list as $fruit) {

		$length = strlen($fruit);

		if($fruit[0] == "p"){
            echo "Owoc zaczynajacy sie na p:\n";
        }

		for ($x = $length - 1; $x >= 0; $x--){
			echo $fruit[$x];
			echo "\n";
		}
		
		echo "\n";
}

?>