<?php
use App\Model\UsuarioModel;
use App\Model\TrabajadorModel;

$app->group('/usuario/', function () {
    
    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('SI FUNCIONA XXX');
    });

    $this->post('login', function ($req, $res, $args) {
        $um = new UsuarioModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Login($req->getParsedBody())
            )
        );
    });

    $this->get('bloquear/{id}', function ($req, $res, $args) {
        $um = new UsuarioModel();
        
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
        $um = new UsuarioModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Desbloquear($args['id'])
            )
        );
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
        $datosU = $req->getParsedBody();

        if (!isset($datosU["idUsuario"])){
          $idt = $t->InsertOrUpdate($datosU);
          $idT = $idt->idInsertado;
        }

        else{
          $idT = 0;
        }
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->InsertOrUpdate(
                    $datosU, $idT
                )
            )
        );
    });
    
    $this->get('borrar/{id}', function ($req, $res, $args) {
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

    $this->get('salir', function ($req, $res, $args) {
      session_destroy();
        return $res->getBody()
                   ->write(
            json_encode(array('response' => true))
        );
    });
    
});