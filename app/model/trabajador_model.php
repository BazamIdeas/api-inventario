<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class TrabajadorModel
{
    private $db;
    private $table = 'trabajadores';
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }
    
    public function GetAll()
    {
    try
    {
      $result = array();

      $stm = $this->db->prepare("SELECT * FROM $this->table");
      $stm->execute();
            
      $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
    }
    catch(Exception $e)
    {
      $this->response->setResponse(false, $e->getMessage());
            return $this->response;
    }
    }
    
    public function Get($id)
    {
    try
    {
      $result = array();

      $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idTrabajador = ?");
      $stm->execute(array($id));

      $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            
            return $this->response;
    }
    catch(Exception $e)
    {
      $this->response->setResponse(false, $e->getMessage());
            return $this->response;
    }  
    }
    
    public function InsertOrUpdate($data)
    {
    try 
    {
            if(isset($data['idTrabajador']))
            {
                $sql = "UPDATE $this->table SET 
                            nombre = ?
                        WHERE idTrabajador = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['nombre'],
                            $data['idTrabajador']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (nombre, estadoT)
                            VALUES (?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['nombre'],
                        1
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
    
    public function Delete($id)
    {
    try 
    {
      $stm = $this->db
                  ->prepare("DELETE FROM $this->table WHERE idTrabajador = ?");               

      $stm->execute(array($id));
            
      $this->response->setResponse(true);
            return $this->response;
    } catch (Exception $e) 
    {
      $this->response->setResponse(false, $e->getMessage());
    }
    }

        public function Bloquear($id)
    {
    try
    {
      $result = array();

       $sql = "UPDATE $this->table SET estadoT = 0
                        WHERE idTrabajador = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $id
                        )
                    );
            
      $this->response->setResponse(true);
            
            return $this->response;
    }
    catch(Exception $e)
    {
      $this->response->setResponse(false, $e->getMessage());
            return $this->response;
    }
    }

    public function Desbloquear($id)
    {
    try
    {
      $result = array();

       $sql = "UPDATE $this->table SET estadoT = 1
                        WHERE idTrabajador = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $id
                        )
                    );
            
      $this->response->setResponse(true);
            
            return $this->response;
    }
    catch(Exception $e)
    {
      $this->response->setResponse(false, $e->getMessage());
            return $this->response;
    }
    }
}