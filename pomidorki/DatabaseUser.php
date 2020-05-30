<?php


namespace pomidorki;


use InvalidArgumentException;
use LengthException;
use PDOException;

class DatabaseUser implements User
{
    private $id;
    private $login;
    private $password;
    private $active;
    private $photo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if (!is_null($password) && mb_strlen($password) < 6) {
            throw new LengthException("invalid password");
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function __construct($attributes)
    {
        $this->id = $attributes["id"];
        $this->login = $attributes["login"];
        $this->password = $attributes["password"];
        $this->active = $attributes["active"];
        $this->photo = $attributes["photo"];
        $this->validate();
    }


    public function delete() {

    }

    private function validate()
    {

    }

    public function update()
    {
        $pdo = getConnection();
        $statement = $pdo->prepare("update users set login = ?, password = ?, active = ?, image = ? where id = ?");
        $isActive = $this->active ?  'true' : 'false';

        try {
            $statement->execute([$this->login, $this->password, $isActive, $this->photo, $this->id]);
        } catch (PDOException $exception) {
            if ($exception->errorInfo[0] === 23505)
                throw new InvalidArgumentException("duplicate login");
            throw $exception;
        }
    }
}