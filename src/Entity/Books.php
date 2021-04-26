<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Authors::class, inversedBy="Books")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $bookName;

    /**
     * @ORM\Column(type="integer", length=255, nullable=false)
     */
    private $bookDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?Authors
    {
        return $this->author;
    }

    public function setAuthor(?Authors $author): void
    {
        $this->author = $author;

    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(?string $bookName): void
    {
        $this->bookName = $bookName;

    }

    public function getBookDate(): ?int
    {
        return $this->bookDate;
    }

    public function setBookDate(?int $bookDate): void
    {
        $this->bookDate = $bookDate;

    }
}
