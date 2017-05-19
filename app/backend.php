<?php
header("content-type:application/json");

$data = [
    'username'    => 'dr',
    ['profile_pic' => ['profile_pic' => ['profile_pic' => 'image/dr.png']]],
    ['profile_pic' => ['profile_pic' => 'image/dr.png']]
];

echo json_encode($data);

exit();
