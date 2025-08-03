<?php

namespace App\Models;


use DateTime;

class Role
{
    private int $roleId;
    private string $roleName;
    private DateTime $createdAt;
    private DateTime $updatedAt;


    public function __construct(int $roleId, string $roleName, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->roleId = $roleId;
        $this->roleName = $roleName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }


    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setRoleName(string $roleName): void
    {
        $this->roleName = $roleName;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
