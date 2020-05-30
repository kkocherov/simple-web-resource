<?php


namespace pomidorki;


interface User
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getLogin();

    /**
     * @param mixed $login
     */
    public function setLogin($login);

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param mixed $password
     */
    public function setPassword($password);

    /**
     * @return mixed
     */
    public function getActive();

    /**
     * @param mixed $active
     */
    public function setActive($active);

    /**
     * @return mixed
     */
    public function getPhoto();

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo);

    public function update();
}