<?php

namespace App\Models;


use DateTime;


class Book
{
    private int $bookId;
    private string $name;
    private string $description;
    private string $thumbnail;
    private float $price;
    private int $quantity;
    private DateTime $releaseDate;
    private Author $author;
    private Category $category;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    function __construct(
        int $bookId,
        string $name,
        string $description,
        string $thumbnail,
        float $price,
        int $quantity,
        DateTime $releaseDate,
        Author $author,
        Category $category,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->bookId = $bookId;
        $this->name = $name;
        $this->description = $description;
        $this->thumbnail = $thumbnail;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->releaseDate = $releaseDate;
        $this->author = $author;
        $this->category = $category;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getReleaseDate(): DateTime
    {
        return $this->releaseDate;
    }
    public function getAuthor(): Author
    {
        return $this->author;
    }
    public function getCategory(): Category
    {
        return $this->category;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
