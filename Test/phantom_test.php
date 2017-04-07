<?php 

$pathToPhatomJs = '/Users/colinstarger/Desktop/Coding/Phantom/phantomjs-2.1.1-macosx/bin/phantomjs';

$pathToJsScript = '/Users/colinstarger/Desktop/Coding/Phantom/phantomjs-2.1.1-macosx/colin_test1.js';

$stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);

echo $stdOut."\n";
trim($stdOut);

$x = stripos($stdOut, ' for ');
$DOD_3d = substr($stdOut, 0, $x+1);
echo "DOD 3d = $DOD_3d"."\n";

$x = stripos($stdOut, ' cases of ');
$x += 10;
$num = substr($stdOut, $x, (strlen($stdOut)-x));
echo "Num 3d cases = $num"."\n";

$pathToJsScript = '/Users/colinstarger/Desktop/Coding/Phantom/phantomjs-2.1.1-macosx/colin_test2.js';
$stdOut2 = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);

echo $stdOut2."\n";
trim($stdOut2);

$x = stripos($stdOut2, ' for ');
$DOD_2d = substr($stdOut2, 0, $x+1);
echo "DOD 3d = $DOD_2d"."\n";

$x = stripos($stdOut2, ' cases of ');
$x += 10;
$num = substr($stdOut2, $x, (strlen($stdOut2)-x));
echo "Num 2d cases = $num"."\n";


?>