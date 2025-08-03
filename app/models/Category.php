<?php

namespace App\Models;


use DateTime;

class Category
{
    private int $categoryId;
    private string $categoryName;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(int $categoryId, string $categoryName, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
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
