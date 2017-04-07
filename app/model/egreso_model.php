<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class EgresoModel
{
    private $db;
    private $table = 'egresos';
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }
    
    public function InsertEgreso($data)
    {
        try 
        {
            if(isset($data['idEgreso']))
            {
                $sql = "UPDATE $this->table SET 
                            orden = ?,
                            trabajadores_idTrabajador = ?
                        WHERE idEgreso = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['orden'],
                            $data['trabajadores_idTrabajador'],
                            $data['idEgreso']
                        )
                    );
           }
            else{
                $sql = "INSERT INTO egresos
                            (orden,trabajadores_idTrabajador)
                            VALUES (?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['orden'],
                        $data['trabajadores_idTrabajador']
                        )); 
                     
              $this->response->idInsertado = $this->db->lastInsertId();
            
            }
            $this->response->setResponse(true);
            return $this->response;
        }catch (Exception $e) 
        {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
}

 