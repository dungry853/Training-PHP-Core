<?php


namespace App\Models;

use App\Config\Database;

use DateTime;
use PDO;

class User
{
    private int $userId;
    private string $username;
    private string $password;
    private string $email;
    private string $fullName;
    private DateTime $dob;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private Role $role;

    public function __construct(
        int $userId,
        string $username,
        string $password,
        string $email,
        string $fullName,
        DateTime $dob,
        DateTime $createdAt,
        DateTime $updatedAt,
        Role $role
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->dob = $dob;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->role = $role;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getFullName(): string
    {
        return $this->fullName;
    }
    public function getDob(): DateTime
    {
        return $this->dob;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }
    public function setDob(DateTime $dob): void
    {
        $this->dob = $dob;
    }
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    public function getRole(): Role
    {
        return $this->role;
    }
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }


    public static function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        $db = new Database();
        $connection = $db->getConnection();

        $stmt = $connection->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Giả sử mật khẩu được mã hóa bằng md5
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(
                $userData['user_id'],
                $userData['username'],
                $userData['password'],
                $userData['email'],
                $userData['full_name'],
                new DateTime($userData['dob']),
                new DateTime($userData['created_at']),
                new DateTime($userData['updated_at']),
                new Role($userData['role_id'], '', new DateTime(), new DateTime())
            );
        }

        return null;
    }
}
