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

        public function ProductosExistencia($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT  nombreProducto, idProducto,  SUM(cantidad) AS existencia
                FROM movimientos
                LEFT JOIN egresos_has_movimientos on egresos_has_movimientos.movimientos_idMovimiento = idMovimiento
                LEFT JOIN ingresos_has_movimientos on ingresos_has_movimientos.movimientos_idMovimiento = idMovimiento
                LEFT JOIN egresos on egresos_idEgreso = idEgreso
                LEFT JOIN ingresos on ingresos_idIngreso = idIngreso
                LEFT JOIN proveedores on proveedores_idProveedor = idProveedor
                LEFT JOIN bodegas on idBodega = bodegas_idBodega
                LEFT JOIN trabajadores on idTrabajador = egresos.trabajadores_idTrabajador
                LEFT JOIN productos on idProducto = productos_idProducto
                WHERE idBodega = ?
                AND idProducto = ?");
            $stm->execute(array($id['bodegas_idBodega'],$id['productos_idProducto']));
            
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
}