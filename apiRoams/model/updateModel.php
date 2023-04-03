<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class UpdateModel extends Database
{
    public function getUsers($parants)
    {
        return $this->select("UPDATE users SET nombre = :nombre, email = :email, capital = :capital WHERE dni = :dni",$parants);
    }
}