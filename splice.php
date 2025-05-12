<?php 

$text = "1*Gaelle*12*99*27";
$exploded = explode("*", $text);
print_r($exploded);
echo "\n";

// Find the index of "99"
$index = array_search("99", $exploded);

// If "99" is found, slice the array from that index onwards
if ($index !== false) {
    $exploded = array_slice($exploded, $index+1);  // Slice from "99" onwards
}

print_r($exploded);
?>
