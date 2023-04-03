<?php
class Database
{
    protected $connection = null;
    public function __construct()
    {
        try {
            $this->connection = new SQLite3('palenciaRural.db');
    	
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }
    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            if (get_class($this) == "UserModel" || get_class($this) == "GuardarHipotecaModel"){
                $result = $stmt->execute();	
                return $result;
            }else{
                $stmt->execute();
                return $params;
            }
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            if( $params ) {
                foreach($params as $key => &$valor){
                    $stmt->bindParam(":$key", $valor);
                }
            }
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
}