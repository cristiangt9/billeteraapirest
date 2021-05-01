<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    /**
     * Al no poder reiniciar la base desde esta app se implemento esta solución para 
     * centralizar el usuario de pruebas, pero esta solución nos obliga a que todas 
     * las pruebas deban ejecutarse para que pasen, no es la mejor solución para hacer
     * pruebas automatizadas, en caso de lazar a produccion se debe buscar otra solución
     */
    static public function getUsuarioPrueba()
    {
        return [
            "documento" => "1757407323",
            "nombres" => "Cristian David Gonzalez Torres",
            "email" => "cristiangt96@gmail.com",
            "celular" => "3142287726"
        ]; // 
    }
}
