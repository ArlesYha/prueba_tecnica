<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Usuarios;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class Login extends BaseController
{
    protected $usuarioModel;
    public function __construct()
    {
        $this->usuarioModel = new Usuarios();
    }

    public function login() {
        try {
            $usuario = cleanStringToUpper($this->request->getVar('usuario'));
            $pass = cleanStringToUpper($this->request->getVar('pass'));

            return $this->usuarioModel->getUser($usuario, $pass);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }

    public function Logout() {
        try {
            $this->usuarioModel->endSession();
            return Services::response()->setJSON([
                'res' => "Se ha cerrado la sesión correctamente."
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }
}
