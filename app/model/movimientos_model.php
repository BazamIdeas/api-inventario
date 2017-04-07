<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class MovimientoModel
{
    private $db;
    private $table = 'movimientos';
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

			$stm = $this->db->prepare("SELECT * FROM $this->table WHERE idBodega = ?");
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
            if(isset($data['idMovimiento']))
            {
                $sql = "UPDATE $this->table SET 
                            cantidad = ?,
                            bodegas_idBodega = ?,
                            productos_idProducto = ?
                        WHERE idMovimiento = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['cantidad'],
                            $data['bodegas_idBodega'],
                            $data['productos_idProducto'],
                            $data['idMovimiento']
                        )
                    );
            }
            else
            {
                $sql = "INSERT INTO $this->table
                            (cantidad, fecha,tipo,usuarios_idUsuario,bodegas_idBodega,productos_idProducto)
                            VALUES (?,now(),?,?,?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['cantidad'],
                        $data['tipo'],
                        $data['usuarios_idUsuario'],
                        $data['bodegas_idBodega'],
                        $data['productos_idProducto']
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
    
    public function Borrar($id)
    {
		try 
		{
			$sql = "UPDATE $this->table SET 
                            cantidad = 0
                        WHERE idMovimiento = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $id['idMovimiento']
                        )
                    );
            
			$this->response->setResponse(true);
            return $this->response;
		} catch (Exception $e) 
		{
			$this->response->setResponse(false, $e->getMessage());
		}
    }

        
     public function relacionEgresoMovimiento($ide,$idm)
    {
        try 
        {
                $sql = "INSERT INTO egresos_has_movimientos
                            (egresos_idEgreso,movimientos_idMovimiento)
                            VALUES (?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $ide,$idm
                        )); 
            
            $this->response->setResponse(true);
            return $this->response;
        }catch (Exception $e) 
        {
            $this->response->setResponse(false, $e->getMessage());
        }
    }


    public function relacionIngresoMovimiento($idi,$idm,$p)
    {
        try 
        {
                $sql = "INSERT INTO ingresos_has_movimientos
                            (ingresos_idIngreso,movimientos_idMovimiento,precio)
                            VALUES (?,?,?)";
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $idi,$idm,$p
                        )); 
            
            $this->response->setResponse(true);
            return $this->response;
        }catch (Exception $e) 
        {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

}//fin de clase

 