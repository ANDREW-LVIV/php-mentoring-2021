<?php

# Left Rotation
# https://www.hackerrank.com/challenges/array-left-rotation/problem

// Solution #1
// Implementation of Left Rotation using build in php functions
function leftRotation($arr, $n) {
  $rotate = 0;
  while($n != $rotate){
    $arr[] = array_shift($arr);
    $rotate++;
  }

  return $arr;
}
////////////

// Solution #2
// Implementation of Left Rotation using raw approach
function leftRotationByOne(&$arr) {
  for ($i = 0; $i < count($arr) - 1; $i++) {
    $new_arr[$i] = $arr[$i + 1];
  }
  $new_arr[] = $arr[0];
  $arr = $new_arr;
}

function leftRotationRaw($arr, $n) {
  for ($i = 0; $i < $n; $i++) {
    leftRotationByOne($arr);
  }

  return $arr;
}
////////////

$arr = [1, 2, 3, 4, 5]; // input array
$d = 3; // number of rotations
print_r(leftRotation($arr, $d)); // output using build in php functions
print_r(leftRotationRaw($arr, $d)); // output using raw approach
