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

    public function Login($email)
    {
    try
    {
      $result = array();

      $stm = $this->db->prepare("SELECT idUsuario, uid, email, tipoUser, estado, nombre 
        FROM $this->table
        INNER JOIN trabajadores on trabajadores_idTrabajador = idTrabajador
        WHERE email = ?");

      $stm->execute(array($email['email']));

      $this->response->result = $stm->fetch();

      if ($stm->fetchColumn() > 0){    

          if ($this->response->result->estado){
            $this->response->setResponse(true);
            $_SESSION['uid'] = $this->response->result->uid;
            $_SESSION['idUsuario'] = $this->response->result->idUsuario;

          }
          else{
            $this->response->setResponse(false,'Usuario Bloqueado');
          }       
      }

      else{
        $this->response->setResponse(false,'Usuario no existe');
      }

      return $this->response;
    }
    catch(Exception $e)
    {
      $this->response->setResponse(false, $e->getMessage());
            return $this->response;
    }
    }

    public function Bloquear($id)
    {
    try
    {
      $result = array();

       $sql = "UPDATE $this->table SET estado = 0
                        WHERE idUsuario = ?";
                
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

       $sql = "UPDATE $this->table SET estado = 1
                        WHERE idUsuario = ?";
                
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

    public function GetAll()
    {
    try
    {
      $result = array();

      $stm = $this->db->prepare("SELECT idUsuario, uid, email, tipoUser, estado, nombre 
        FROM $this->table, trabajadores
        WHERE usuarios.trabajadores_idTrabajador = trabajadores.idTrabajador");
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

    public function Verificar($data)
    {
    try
    {
      $result = array();

      $stm = $this->db->prepare("SELECT * FROM $this->table
        WHERE uid = ? AND
        estado = 1
        AND email = ?");
      $stm->execute(array($data['uid'],$data['email']));

      if ($stm->fetchColumn() > 0){
        return true;
      }
      else {return false;}
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

      $stm = $this->db->prepare("SELECT uid, email, tipoUser, estado, nombre 
        FROM $this->table, trabajadores
        WHERE trabajadores_idTrabajador = idTrabajador AND
        idUsuario = ?");
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
                            tipoUser = ?
                        WHERE idUsuario = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['email'],
                            $data['tipoUser'],
                            $data['idUsuario']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (email,tipoUser,estado,trabajadores_idTrabajador,uid)
                            VALUES (?,?,?,?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['email'],
                        $data['tipoUser'],
                        1,
                        $idt,
                        $data['uid']
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