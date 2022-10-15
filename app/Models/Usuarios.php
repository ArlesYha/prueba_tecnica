<?php

namespace App\Models;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Config\Services;
use Exception;

class Usuarios extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "usuario", 
        "nombre",
        "pass"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function hashPassword(array $data){
        if (!isset($data['data']['pass'])) {
            return $data;
        }
        
        $data['data']['pass'] = password_hash($data['data']['pass'], PASSWORD_DEFAULT);
        return $data;

    }

    public function getUser($user, $pass){
        if(isset($user) && isset($pass)) {
            $dataUsuario = $this->allowCallbacks(false)
                             ->select('
                                id, 
                                usuario, 
                                pass')
                             ->where('usuario', $user)
                             ->asArray()
                             ->findAll();

            if(count($dataUsuario) == 0) {
                return Services::response()->setJSON([
                    "res" => "Usuario o contraseña incorrectas"
                ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            if(!password_verify($pass, $dataUsuario[0]["pass"])) {
                return Services::response()->setJSON([
                    "res" => "Usuario o contraseña incorrectas"
                ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            } else {
                session()->set([
                    "id" => $dataUsuario[0]["id"],
                    "usuario" => $dataUsuario[0]["usuario"],
                    "is_logged" => true
                ]);

                helper('jwt');

                $token = getSignedJWTForUser(session()->get('usuario'));

                return Services::response()->setJSON([
                    'res' => [
                        "id" => session()->get("id"),
                        "token" => $token,
                    ]
                ])->setStatusCode(ResponseInterface::HTTP_OK);
            }
        } else {
            return Services::response()->setJSON([
                "res" => "Ingrese su usuario y contraseña"
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function endSession() {
        session()->destroy();
    }

    public function findByUser($usuario) {
        $usuario = $this->where(['usuario' => $usuario])->first();

        if (!$usuario) {
            throw new Exception('No existe ningún usuario registrado con esta información.');
        }

        return $usuario;
    }
}
