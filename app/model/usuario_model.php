<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class UsuarioModel
{
    private $db;
    private $table = 'usuarios';
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

      $stm = $this->db->prepare("SELECT email, tipoUser, estado, nombre 
        FROM $this->table
        INNER JOIN trabajadores on trabajadores_idTrabajdor = idTrabajador");
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

      $stm = $this->db->prepare("SELECT email, tipoUser, estado, nombre 
        FROM $this->table
        INNER JOIN trabajadores on trabajadores_idTrabajdor = idTrabajador
        WHERE idUsuario = ?");
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
    
    public function InsertOrUpdate($data,$idt)
    {
    try 
    {
            if(isset($data['idUsuario']))
            {
                $sql = "UPDATE $this->table SET 
                            email = ?,
                            tipoUser = ?,
                            estado = ?
                        WHERE idUsuario = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['email'],
                            $data['tipoUser'],
                            $data['estado'],
                            $data['idUsuario']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (email,tipoUser,estado,trabajadores_idTrabajdor)
                            VALUES (?,?,?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['email'],
                        $data['tipoUser'],
                        $data['estado'],
                        $idt
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
                  ->prepare("DELETE FROM $this->table WHERE idUsuario = ?");               

      $stm->execute(array($id));
            
      $this->response->setResponse(true);
            return $this->response;
    } catch (Exception $e) 
    {
      $this->response->setResponse(false, $e->getMessage());
    }
    }
}