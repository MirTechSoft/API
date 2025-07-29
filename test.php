<?php
$url = 'http://localhost:8000/students.php';
$data = file_get_contents('data.json');

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data,
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo $result;
?>
