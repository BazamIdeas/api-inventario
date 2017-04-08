<?php
use App\Model\UsuarioModel;
use App\Model\TrabajadorModel;

$app->group('/trabajador/', function () {
    
    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('SI FUNCIONA XXX');
    });
    
    $this->get('lista', function ($req, $res, $args) {
        $um = new UsuarioModel();
        
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
        $um = new UsuarioModel();
        
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
        $um = new UsuarioModel();
        $t = new TrabajadorModel();
        $idt = $t->InsertOrUpdate($req->getParsedBody())
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->InsertOrUpdate(
                    $req->getParsedBody(), $idt['idInsertado']
                )
            )
        );
    });
    
    $this->post('borrar/{id}', function ($req, $res, $args) {
        $um = new UsuarioModel();
        
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