<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    /**
     * @test
     */
    public function cuandoEnvioLosDatosDeUsuarioNuevoReciboSuccessTrueUnTokenY201()
    {
        // para que este test pase debo garantizar que la base no tenga el usuario que voy a crear
        $usuarioPrueba = $this->getUsuarioPrueba(); // se encuentra en TestCase
        $response = $this->post('api/v1/users', $usuarioPrueba);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '201')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->has("token")
                        ->etc();
                })
                ->etc();
        });

    }
    /**
     * @test
     */
    public function cuandoEnvioDocumentoYCelularDeUnUsuarioRegistradoALoginReciboSuccessTrueUnTokenY200()
    {
        $usuarioPrueba = $this->getUsuarioPrueba();
        $response = $this->post('api/v1/users/login', [
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '200')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->has("token")
                        ->etc();
                })
                ->etc();
        });

    }
    
}
