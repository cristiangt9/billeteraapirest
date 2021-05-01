<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TransaccionTest extends TestCase
{
    /**
     * @test
     */
    public function cuandoEnvioTipoRecargaBilleteraYValorAStoreReciboSuccessTrueElValorY201()
    {
        $usuarioPrueba = $this->getUsuarioPrueba();
        $response = $this->post('api/v1/transacciones', [
            "tipo" => "recargarBilletera",
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"],
            "valor" => 2000
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '201')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->where("valor", '2000')
                        ->etc();
                })
                ->etc();
        });
    }
    /**
     * @test
     */
    public function cuandoEnvioTipoConsultarSaldoAStoreReciboSuccessTrueElSaldoY201()
    {
        $usuarioPrueba = $this->getUsuarioPrueba();
        $response = $this->post('api/v1/transacciones', [
            "tipo" => "consultarSaldo",
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '201')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->where("saldo", '2000.00')
                        ->etc();
                })
                ->etc();
        });
    }
    /**
     * @test
     */
    public function cuandoEnvioTipoSolicitudPagoAStoreReciboSuccessTrueElCodigoY201()
    {
        // durante el desarrollo se recibira el codigo luego se puede buscar otra manera de probar y obtener el codigo
        $usuarioPrueba = $this->getUsuarioPrueba();
        //me logeo
        $responseLogin = $this->post('api/v1/users/login', [
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        $token = json_decode($responseLogin->getContent(), true)["data"]["token"];
        $response = $this->post('api/v1/transacciones', [
            "tipo" => "solicitudPago",
            "token" => $token,
            "valor" => 50,
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '201')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->has("codigo")
                        ->etc();
                })
                ->etc();
        });
    }
    /**
     * @test
     */
    public function cuandoEnvioTipoConfirmacionPagoAStoreReciboSuccessTrueElSaldoRestanteY201()
    {
        $usuarioPrueba = $this->getUsuarioPrueba();
        //me logeo
        $responseLogin = $this->post('api/v1/users/login', [
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        // Guardo el token
        $token = json_decode($responseLogin->getContent(), true)["data"]["token"];
        // Hago la solicitud
        $responseSolicitud = $this->post('api/v1/transacciones', [
            "tipo" => "solicitudPago",
            "token" => $token,
            "valor" => 50,
            "documento" => $usuarioPrueba["documento"],
            "celular" => $usuarioPrueba["celular"]
        ]);
        // Guardo el token de confirmacion
        $tokenConfirmacion = json_decode($responseSolicitud->getContent(), true)["data"]["codigo"];

        $response = $this->post('api/v1/transacciones', [
            "tipo" => "confirmacionPago",
            "token" => $token,
            "tokenConfirmacion" => $tokenConfirmacion
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->where('success', true)
                ->where('code', '200')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->has("saldo")
                        ->etc();
                })
                ->etc();
        });
    }
}
