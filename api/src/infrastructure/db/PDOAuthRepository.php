<?php

namespace nrv\infrastructure\db;


use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\domain\entities\user\User;
use Ramsey\Uuid\Uuid;

class PDOAuthRepository implements AuthRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function save(User $user): string
    {
        try {
            if ($user->getID() !== null) {
                $stmt = $this->pdo->prepare("UPDATE users SET email = :email, password = :password, role = :role WHERE id = :id");
            } else {
                $id = Uuid::uuid4()->toString();
                $user->setID($id);
                $stmt = $this->pdo->prepare("INSERT INTO users (id, email, password, role) VALUES (:id, :email, :password, :role)");
            }
            $stmt->execute([
                'id' => $user->getID(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole()
            ]);
            return $user->getID();
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error while saving user" . $e->getMessage());
        }
    }

    public function getUserByEmail(string $email): ?User
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user === false) {
                return null;
            }
            $u = new User($user['email'], $user['password'], $user['role']);
            $u->setID($user['id']);
            return $u;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error while fetching user" . $e->getMessage());
        }
    }

    public function getUserById(string $id): User
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch();
            if ($user === false) {
                throw new RepositoryEntityNotFoundException("User not found");
            }
            $u = new User($user['email'], $user['password'], $user['role']);
            $u->setID($user['id']);
            return $u;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error while fetching user" . $e->getMessage());
        }
    }

    public function getUsersByRole(int $role): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE role = :role");
            $stmt->execute(['role' => $role]);
            $users = $stmt->fetchAll();
            if ($users === false) {
                throw new RepositoryEntityNotFoundException("No user found");
            }
            $result = [];
            foreach ($users as $user) {
                $u = new User($user['email'], $user['password'], $user['role']);
                $u->setID($user['id']);
                $result[] = $u;
            }
            return $result;
        } catch (\PDOException $e) {
            throw new RepositoryInternalServerError("Error while fetching users");
        }
    }
}