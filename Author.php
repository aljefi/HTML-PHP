<?php

class Author
{

    public int $id;
    public string $firstName;
    public string $lastName;
    public ?int $grade;

    public function __construct($firstName, $lastName, ?int $grade)
    {
        $this->firstName = $firstName ?? '';
        $this->lastName = $lastName ?? '';
        $this->grade = $grade;
    }

}
