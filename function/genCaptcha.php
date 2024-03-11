<?php
$characters = array_merge((range("A", "Z")), range("a", "z"), range(0, 9));
$captchaSs = getCaptchar($characters, 6);
$_SESSION['captchaSs'] = $captchaSs;
function getCaptchar($characters, $length)
{
    $catchaSs = "";
    for ($i = 0; $i < $length - 1; $i++) {
        $catchaSs .= $characters[array_rand($characters, 1)];
    }
    return $catchaSs;
}

?>