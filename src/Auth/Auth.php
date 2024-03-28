<?php

namespace Dashboard\Auth;

use Dashboard\Auth\Exceptions\AuthDbConnectionNotSet;
use Dashboard\Auth\Exceptions\UserExistsException;

class Auth
{
    /**
     * @var string $usersTableName
    */
    private string $usersTableName = "users";

    /**
     * @var string $loginField
     */
    private string $loginField = "email";

    /**
     * @var string $usernameField
     * */
    private string $usernameField = "username";

    /**
     * @var string $passwordField
     */
    private string $passwordField = "password";

    /**
     * @var string $emailField
     */
    private string $emailField = "email";

    /**
     * @param PDO $pdo
     */
    public function __construct(
        private \PDO $connection
    )
    {
    }

    public function user(string $user)
    {
        return $_SESSION['user'];
    }

    public function login(string $user): bool
    {
        $_SESSION['user'] = $user;

        return true;
    }

    public function logout(string $user): bool
    {
        try {
            unset($_SESSION['user']);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function isUserLoggedIn(string $user): bool
    {
        if (isset($_SESSION['user']) || $_SESSION['user'] == $user) {
            return true;
        }

        return false;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws AuthDbConnectionNotSet
     */
    public function check(string $username, string $password): bool
    {
        if (!$this->connection) {
            throw new AuthDbConnectionNotSet();
        }

        $sql = "SELECT * FROM {$this->usersTableName} WHERE {$this->loginField} = '{$username}'";
        
        $stmt = $this->connection->query($sql);
        $results = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($results != false) {
            return password_verify($password, $results[$this->passwordField]);
        }

        return false;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     * @throws AuthDbConnectionNotSet
     * @throws UserExistsException
     */
    public function register(string $username, string $email, string $password): bool
    {
        if (!$this->connection) {
            throw new AuthDbConnectionNotSet();
        }

        $sql1 = "SELECT * FROM {$this->usersTableName} WHERE {$this->emailField} = '{$email}'";
        $stmt = $this->connection->query($sql1);

        if ($stmt->fetch()) {
            throw new UserExistsException();
        }

        $sql2 = "INSERT INTO {$this->usersTableName} ({$this->usernameField}, {$this->emailField}, {$this->passwordField}) VALUES (:{$this->usernameField}, :{$this->emailField}, :{$this->passwordField})";
        $stmt2 = $this->connection->prepare($sql2);
        return $stmt2->execute([
            ":{$this->usernameField}" => $username,
            ":{$this->emailField}" => $email,
            ":{$this->passwordField}" => $this->hash($password),
        ]);
    }

    /**
     * @param string $password
     * @return false|string|null
     */
    private function hash(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param array $fields
     * @return bool
     */
    public function setUsersTableFields(array $fields): bool
    {
        $output = false;

        foreach ([
            'usernameField' => 'setUsernameField',
            'passwordField' => 'setPasswordField',
            'emailField' => 'setEmailField'
        ] as $field => $setter) {
            if (array_key_exists($field, $fields)) {
                $this->$setter($fields[$field]);
                $output = true;
            }
        }

        return $output;
    }

    /**
     * @param string $tableName
     */
    public function setUsersTableName(string $tableName): void
    {
        $this->usersTableName = $tableName;
    }

    /**
     * @param string $loginField
     */
    public function setLoginField(string $loginField): void
    {
        $this->loginField = $loginField;
    }

    /**
     * @param string $passwordField
     */
    public function setPasswordField(string $passwordField): void
    {
        $this->passwordField = $passwordField;
    }

    /**
     * @param string $emailField
     */
    public function setEmailField(string $emailField): void
    {
        $this->emailField = $emailField;
    }

    /**
     * @param string $usernameField
     */
    public function setUsernameField(string $usernameField): void
    {
        $this->usernameField = $usernameField;
    }

    /**
     * @param object|string $objectOrClass
     * 
     * @return string
     */
    private function getClassName(object|string $objectOrClass): string
    {
        $reflection = new \ReflectionClass($objectOrClass);
        return $reflection->getName();
    }

    /**
     * @return bool
     * @throws AuthDbConnectionNotSet
     */
    private function usersTableExists(): bool
    {
        if (!$this->connection) {
            throw new AuthDbConnectionNotSet();
        }
        $sql = "SELECT 1 FROM {$this->usersTableName}";
        $stmt = $this->connection->query($sql);
        try {
            $results = $stmt->fetchAll();
            if (is_array($results)) {
                return true;
            }
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
