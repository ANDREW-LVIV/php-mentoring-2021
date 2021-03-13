<?php

# Holiday V - SeaSick Snorkelling
# Thanks to the effects of El Nino this year my holiday snorkelling trip was akin to being in a washing machine... Not fun at all.
# Given a string made up of '~' and '_' representing waves and calm respectively, your job is to check whether a person would become seasick.
# Remember, only the process of change from wave to calm will add to the effect (really wave peak to trough but this will do). Find out how many changes in level the string has and if that figure is more than 20% of the array, return "Throw Up", if less, return "No Problem".
# https://www.codewars.com/kata/57e90bcc97a0592126000064

function sea_sick(string $s): string {
    $arr = str_split($s);
    $count = count($arr);
    $change = 0;
    $previous_value = null;

    foreach ($arr as $item) {
        if ($previous_value and $item !== $previous_value) {
            $change++;
        }
        $previous_value = $item;
    }

    return $change / $count * 100 <= 20 ? 'No Problem' : 'Throw Up';
}

echo sea_sick("~____~") . "\r\n";
echo sea_sick("~______________________~") . "\r\n";
echo sea_sick("_") . "\r\n";
echo sea_sick("_~~~~~~~_~__~______~~__~~_~~") . "\r\n";
echo sea_sick("______~___~_") . "\r\n";