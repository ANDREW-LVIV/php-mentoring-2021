<?php

# Object-Oriented PHP #5 - Classical Inheritance
# https://www.codewars.com/kata/object-oriented-php-number-5-classical-inheritance

class Salesman extends Person
{
    public function __construct($name, $age)
    {
        parent::__construct($name, $age, "Salesman");
    }

    public function introduce()
    {
        return "Hello, my name is $this->name, don't forget to check out my products!";
    }
}

class ComputerProgrammer extends Person
{
    public function __construct($name, $age)
    {
        parent::__construct($name, $age, "Computer Programmer");
    }

    public function describe_job()
    {
        return parent::describe_job() . ", don't forget to check out my Codewars account ;)";
    }
}

class WebDeveloper extends ComputerProgrammer
{
    public function __construct($name, $age)
    {
        Person::__construct($name, $age, "Web Developer");
    }

    public function describe_job()
    {
        return Person::describe_job() . ", don't forget to check out my Codewars account ;) And don't forget to check on my website :D";
    }

    public function describe_website()
    {
        return "My professional world-class website is made from HTML, CSS, Javascript and PHP!";
    }
}
