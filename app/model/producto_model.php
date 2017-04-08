<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class ProductoModel
{
    private $db;
    private $table = 'productos';
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

			$stm = $this->db->prepare("SELECT * FROM $this->table WHERE idProducto = ?");
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
            if(isset($data['idProducto']))
            {
                $sql = "UPDATE $this->table SET 
                            nombreProducto = ?,
                            descripcion = ?,
                            codigo = ?
                        WHERE idProducto = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['nombreProducto'],
                            $data['descripcion'],
                            $data['codigo'],
                            $data['idProducto']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (nombreProducto,
                            descripcion,
                            codigo )
                            VALUES (?,?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['nombreProducto'],
                        $data['descripcion'],
                        $data['codigo']
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
			            ->prepare("DELETE FROM $this->table WHERE idProducto = ?");			          

			$stm->execute(array($id));
            
			$this->response->setResponse(true);
            return $this->response;
		} catch (Exception $e) 
		{
			$this->response->setResponse(false, $e->getMessage());
		}
    }
}