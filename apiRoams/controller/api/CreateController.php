<?php
class CreateController extends BaseController
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
                if ($responseData != ''){               
                    $strErrorDesc = "Cliente ya existente";
                    $strErrorHeader = 'HTTP/1.1 202 Customer Error';
                }else{
                    $createModel = new CreateModel();
                    $arrUsers = $createModel->getUsers($arrQueryStringParams);
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
            $this->sendOutput(
                'Cliente Creado',
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}