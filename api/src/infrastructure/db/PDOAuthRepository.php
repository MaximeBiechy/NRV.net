<?php

namespace toubeelib\infrastructure\db;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\user\User;
use toubeelib\core\repositoryInterfaces\AuthRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\repositoryInterfaces\RepositoryInternalServerError;

class PDOAuthRepository implements AuthRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function save(User $user): string
    {
        try{
            if ($user->getID() !== null) {
                $stmt = $this->pdo->prepare("UPDATE user SET email = :email, password = :password, role = :role WHERE id = :id");
            }else{
                $id = Uuid::uuid4()->toString();
                $user->setID($id);
                $stmt = $this->pdo->prepare("INSERT INTO user (id, email, password, role) VALUES (:id, :email, :password, :role)");
            }
            $stmt->execute([
                'id' => $user->getID(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole()
            ]);

        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while saving user");
        }
    }

    public function getUserByEmail(string $email): User
    {
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user === false) {
                throw new RepositoryEntityNotFoundException("User not found");
            }
            $u =  new User($user['email'], $user['password'], $user['role']);
            $u->setID($user['id']);
            return $u;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching user". $e->getMessage());
        }
    }

    public function getUserById(string $id): User
    {
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch();
            if ($user === false) {
                throw new RepositoryEntityNotFoundException("User not found");
            }
            $u =  new User($user['email'], $user['password'], $user['role']);
            $u->setID($user['id']);
            return $u;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching user");
        }
    }

    public function getUsersByRole(int $role): array
    {
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE role = :role");
            $stmt->execute(['role' => $role]);
            $users = $stmt->fetchAll();
            $result = [];
            foreach ($users as $user) {
                $u =  new User($user['email'], $user['password'], $user['role']);
                $u->setID($user['id']);
                $result[] = $u;
            }
            return $result;
        }catch (\PDOException $e){
            throw new RepositoryInternalServerError("Error while fetching users");
        }
    }
}