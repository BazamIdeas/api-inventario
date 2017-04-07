<?php
use App\Model\MovimientoModel;
use App\Model\EgresoModel;
use App\Model\IngresoModel;

$app->group('/egreso/', function () {
       
    $this->post('registro', function ($req, $res) {
        $m = new MovimientoModel();
        $e = new EgresoModel();
        $idm = $m->InsertOrUpdate($req->getParsedBody() );
       $ide = $e->InsertEgreso($req->getParsedBody() );

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $m->relacionEgresoMovimiento(
                    $ide->idInsertado,$idm->idInsertado
                )
            )
        );
    });  
    $this->post('modificar', function ($req, $res) {
        $m = new MovimientoModel();
        $i = new EgresoModel();
        $m->InsertOrUpdate($req->getParsedBody() );

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->InsertEgreso(
                  $req->getParsedBody() 
              )
            )
        );
    });     
});




$app->group('/ingreso/', function () {
       
    $this->post('registro', function ($req, $res) {
        $m = new MovimientoModel();
        $i = new IngresoModel();
        $idm = $m->InsertOrUpdate($req->getParsedBody() );
       $idi = $i->InsertIngreso($req->getParsedBody() );
       $p = $req->getParsedBody();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $m->relacionIngresoMovimiento(
                    $idi->idInsertado,$idm->idInsertado,$p['precio']
                )
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
                  $req->getParsedBody() 
              )
            )
        );
    });      
});



$app->group('/movimiento/', function () {
    
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
});