<?php


namespace App\Models;

use App\Config\Database;

use DateTime;
use PDO;
use Exception;

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
        try {
            $db = new Database();
            $connection = $db->getConnection();

            $stmt = $connection->prepare("SELECT * FROM user WHERE username = :username");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Sử dụng password_hash thay vì md5
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData && password_verify($password, $userData['password'])) {
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
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy người dùng: " . $e->getMessage());
        }
        return null;
    }

    public static function checkUsernameOrEmailExists(string $username, string $email): bool
    {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($userData);
    }

    public static function createUser(string $username, string $password, string $email, string $fullName, DateTime $dob, int $roleId): bool
    {
        try {
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare("INSERT INTO user (username, password, full_name, email ,dob, role_id) VALUES (:username, :password, :full_name, :email, :dob, :role_id)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Lưu ý: Nên dùng password_hash() thay vì md5
            $dobFormatted = $dob->format('Y-m-d');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dob', $dobFormatted);
            $stmt->bindParam(':role_id', $roleId);
            return $stmt->execute();
        } catch (\Exception $e) {
            throw new Exception("Lỗi khi tạo người dùng: " . $e->getMessage());
            // Xử lý lỗi nếu cần
            return false;
        }
    }
}
