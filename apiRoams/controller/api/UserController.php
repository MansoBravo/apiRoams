<?php
class UserController extends BaseController
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
                if (isset($responseData['tae']) && $responseData['tae'] != '') {
                    $i =  $responseData['tae']/100/12;
                    $n = $responseData['anos']*12;
                    $cuota = round($responseData['capital'] * $i / (1 - (1 + $i) ** (-$n)),2);
                    $total = round($cuota * $n);
                    $responseData["cuota"] = $cuota;
                    $responseData["total"] = $total;
                }
                $responseData = json_encode($responseData);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}