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
            ->withHeader("Access-Control-Allow-Origin", "*")
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            
            
           ->getBody()
           ->write(
            json_encode(array('response' => true))
        );
    });  
    $this->post('modificar', function ($req, $res) {
        $e = new EgresoModel();

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

        $this->post('lista', function ($req, $res) {
        $e = new EgresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
                        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')

           ->getBody()
           ->write(
            json_encode(
                $e->listarEgresos($req->getParsedBody())
            )
        );
    });

      $this->post('datos', function ($req, $res) {
        $e = new EgresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $e->listarEgresoMovimientos($req->getParsedBody())
            )
        );
    });

    $this->post('lista/producto', function ($req, $res) {
        $e = new EgresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $e->listarEgresosProducto($req->getParsedBody())
            )
        );
    });

    $this->get('borrar/{id}', function ($req, $res, $args) {
        $e = new EgresoModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $e->Delete($args['id'])
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

    $this->post('lista', function ($req, $res) {
        $i = new IngresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->listarIngresos($req->getParsedBody())
            )
        );
    });
    $this->post('datos', function ($req, $res) {
        $i = new IngresoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->listarIngresoMovimientos($req->getParsedBody())
            )
        );
    });

    $this->post('lista/producto', function ($req, $res) {
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
        $i = new IngresoModel();

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

    $this->get('borrar/{id}', function ($req, $res, $args) {
         $i = new IngresoModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $i->Delete($args['id'])
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

    $this->post('historial/paginado', function ($req, $res) {
        $m = new MovimientoModel();
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
               $m->HistorialPaginado(
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
    
    $this->get('borrar/{id}', function ($req, $res, $args) {
        $m = new MovimientoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $m->Borrar(
                    $args['id']
                )
            )
        );
    });    

    $this->post('modificar', function ($req, $res) {
        $m = new MovimientoModel();

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $m->InsertOrUpdate(
                  $req->getParsedBody() 
              )
            )
        );
    });

       $this->get('descargar/{id}', function ($req, $res,  $args) {
        $m = new MovimientoModel();
        $movimientos = $m->DescargaMes($args['id']);
        $titulo = 'Movimientos del mes - '.gmdate('m');

          foreach ($movimientos as $movi) {

            /** Error reporting */
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            date_default_timezone_set('Europe/London');
            if (PHP_SAPI == 'cli')
              die('This example should only be run from a Web Browser');
            /** Include PHPExcel */
            require_once dirname(__FILE__) . '/../lib/PHPExcel.php';
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Bargiotti")
                           ->setTitle($titulo)
                           ->setDescription("Movimientos de la bodega del mes");
            // Add some data
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Fecha')
                        ->setCellValue('B1', 'Tipo de Movimiento')
                        ->setCellValue('C1', 'Trabajador')
                        ->setCellValue('D1', 'Material')
                        ->setCellValue('E1', 'Documento')
                        ->setCellValue('F1', 'Numero')
                        ->setCellValue('G1', 'Cantidad');
            // Miscellaneous glyphs, UTF-8
            $y = 2;
            foreach ($movimientos as $movi) {

               $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$y, date("d-m-Y", strtotime($movi->fecha) ))
                        ->setCellValue('B'.$y, $movi->tipo)
                        ->setCellValue('C'.$y, $movi->trabajador)
                        ->setCellValue('D'.$y, $movi->nombreProducto)
                        ->setCellValue('E'.$y, $movi->tipoDocumento)
                        ->setCellValue('F'.$y, $movi->numeroDoc)
                        ->setCellValue('G'.$y, $movi->cantidad);
                        $y++;
            }

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($titulo);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$titulo.'.xls');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('excel/'.$titulo.'.xls');
           return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(array('response' => true, 'link' => 'excel/'.$titulo.'.xls'))
        );
          //  $objWriter->save('php://output');
            exit; 
            }


    });     

});//FIN DE MOVIMIENTO