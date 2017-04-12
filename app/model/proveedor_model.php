<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class ProveedorModel
{
    private $db;
    private $table = 'proveedores';
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

      $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idProveedor = ?");
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
            if(isset($data['idProveedor']))
            {
                $sql = "UPDATE $this->table SET 
                            nombreProveedor = ?,
                            descripcion = ?
                        WHERE idProveedor = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['nombreProveedor'],
                            $data['descripcion'],
                            $data['idProveedor']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (nombreProveedor,
                            descripcion )
                            VALUES (?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['nombreProveedor'],
                        $data['descripcion']
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
                  ->prepare("DELETE FROM $this->table WHERE idProveedor = ?");               

      $stm->execute(array($id));
            
      $this->response->setResponse(true);
            return $this->response;
    } catch (Exception $e) 
    {
      $this->response->setResponse(false, $e->getMessage());
    }
    }
}