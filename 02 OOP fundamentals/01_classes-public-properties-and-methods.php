<?php
# Object-Oriented PHP #1 - Classes, Public Properties and Methods
# https://www.codewars.com/kata/object-oriented-php-number-1-classes-public-properties-and-methods

class President
{
    public $name = "Barack Obama";

    public function greet($name)
    {
        return "Hello {$name}, my name is Barack Obama, nice to meet you!";
    }
}

$us_president = new President();
$president_name = $us_president->name;
$greetings_from_president = $us_president->greet("Donald");