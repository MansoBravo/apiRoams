<?php
class HipotecaController extends BaseController
{
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $_REQUEST;
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel(); 
                $arrUsers = $userModel->getUsers($arrQueryStringParams);	 
                $responseData = $arrUsers->fetchArray(SQLITE3_ASSOC);  
                if ($responseData == ''){               
                    $strErrorDesc = "No existe el cliente";
                    $strErrorHeader = 'HTTP/1.1 203 Costumer Error';
                }else{
                    $userModelHipo = new GuardarHipotecaModel(); 
                    $arrUsersHipo = $userModelHipo->getUsers($arrQueryStringParams);	
                    $responseDataHipo = $arrUsersHipo->fetchArray(SQLITE3_ASSOC);
                    if ($responseDataHipo == '')
                        $type = "insert";
                    else
                        $type = "update";
                    $capital =  $responseData['capital'];
                    $hipotecaModel = new HipotecaModel();
                    $arrUsers = $hipotecaModel->getUsers($arrQueryStringParams,$type);
                    $responseData = json_encode($arrUsers);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        if (!$strErrorDesc) {
            $i =  $arrUsers['tae']/100/12;
            $n = $arrUsers['anos']*12;
            $cuota = round($capital * $i / (1 - (1 + $i) ** (-$n)),2);
            $total = round($cuota * $n);
            $result = json_encode(array('cuota' => $cuota, 'total' => $total));
            $this->sendOutput(
                $result,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}