<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class GuardarHipotecaModel extends Database
{
    public function getUsers($parants)
    {
        return $this->select("SELECT * FROM hipotecas WHERE dni = :dni LIMIT 1",$parants);
    }
}