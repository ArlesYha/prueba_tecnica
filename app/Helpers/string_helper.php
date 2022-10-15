<?php

/**
 * FUNCION: cleanStringToUpper
 * 
 * DESCRIPCION:
 * =================
 * Función que elimina posibles intentos de
 * inyección SQL.
 * 
 * @param  string   $cadena     recibe una cadena de texto.
 * 
 * @return string   $cadena     retorna una cadena de texto
 *                              sin parámetros de inyección SQL.
 * 
 */
function cleanStringToUpper($cadena): string {
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = str_ireplace("<script>","",$cadena);
    $cadena = str_ireplace("</script>","",$cadena);
    $cadena = str_ireplace("<script src","",$cadena);
    $cadena = str_ireplace("<script type=","",$cadena);
    $cadena = str_ireplace("SELECT * FROM","",$cadena);
    $cadena = str_ireplace("DELETE FROM","",$cadena);
    $cadena = str_ireplace("INSERT INTO","",$cadena);
    $cadena = str_ireplace("DROP TABLE","",$cadena);
    $cadena = str_ireplace("DROP DATABASE","",$cadena);
    $cadena = str_ireplace("TRUNCATE TABLE","",$cadena);
    $cadena = str_ireplace("SHOW TABLES","",$cadena);
    $cadena = str_ireplace("SHOW DATABASE","",$cadena);
    $cadena = str_ireplace("<?php","",$cadena);
    $cadena = str_ireplace("?>","",$cadena);
    $cadena = str_ireplace("--","",$cadena);
    $cadena = str_ireplace(">","",$cadena);
    $cadena = str_ireplace("<","",$cadena);
    $cadena = str_ireplace("{","",$cadena);
    $cadena = str_ireplace("}","",$cadena);
    $cadena = str_ireplace("[","",$cadena);
    $cadena = str_ireplace("]","",$cadena);
    $cadena = str_ireplace("^","",$cadena);
    $cadena = str_ireplace("==","",$cadena);
    $cadena = str_ireplace(";","",$cadena);
    $cadena = str_ireplace("::","",$cadena);
    $cadena = stripslashes($cadena);
    $cadena = trim($cadena);
    return $cadena;
}