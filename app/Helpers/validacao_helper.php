<?php
function validarSomenteLetrasENumeros($string) {
    return !!preg_match('/^[\w]+$/', $string);
}
function validarSomenteLetrasENumerosEEspaco($string) {
    return !!preg_match('/^[\w\s]+$/', $string);
}
function validarCampoObrigatorio($string) {
    return empty($string);
}