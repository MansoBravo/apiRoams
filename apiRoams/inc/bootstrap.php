<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// include main configuration file 
require_once PROJECT_ROOT_PATH . "/inc/config.php";
// include the base controller file 
require_once PROJECT_ROOT_PATH . "/controller/api/baseController.php";

// include the model file 
require_once PROJECT_ROOT_PATH . "/model/userModel.php";
require_once PROJECT_ROOT_PATH . "/model/createModel.php";
require_once PROJECT_ROOT_PATH . "/model/updateModel.php";
require_once PROJECT_ROOT_PATH . "/model/deleteModel.php";
require_once PROJECT_ROOT_PATH . "/model/hipotecaModel.php";
require_once PROJECT_ROOT_PATH . "/model/guardarHipotecaModel.php";
?>