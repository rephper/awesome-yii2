<?php

$arr = ['a', 'b', 'c'];
foreach($arr as $k => $v) {
echo '$k = ' . $k . ' $v = ' . $v .PHP_EOL;
$v = &$arr[$k];

echo ' -------------- $k = ' . $k . ' $v = ' . $v  .PHP_EOL;
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
        echo '<br />--------------------<br />';
}

var_dump($arr);

?>
