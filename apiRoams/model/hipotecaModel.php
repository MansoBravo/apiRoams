<?php
require_once PROJECT_ROOT_PATH . "/Model/database.php";
class HipotecaModel extends Database
{
    public function getUsers($parants,$type)
    {
        if ($type == "insert")
            return $this->select("INSERT INTO hipotecas(dni, tae, anos) VALUES(:dni, :tae, :anos)",$parants);
        else
            return $this->select("UPDATE hipotecas SET tae = :tae, anos = :anos WHERE dni = :dni",$parants);
    }
}