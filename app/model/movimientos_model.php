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
    
    public function Historial($id)
    {
		try
		{
			$result = array();

			$stm = $this->db->prepare("SELECT idMovimiento, bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
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
                order by fecha DESC");
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

    public function HistorialPaginado($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT  idMovimiento, bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
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
                order by fecha DESC LIMIT ? OFFSET ?");
            $stm->execute(array($id['idBodega'],$id['limit'],$id['offset']));
            
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

    public function ProductosBodega($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT  codigo, nombreProducto, idProducto, productos.descripcion as descripcionProducto, SUM(cantidad) AS existencia
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
                group by idProducto");
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

    public function HistorialProducto($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT  bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
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
                AND idProducto = ?
                order by fecha DESC");
            $stm->execute(array(
                $id['idBodega'],
                $id['idProducto']
                ));
            
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
    
    public function Datos($id)
    {
		try
		{
			$result = array();

			$stm = $this->db->prepare("SELECT  idMovimiento, bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
                FROM movimientos
                LEFT JOIN egresos_has_movimientos on egresos_has_movimientos.movimientos_idMovimiento = idMovimiento
                LEFT JOIN ingresos_has_movimientos on ingresos_has_movimientos.movimientos_idMovimiento = idMovimiento
                LEFT JOIN egresos on egresos_idEgreso = idEgreso
                LEFT JOIN ingresos on ingresos_idIngreso = idIngreso
                LEFT JOIN proveedores on proveedores_idProveedor = idProveedor
                LEFT JOIN bodegas on idBodega = bodegas_idBodega
                LEFT JOIN trabajadores on idTrabajador = egresos.trabajadores_idTrabajador
                LEFT JOIN productos on idProducto = productos_idProducto
                WHERE idMovimiento = ?");
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
        if ($data['tipo'] == 'Egreso'){ $cantidad = $data['cantidad'] * -1; }
        else{$cantidad = $data['cantidad'] ;}
		try 
		{
            if(isset($data['idMovimiento']))
            {
                $sql = "UPDATE $this->table SET 
                            cantidad = ?,
                            productos_idProducto = ?
                        WHERE idMovimiento = ?";
                
                $this->db->prepare($sql)
                     ->execute(
                        array(
                            $cantidad,
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
                        $cantidad,
                        $data['tipo'],
                        $_SESSION['idUsuario'],
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
			$sql = "DELETE FROM movimientos WHERE idMovimiento = ?";
                
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

    public function DescargaMes($id)
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT  bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
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
                AND MONTH(fecha) = MONTH (NOW())
                order by fecha DESC");
            $stm->execute(array($id));
            
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response->result;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function DescargaRango($datos)
    {
        try
        {$fecha_1= date("Y-m-d", strtotime($datos['fecha_inicio'])); 
        $fecha_2= date("Y-m-d", strtotime($datos['fecha_fin']."+ 1 day")); 
            $result = array();

            $stm = $this->db->prepare("SELECT  bodega, fecha, nombreProducto, idProducto,tipo, codigo, productos.descripcion as descripcionProducto, cantidad, trabajadores.nombre as trabajador,  orden,  idEgreso,
                tipoDocumento, numeroDoc, idIngreso, nombreProveedor, precio
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
                AND fecha BETWEEN ? AND ? 
                order by fecha DESC");
            $stm->execute(array(
                        $datos['idBodega'],
                        $fecha_1,
                        $fecha_2
                        ));
            
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response->result;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

}//fin de clase

 