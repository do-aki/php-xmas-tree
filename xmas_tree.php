<?php

function pack_u($c) {
  $utf8 = array('C*');

  if ($c < 0x7f) {
    $utf8[] = $c;
  } elseif ($c <= 0x7ff) {
    $utf8[] = 0xc0 | ($c >> 6);
    $utf8[] = 0x80 | ($c & 0x3f);
  } elseif ($c < 0xffff) {
    $utf8[] = 0xe0 | ($c >> 12);
    $utf8[] = 0x80 | (($c >> 6) & 0x3f);
    $utf8[] = 0x80 | ($c & 0x3f);
  } else {
    die("no implemented");
  }

  return call_user_func_array('pack', $utf8);
}


function tree($H) {

    $s = ' ' . pack_u(0x2605);
    $f = pack_u(0xFF0F);
    $b = pack_u(0xFF3C);
    $o = array_map('pack_u', array(
        0x0069, 0x0020, 0x0020, 0x0020, 0x0020, 0x0020,
        0x0020, 0x0020, 0x0020, 0x0020, 0x0020, 0x0020,
        0x0020, 0x2E1B, 0x2042, 0x2E2E, 0x0026, 0x0040, 0xFF61,
    ));
    $oc = array( 31, 33, 34, 35, 36, 37 );
    $l  = pack_u(0x005e);

    echo "\n";
    echo str_repeat(" ", $H);
    echo "\033[33m" . $s . "\n";
    $M = $H * 2 - 1;
    for ($L=1; $L <= $H; ++$L) {
        $O = $L * 2 - 2;
        $S = ($M - $O) / 2 + 1;
        echo str_repeat(" ", $S);
        echo "\033[32m" . $f;
        for ($i=1; $i<=$O; ++$i) {
            echo "\033[" . $oc[array_rand($oc)] . "m" . $o[array_rand($o)];
        }
        echo "\033[32m" . $b . "\n";
    }
    echo " ";
    for ($i=1; $i<=$H-1; ++$i) {
      echo "\033[32m" . $l;
    } 
    echo "|  |";
    for ($i=1; $i<=$H-1; ++$i) {
      echo "\033[32m" . $l;
    }
    if ($H > 10) {
        echo "\n ";
        for ($i=1; $i<=$H-1; ++$i) {
            echo " ";
        }
        echo "|  |";
        for ($i=1; $i<=$H-1; ++$i) {
            echo " ";
        }
    }
    echo "\n\n";
}

$size = 20;
if (isset($argv[1]) && 0 < $argv[1]) {
  $size = $argv[1];
}

$time = 0;
if (isset($argv[2]) && 0 < $argv[2]) {
  $time = $argv[2];
}

if (0 < $time) {
  system('clear');
  tree($size);
  while (0 < --$time) {
    sleep(1);
    system('clear');
    tree($size);
  }
} else {
  tree($size);
}

