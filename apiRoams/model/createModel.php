<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class CreateModel extends Database
{
    public function getUsers($parants)
    {
        return $this->select("INSERT INTO users(dni, nombre, email, capital) VALUES(:dni, :nombre, :email, :capital)",$parants);
    }
}