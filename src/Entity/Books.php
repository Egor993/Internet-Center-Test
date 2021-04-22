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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $authorSurname;

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

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorSurname(): ?string
    {
        return $this->authorSurname;
    }

    public function setAuthorSurname(?string $authorSurname): self
    {
        $this->authorSurname = $authorSurname;

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
