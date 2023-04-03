<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode( '/', $uri );

if (!isset($_REQUEST['dni'])){
    echo json_encode(array('error' => "Parametros Incorrectos"));
    return;
}else if (comprobarDatos($_REQUEST) == '0'){
    echo json_encode(array('error' => "Formato Incorrecto"));
    return;
}

$_REQUEST['dni'] = strtoupper($_REQUEST['dni']);

$strMethodName = 'listAction';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'create'){
    require PROJECT_ROOT_PATH . "/Controller/Api/CreateController.php";
    $objFeedController = new CreateController();
    $objFeedController->$strMethodName();
}else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'user'){
    require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
    $objFeedController = new UserController();
    $objFeedController->{$strMethodName}();
}else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
    require PROJECT_ROOT_PATH . "/Controller/Api/UpdateController.php";
    $objFeedController = new UpdateController();
    $objFeedController->$strMethodName();
}else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'){
    require PROJECT_ROOT_PATH . "/Controller/Api/DeleteController.php";
    $objFeedController = new DeleteController();
    $objFeedController->$strMethodName();
}else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'hipoteca'){
    require PROJECT_ROOT_PATH . "/Controller/Api/HipotecaController.php";
    $objFeedController = new HipotecaController();
    $objFeedController->$strMethodName();
}else{
    echo json_encode(array('error' => "Parametros Incorrectos"));
}

//$stmt->close();

function comprobarDatos($datos){
    if (letraNIF($datos['dni']) == '0')
        return 0;

    if (isset($datos['action']) && ($datos['action'] == 'create' || $datos['action'] == 'update')){
        if (!isset($datos['capital']) || !is_numeric($datos['capital']))
            return 0;
        if (!isset($datos['nombre']) || $datos['nombre'] == '')
            return 0;
        if (!isset($datos['email']) || $datos['email'] == '')
            return 0;
    }

    if (isset($datos['action']) && ($datos['action'] == 'hipoteca')){
        if (!isset($datos['tae']) || !is_numeric($datos['tae']))
            return 0;
        if (!isset($datos['anos']) || !is_numeric($datos['anos']))
            return 0;
    }


}

function letraNIF ($dni) {
    $letradni = substr($dni, -1);
    $dni = substr($dni, 0, -1);
    if (!is_numeric($dni))
        return 0;
    $letraAlgoritmo = substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
    if ($letradni == $letraAlgoritmo)
        return 1;
    else 
        return 0;
}

?>