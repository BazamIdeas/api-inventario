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

    public function listarEgresos($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT orden,  idEgreso, idTrabajador, trabajadores.nombre as trabajador
                FROM egresos
                INNER JOIN egresos_has_movimientos on egresos_idEgreso = idEgreso
                INNER JOIN movimientos on movimientos_idMovimiento = idMovimiento
                INNER JOIN bodegas on idBodega = bodegas_idBodega
                INNER JOIN trabajadores on idTrabajador = egresos.trabajadores_idTrabajador
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

    public function listarEgresoMovimientos($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT orden, cantidad, fecha, tipo, trabajadores.nombre as trabajador, bodega, nombreProducto, idProducto, codigo
                FROM egresos
                INNER JOIN egresos_has_movimientos on egresos_idEgreso = idEgreso
                INNER JOIN movimientos on movimientos_idMovimiento = idMovimiento
                INNER JOIN bodegas on idBodega = bodegas_idBodega
                INNER JOIN usuarios on idUsuario = usuarios_idUsuario
                INNER JOIN trabajadores on idTrabajador = egresos.trabajadores_idTrabajador
                INNER JOIN productos on idProducto = productos_idProducto
                WHERE idBodega = ? AND idEgreso = ?
                order by fecha");
            $stm->execute(array($id['idBodega'],$id['idEgreso']));

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

    public function listarEgresosProducto($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT orden,  idEgreso,  cantidad, fecha, tipo, trabajadores.nombre as trabajador, bodega, nombreProducto, idProducto, codigo
                FROM egresos
                INNER JOIN egresos_has_movimientos on egresos_idEgreso = idEgreso
                INNER JOIN movimientos on movimientos_idMovimiento = idMovimiento
                INNER JOIN bodegas on idBodega = bodegas_idBodega
                INNER JOIN usuarios on idUsuario = usuarios_idUsuario
                INNER JOIN trabajadores on idTrabajador = egresos.trabajadores_idTrabajador
                INNER JOIN productos on idProducto = productos_idProducto
                WHERE idBodega = 1
                AND idProducto = 1
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

     public function Delete($id)
    {
        try 
        {
            $sql = "DELETE FROM egresos WHERE idEgreso = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $id
                        )
                    );
            
            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) 
        {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    

}

 