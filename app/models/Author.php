<?php

namespace App\Models;

use DateTime;


class Author
{
    private int $authorId;
    private string $name;
    private DateTime $dob;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(int $authorId, string $name, DateTime $dob, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->authorId = $authorId;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->dob = $dob;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getDob(): DateTime
    {
        return $this->dob;
    }
}
