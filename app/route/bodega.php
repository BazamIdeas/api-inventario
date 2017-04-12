<?php
use App\Model\BodegaModel;

$app->group('/bodega/', function () {
    
    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('SI FUNCIONA XXX');
    });
    
    $this->get('lista', function ($req, $res, $args) {
        $um = new BodegaModel();
        
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
        $um = new BodegaModel();
        
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
        $um = new BodegaModel();
        
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
        $um = new BodegaModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });
    
});