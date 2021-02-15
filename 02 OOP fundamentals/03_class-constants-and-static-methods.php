<?php

# Object-Oriented PHP #3 - Class Constants and Static Methods
# https://www.codewars.com/kata/object-oriented-php-number-3-class-constants-and-static-methods

class CurrentUSPresident
{
    const name = "Barack Obama";

    public static function greet($name)
    {
        return "Hello {$name}, my name is Barack Obama, nice to meet you!";
    }
}
