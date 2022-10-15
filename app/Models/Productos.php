<?php

namespace App\Models;

use CodeIgniter\Model;

class Productos extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "codigo",
        "nombre",
        "descripcion"
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
    protected $beforeInsert   = ['supportCodigo'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['supportCodigo'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function supportCodigo ($data) {
        if(strlen($data["data"]["codigo"]) < 12) {
            $addCero = 12 - strlen($data["data"]["codigo"]);

            $cero = '';
            for ($i=0; $i < $addCero; $i++) { 
                $cero = $cero . '0';
            }            

            $data["data"]["codigo"] = $cero . $data["data"]["codigo"];
        }

        return $data;
    }
}
