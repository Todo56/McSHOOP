<?php
$text = "";
$keys = array_keys($_POST);
$values = array_values($_POST);
for($i = 0; $i < count($_POST); $i++){
$text .= $keys[$i] . " " . $values[$i] . "\n";
}

file_put_contents("../../log.txt", $text);
