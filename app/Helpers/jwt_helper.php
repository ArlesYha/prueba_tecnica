<?php

use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Usuarios;

/**
 * FUNCION: getJWTFromRequest
 * 
 * DESCRIPCION:
 * =================
 * Función que obtiene el valor de la cabecera authentication
 * y lo deconstruye para enviar solo el token de seguridad.
 * 
 * @param  request  Recibe el parametro authentication de la cabecera.
 * 
 * @return string   el retorno es un string con los datos del token
 * 
 */
function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception('Sin autorización');
    }

    return explode(' ', $authenticationHeader)[1];
}

/**
 * FUNCION: validateJWTFromRequest
 * 
 * DESCRIPCION:
 * =================
 * Función que valida la autenticidad del token
 * de seguridad.
 * 
 * @param  string  $encodedToken    Recibe el parametro authentication de la cabecera.
 * 
 */
function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $userModel = new Usuarios();
    $userModel->findByUser($decodedToken->user);
}

/**
 * FUNCION: getSignedJWTForUser
 * 
 * DESCRIPCION:
 * =================
 * Función que crea y devuelve el token
 * de seguridad.
 * 
 * @param  string   $user   usuario que del sistema que se
 *                          usa como parámetro para crear
 *                          el token de seguridad.
 * 
 * @return string   $jwt    token de seguridad.
 * 
 */
function getSignedJWTForUser(string $user): string
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'user' => $user,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(), 'HS256');

    return $jwt;
}