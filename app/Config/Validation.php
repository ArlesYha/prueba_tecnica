<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $createUsuario = [
        'usuario' => 'required|is_unique[usuarios.usuario]|max_length[12]',
        'nombre ' => 'required|alpha_numeric_punct',
        'pass' => 'required'
    ];

    public $createUsuario_errors = [
        'usuario' => [
            'required' => 'El campo usuario debe ser completado',
            'is_unique' => 'Ya hay un usuario registrado con este nick',
            'max_length' => 'El máximo de caracteres permitidos es 12'
        ],
        'nombre' => [
            'required' => 'El usuario debe ser registrado con un nombre',
            'alpha_numeric_punct' => 'Solo están permitodos caracteres alfanuméricos y especiales'
        ],
        'pass' => [
            'required' => 'Ingrese una contraseña.'
        ]
    ];

    public $updateUsuario = [
        'usuario' => 'required|max_length[12]',
        'nombre ' => 'required|alpha_numeric_punct'
    ];

    public $updateUsuario_errors = [
        'usuario' => [
            'required' => 'El campo usuario debe ser completado',
            'max_length' => 'El máximo de caracteres permitidos es 12'
        ],
        'nombre' => [
            'required' => 'El usuario debe ser registrado con un nombre',
            'alpha_numeric_punct' => 'Solo están permitodos caracteres alfanuméricos y especiales'
        ]
    ];

    public $createProducto = [
        'codigo' => 'required|is_unique[productos.codigo]|alpha_numeric',
        'nombre' => 'required|alpha_numeric_space',
        'descripcion' => 'alpha_numeric_space',
    ];

    public $createProducto_errors = [
        'codigo' => [
            'required' => 'El campo "codigo" no puede ir vacío',
            'is_unique' => 'Ya hay un producto registrado con este código',
            'alpha_numeric' => 'El campo "codigo" no admite caracteres especiales ni espacios',
        ],
        'nombre' => [
            'required' => 'El campo "nombre" no puede ir vacío',
            'alpha_numeric_space' => 'El campo "nombre" no admite caracteres especiales',
        ],
        'descripcion' => [
            'alpha_numeric_space' => 'El campo "descripcion" no admite caracteres especiales'
        ]
    ];

    public $updateProducto = [
        'codigo' => 'required|alpha_numeric',
        'nombre' => 'required|alpha_numeric_space',
        'descripcion' => 'alpha_numeric_space',
    ];

    public $updateProducto_errors = [
        'codigo' => [
            'required' => 'El campo "codigo" no puede ir vacío',
            'alpha_numeric' => 'El campo "codigo" no admite caracteres especiales ni espacios',
        ],
        'nombre' => [
            'required' => 'El campo "nombre" no puede ir vacío',
            'alpha_numeric_space' => 'El campo "nombre" no admite caracteres especiales',
        ],
        'descripcion' => [
            'alpha_numeric_space' => 'El campo "descripcion" no admite caracteres especiales'
        ]
    ];
}
