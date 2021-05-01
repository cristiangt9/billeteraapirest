<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $usuarioPrueba = [
        "documento" => "1757407323",
        "nombres" => "Cristian David Gonzalez Torres",
        "email" => "cristiangt912@gmail.com",
        "celular" => "31422877212"
    ];
    /**
     * @test
     */
    public function cuandoEnvioLosDatosDeUsuarioNuevoReciboSuccessTrueUnTokenY201()
    {
        // para que este test pase debo garantizar que la base no tenga el usuario que voy a crear
        $response = $this->post('api/v1/users', $this->usuarioPrueba);
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
        $response = $this->post('api/v1/users/login', [
            "documento" => $this->usuarioPrueba["documento"],
            "celular" => $this->usuarioPrueba["celular"]
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
