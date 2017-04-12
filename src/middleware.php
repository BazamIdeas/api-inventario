<?php
// Application middleware
use App\Model\UsuarioModel;

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(function ($request, $response, $next) {
	if(!$this->get('settings')['seguridad']){
		$_SESSION['idUsuario'] = 1;
		return	$response =	$next($request, $response);
	}

	$ver = false;
	if ($request->getUri()->getPath() == 'usuario/login'){
		//$response->getBody()->write($request->getUri()->getPath());
		$um = new UsuarioModel();
		$ver = $um->Verificar($request->getParsedBody());
	}

	if(isset($_SESSION['uid']) || $ver == true){
	return	$response =	$next($request, $response);
	} 

	else{	
		$args['name'] = 'Restringido';
		return $this->renderer->render($response, 'index.phtml', $args);}

});/*

$app->add(function ($request, $response, $next) {
	$response->getBody()->write($request->getUri()->getPath());
	//$response = $next($request, $response);

	return $response;
});*/