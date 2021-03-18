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

    $number = $matches[1] ?: '-';
    $letter = $matches[2] ?: '-';

    if (1 <= $number && $number <= 20) {
        $row = 'Front';
    } elseif (21 <= $number && $number <= 40) {
        $row = 'Middle';
    } elseif (41 <= $number && $number <= 60) {
        $row = 'Back';
    } else {
        $row = false;
    }

    if (strpos('ABC', $letter) !== false) {
        $seat = 'Left';
    } elseif (strpos('DEF', $letter) !== false) {
        $seat = 'Middle';
    } elseif (strpos('GHK', $letter) !== false) {
        $seat = 'Right';
    } else {
        $seat = false;
    }

    return $row && $seat ? "$row-$seat" : "No Seat!!";
}

echo planeSeat("222D") . "\r\n"; // No Seat!!
echo planeSeat("22D") . "\r\n"; // Middle-Middle
echo planeSeat("5E") . "\r\n"; // Front-Middle
echo planeSeat("") . "\r\n"; // No Seat!!
echo planeSeat("1") . "\r\n"; // No Seat!!
echo planeSeat("D") . "\r\n"; // No Seat!!


