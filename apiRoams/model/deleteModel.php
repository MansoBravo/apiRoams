<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class DeleteModel extends Database
{
    public function getUsers($parants)
    {
        return $this->select("DELETE FROM users WHERE dni = :dni",$parants);
    }
}