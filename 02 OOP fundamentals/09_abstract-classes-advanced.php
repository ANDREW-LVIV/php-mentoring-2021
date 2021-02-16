<?php

# Object-Oriented PHP #9 - Abstract Classes [Advanced]
# https://www.codewars.com/kata/object-oriented-php-number-9-abstract-classes-advanced

abstract class Person
{
    public $name, $age, $gender;

    public function __construct($name, $age, $gender)
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    abstract public function introduce();

    public function greet($name)
    {
        return "Hello $name";
    }
}

final class Child extends Person
{
    public $name, $age, $gender, $aspirations;

    public function __construct($name, $age, $gender, $aspirations)
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
        $this->aspirations = $aspirations;
    }

    public function introduce()
    {
        return "Hi, I'm $this->name and I am $this->age years old";
    }

    public function greet($name)
    {
        return "Hi $name, let's play!";
    }

    public function say_dreams()
    {
        return "I would like to be a(n) " . say_list($this->aspirations) . " when I grow up.";
    }
}

class ComputerProgrammer extends Person
{
    public $occupation = "Computer Programmer";

    public function introduce()
    {
        return "Hello, my name is $this->name, I am $this->age years old and I am a(n) $this->occupation";
    }

    public function greet($name)
    {
        return "Hello $name, I'm $this->name, nice to meet you";
    }

    public function advertise()
    {
        return "Don't forget to check out my coding projects";
    }
}