<?php
use App\Model\TrabajadorModel;

$app->group('/trabajador/', function () {
    
    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('SI FUNCIONA XXX');
    });
    
    $this->post('lista', function ($req, $res, $args) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $this->get('datos/{id}', function ($req, $res, $args) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['id'])
            )
        );
    });
    
    $this->post('registro', function ($req, $res) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->InsertOrUpdate(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    $this->get('borrar/{id}', function ($req, $res, $args) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });

    $this->get('bloquear/{id}', function ($req, $res, $args) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Bloquear($args['id'])
            )
        );
    });

    $this->get('desbloquear/{id}', function ($req, $res, $args) {
        $um = new TrabajadorModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Desbloquear($args['id'])
            )
        );
    });
    
});