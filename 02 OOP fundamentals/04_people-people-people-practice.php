<?php

# Object-Oriented PHP #4 - People, people, people (Practice)
# https://www.codewars.com/kata/5798bb604be912fb6700008c

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
        return "Hello, my name is " . $this->name;
    }

    public function describe_job()
    {
        return "I am currently working as a(n) " . $this->occupation;
    }

    public static function greet_extraterrestrials($species)
    {
        return "Welcome to Planet Earth {$species}!";
    }

}