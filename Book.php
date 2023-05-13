<?php

class Book
{
    public int $id;
    public string $title;
    public array $authors = [];
    public ?int $grade;
    public ?bool $isRead;

    public function __construct(string $title, ?int $grade, ?bool $isRead)
    {
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $isRead;
    }

    public function addAuthor($author): void
    {
        $this->authors[] = $author;
    }
}