<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class IngresoModel
{
    private $db;
    private $table = 'ingresos';
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }
    
    public function InsertIngreso($data)
    {
        try 
        {
             if(isset($data['idIngreso']))
            {
                $sql = "UPDATE $this->table SET 
                            tipoDocumento = ?,
                            numeroDoc = ?,
                            proveedores_idProveedor = ?
                        WHERE idIngreso = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['tipoDocumento'],
                            $data['numeroDoc'],
                            $data['proveedores_idProveedor'],
                            $data['idIngreso']
                        )
                    );

                $sql = "UPDATE ingresos_has_movimientos SET 
                            precio = ?
                        WHERE movimientos_idMovimiento = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $data['precio'],
                            $data['idMovimiento']
                        )
                    );
            }
            else{
                $sql = "INSERT INTO ingresos
                            (tipoDocumento,numeroDoc,proveedores_idProveedor)
                            VALUES (?,?,?)";
            
                
            $this->db->prepare($sql)
                     ->execute(array(
                        $data['tipoDocumento'],
                        $data['numeroDoc'],
                        $data['proveedores_idProveedor']
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

    public function listarIngresosBodega($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio, cantidad, fecha, tipo, nombre as usuarioIngreso, bodega, idProducto, nombreProducto 
                FROM ingresos
                INNER JOIN proveedores on proveedores_idProveedor = idProveedor 
                INNER JOIN ingresos_has_movimientos on ingresos_idIngreso = idIngreso
                INNER JOIN movimientos on movimientos_idMovimiento = idMovimiento
                INNER JOIN bodegas on idBodega = bodegas_idBodega
                INNER JOIN usuarios on idUsuario = usuarios_idUsuario
                INNER JOIN trabajadores on idTrabajador = trabajadores_idTrabajador
                INNER JOIN productos on idProducto = productos_idProducto
                WHERE idBodega = ?
                order by fecha");
            $stm->execute(array($id['idBodega']));

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

    public function listarIngresosProducto($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio, cantidad, fecha, tipo, nombre as usuarioIngreso, bodega, idProducto, nombreProducto 
                FROM ingresos
                INNER JOIN proveedores on proveedores_idProveedor = idProveedor 
                INNER JOIN ingresos_has_movimientos on ingresos_idIngreso = idIngreso
                INNER JOIN movimientos on movimientos_idMovimiento = idMovimiento
                INNER JOIN bodegas on idBodega = bodegas_idBodega
                INNER JOIN usuarios on idUsuario = usuarios_idUsuario
                INNER JOIN trabajadores on idTrabajador = trabajadores_idTrabajador
                INNER JOIN productos on idProducto = productos_idProducto
                WHERE idBodega = ?
                AND idProducto = ?
                order by fecha");
            $stm->execute(array(
                $id['idBodega'],
                $id['idProducto']));

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
    
}

 