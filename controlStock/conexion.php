<?php

class Conexion{

    private $cont;
    public function __construct()
    {
       //variables de conexion
       try{
        $username ="root";
        $password ="";
        $dsn ="mysql:host=localhost;dbname=db_stock_alacid";

        $this->cont =  new PDO($dsn,$username,$password);
        //verifico que se ha iniciado la conexion
       
       }catch(PDOException $e){
            echo $e->getMessage();
       }
       
    }


    public function queryAll(string $query) : array
    {
            $consulta = $this->cont->query($query);
            if(!$consulta){
                die("Error en la consulta ".$this->cont->errorInfo());
            }
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
    }


    public function query(string $query) : bool
    {
            $consulta = $this->cont->query($query);
            if(!$consulta){
                die("Error en la consulta ".$this->cont->errorInfo());
            }
        
            return true;
    }

}

?>