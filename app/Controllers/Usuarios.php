<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Usuarios as ModelsUsuarios;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class Usuarios extends BaseController
{
    use ResponseTrait;

    protected $usuariosModel;
    public function __construct()
    {
        $this->usuariosModel = new ModelsUsuarios();
    }

    public function show()
    {
        try {
            $allUsuarios = $this->usuariosModel->select('id, usuario, nombre')->findAll();

            return Services::response()->setJSON([
                'res' => $allUsuarios
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }
    
    public function insert() {
        try {
            if($this->validate('createUsuario')) {

                $this->usuariosModel->insert([
                    'usuario' => $this->request->getJsonVar('usuario'),
                    'nombre' => $this->request->getJsonVar('nombre'),
                    'pass' => $this->request->getJsonVar('pass')
                ]);
                
                return Services::response()->setJSON([
                    'res' => "Usuario creado exitosamente"
                ])->setStatusCode(ResponseInterface::HTTP_OK);
            } else {
                $errors = \Config\Services::validation();
                return Services::response()->setJSON([
                    'error' => $errors->getErrors()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }

    public function get() {
        try {
            
            $usuario = $this->usuariosModel->select('id, usuario, nombre')->find($this->request->getJsonVar('id'));
            
            return Services::response()->setJSON([
                'res' => $usuario
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }

    public function update() {
        try {
            if($this->validate('updateUsuario')) {

                $this->usuariosModel->update([$this->request->getJsonVar('id')], [
                    'usuario' => $this->request->getJsonVar('usuario'),
                    'nombre' => $this->request->getJsonVar('nombre')
                ]);

                return Services::response()->setJSON([
                    'res' => "Usuario modificado exitosamente"
                ])->setStatusCode(ResponseInterface::HTTP_OK);
            } else {
                $errors = \Config\Services::validation();
                return Services::response()->setJSON([
                    'error' => $errors->getErrors()
                ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);die($e->getMessage());
        }
    }

    public function delete() {
        try {
            $this->usuariosModel->delete($this->request->getJsonVar('id'));

            return Services::response()->setJSON([
                'res' => "El usuario ha sido eliminado correctamente"
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }
}
