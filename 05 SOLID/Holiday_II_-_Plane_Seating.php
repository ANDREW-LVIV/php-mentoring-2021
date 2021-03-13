<?php

# Holiday II - Plane Seating
# Finding your seat on a plane is never fun, particularly for a long haul flight...
# You arrive, realise again just how little leg room you get, and sort of climb into the seat covered in a pile of your own stuff.
# To help confuse matters (although they claim in an effort to do the opposite) many airlines omit the letters 'I' and 'J' from their seat naming system.
# The naming system consists of a number (in this case between 1-60) that denotes the section of the plane where the seat is (1-20 = front, 21-40 = middle, 40+ = back). This number is followed by a letter, A-K with the exclusions mentioned above.
# Letters A-C denote seats on the left cluster, D-F the middle and G-K the right.
# Given a seat number, your task is to return the seat location in the following format:
# '2B' would return 'Front-Left'.
# If the number is over 60, or the letter is not valid, return 'No Seat!!'.
# https://www.codewars.com/kata/57e8f757085f7c7d6300009a


function planeSeat($a) {
    preg_match("#(\d*)(.*)#", $a, $matches);

    $value_1 = $matches[1] ?: '-';
    $value_2 = $matches[2] ?: '-';

    if (1 <= $value_1 && $value_1 <= 20) {
        $part_1 = 'Front';
    } elseif (21 <= $value_1 && $value_1 <= 40) {
        $part_1 = 'Middle';
    } elseif (41 <= $value_1 && $value_1 <= 60) {
        $part_1 = 'Back';
    } else {
        $part_1 = false;
    }

    if (strpos('ABC', $value_2) !== false) {
        $part_2 = 'Left';
    } elseif (strpos('DEF', $value_2) !== false) {
        $part_2 = 'Middle';
    } elseif (strpos('GHK', $value_2) !== false) {
        $part_2 = 'Right';
    } else {
        $part_2 = false;
    }

    return $part_1 && $part_2 ? "$part_1-$part_2" : "No Seat!!";
}

echo planeSeat("222D") . "\r\n"; // No Seat!!
echo planeSeat("22D") . "\r\n"; // Middle-Middle
echo planeSeat("5E") . "\r\n"; // Front-Middle
echo planeSeat("") . "\r\n"; // No Seat!!
echo planeSeat("1") . "\r\n"; // No Seat!!
echo planeSeat("D") . "\r\n"; // No Seat!!


