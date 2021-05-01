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
    public function cuandoEnvioTipoRecargaBilleteraYvalorAStoreReciboSuccessTrueElValorY201()
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
}