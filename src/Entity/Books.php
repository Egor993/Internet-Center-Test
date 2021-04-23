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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bookName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function setAuthor(?Authors $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(?string $bookName): self
    {
        $this->bookName = $bookName;

        return $this;
    }

    public function getBookDate(): ?string
    {
        return $this->bookDate;
    }

    public function setBookDate(?string $bookDate): self
    {
        $this->bookDate = $bookDate;

        return $this;
    }
}
