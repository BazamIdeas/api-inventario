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
    
}

 