<?php
function generateCode($input) {
    $words = explode(' ', $input);
    
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    
    $datePart = date('dmy');
    $randomNumbers = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    
    $result = $initials . '/' . $datePart . '-' . $randomNumbers;
    
    return $result;
}

// Example usage:
$inputWord = "Hello World";
$generatedCode = generateCode($inputWord);

echo "Generated Code: $generatedCode";
?>
