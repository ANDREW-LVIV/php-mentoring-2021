<?php

# Object-Oriented PHP #7 - The "Final" Keyword
# https://www.codewars.com/kata/object-oriented-php-number-7-the-final-keyword

class Person
{
    const species = "Homo Sapiens";
    public $name, $age, $occupation;

    public function __construct($name, $age, $occupation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->occupation = $occupation;
    }

    public function introduce()
    {
        return "Hello, my name is $this->name";
    }

    final public function describe_job()
    {
        return "I am currently working as a(n) $this->occupation";
    }

    final public static function greet_extraterrestrials($species)
    {
        return "Welcome to Planet Earth $species!";
    }

}

class ComputerProgrammer extends Person
{
    public function introduce()
    {
        return "Hello, my name is $this->name and I am a $this->occupation";
    }
}