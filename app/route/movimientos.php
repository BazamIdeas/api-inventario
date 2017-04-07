<?php
use App\Model\MovimientoModel;
use App\Model\EgresoModel;
use App\Model\IngresoModel;
use App\Lib\Response;

$app->group('/egreso/', function () {
       
    $this->post('registro', function ($req, $res) {
        $m = new MovimientoModel();
        $e = new EgresoModel();
        $datos = $req->getParsedBody() ;
        $ide = $e->InsertEgreso($req->getParsedBody() );

        foreach ($datos['egresos'] as $egreso){
        $idm = $m->InsertOrUpdate($egreso );
        $m->relacionEgresoMovimiento($ide->idInsertado,$idm->idInsertado);

        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(array('response' => true))
        );
    });  
    $this->post('modificar', function ($req, $res) {
        $m = new MovimientoModel();
        $e = new EgresoModel();
        $m->InsertOrUpdate($req->getParsedBody() );

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $e->InsertEgreso(
                  $req->getParsedBody() 
              )
            )
        );
    });     

        $this->post('listar', function ($req, $res) {
        $e = new EgresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $e->listarEgresosBodega($req->getParsedBody())
            )
        );
    });

    $this->post('listar/producto', function ($req, $res) {
        $e = new EgresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->listarEgresosProducto($req->getParsedBody())
            )
        );
    });
});// FIN DE EGRESO



/////////////////////////////////////////////---INGRESO ---- /////////////////////
$app->group('/ingreso/', function () {
       
    $this->post('registro', function ($req, $res) {
        $m = new MovimientoModel();
        $i = new IngresoModel();
        $datos = $req->getParsedBody() ;
        $idi = $i->InsertIngreso($req->getParsedBody() );

        foreach ($datos['ingresos'] as $ingreso){
        $idm = $m->InsertOrUpdate($ingreso );
        $m->relacionIngresoMovimiento(
          $idi->idInsertado,$idm->idInsertado,$ingreso['precio']);
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(array('response' => true) )
        );
    });

    $this->post('listar', function ($req, $res) {
        $i = new IngresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->listarIngresosBodega($req->getParsedBody())
            )
        );
    });

    $this->post('listar/producto', function ($req, $res) {
        $i = new IngresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->listarIngresosProducto($req->getParsedBody())
            )
        );
    });

      $this->post('modificar', function ($req, $res) {
        $m = new MovimientoModel();
        $i = new IngresoModel();
        $m->InsertOrUpdate($req->getParsedBody() );

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->InsertIngreso(
                  $req->getParsedBody($id) 
              )
            )
        );
    });      
});// FIN DE INGRESO


//////////////////////////////////////////RUTAS DE MOVIMIENTOS GENERALES
$app->group('/movimiento/', function () {

    $this->post('historial', function ($req, $res) {
        $m = new MovimientoModel();
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
               $m->Historial(
                  $req->getParsedBody() 
              )
            )
        );
    });

    $this->post('historial/producto', function ($req, $res) {
        $m = new MovimientoModel();
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
               $m->HistorialProducto(
                  $req->getParsedBody() 
              )
            )
        );
    });

    $this->get('datos/{id}', function ($req, $res, $args) {
        $um = new MovimientoModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Datos($args['id'])
            )
        );
    });
    
    $this->post('borrar', function ($req, $res) {
        $m = new MovimientoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $m->Borrar(
                    $req->getParsedBody()
                )
            )
        );
    });    

});//FIN DE MOVIMIENTO