<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Productos as ModelsProductos;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class Productos extends BaseController
{
    use ResponseTrait;

    protected $productoModel;
    public function __construct()
    {
        $this->productoModel = new ModelsProductos();
    }

    public function show() {
        try {
            $allProductos = $this->productoModel->select('id, codigo, nombre, descripcion')->findAll();
            
            return Services::response()->setJSON([
                'res' => $allProductos
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }

    public function insert() {
        try {
            if($this->validate('createProducto')) {
                $this->productoModel->insert([
                    'codigo' => $this->request->getJsonVar('codigo'),
                    'nombre' => $this->request->getJsonVar('nombre'),
                    'descripcion' => $this->request->getJsonVar('descripcion'),
                ]);

                return Services::response()->setJSON([
                    'res' => "Producto creado exitosamente"
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
            
            $producto = $this->productoModel->select('id, codigo, nombre, descripcion')->find($this->request->getJsonVar('id'));

            return Services::response()->setJSON([
                'res' => $producto
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }

    public function update() {
        try {
            if($this->validate('updateProducto')) {

                $this->productoModel->update([$this->request->getJsonVar('id')], [
                    'codigo' => $this->request->getJsonVar('codigo'),
                    'nombre' => $this->request->getJsonVar('nombre'),
                    'descripcion' => $this->request->getJsonVar('descripcion'),
                ]);

                return Services::response()->setJSON([
                    'res' => "Producto modificado exitosamente"
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

    public function delete() {
        try {
            $this->productoModel->delete($this->request->getJsonVar('id'));

            return Services::response()->setJSON([
                'res' => 'El producto ha sido eliminado correctamente'
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'erros' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_CONFLICT);
        }
    }
}
