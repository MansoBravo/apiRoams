<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class UserModel extends Database
{
    public function getUsers($parants)
    {
        return $this->select("SELECT users.*, tae, anos FROM users LEFT JOIN hipotecas ON hipotecas.dni = users.dni WHERE users.dni = :dni LIMIT 1",$parants);
    }
}