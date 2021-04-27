<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookName;

    /**
     * @ORM\Column(type="integer")
     */
    private $BookDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): void
    {
        $this->author = $author;

    }

    public function getBookName(): string
    {
        return $this->bookName;
    }

    public function setBookName(string $bookName): void
    {
        $this->bookName = $bookName;

    }

    public function getBookDate(): int
    {
        return $this->BookDate;
    }

    public function setBookDate(int $BookDate): void
    {
        $this->BookDate = $BookDate;

    }
}
