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
        $response = $this->post('api/v1/users', [
            "documento" => "1757407323",
            "nombres" => "Cristian David Gonzalez Torres",
            "email" => "cristiangt910@gmail.com",
            "celular" => "31422877210"
        ]);
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
        //code...

    }
}
