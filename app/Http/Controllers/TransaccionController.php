<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SoapClient\BaseSoapController;
use App\Http\Controllers\SoapClient\InstanceSoapClient;
use Illuminate\Http\Request;

class TransaccionController extends BaseSoapController
{

    private $service;

    public function __construct()
    {

        self::setWsdl('http://billeteraapisoap.test/api/v1/transaccion/server?wsdl');
        $this->service = InstanceSoapClient::init();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has("tipo")) {
            $tipo = $request->tipo;
            if ($tipo === 'recargarBilletera') {
                return $this->recargarBilletera($request, $this);
            }
        } else {
            return $this->defaultJsonResponseWithoutData(false, "Debe incluir un tipo de transaccion", null, null, 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function recargarBilletera(Request $request)
    {
        try {
            // recoger la informacion
            $rules = [
                "documento" => "required",
                "celular" => "required",
                "valor" => "required"
            ];
            $inputs = [
                "documento" => $request["documento"],
                "celular" => $request["celular"],
                "valor" => $request["valor"]
            ];
            // validar 
            $validator = $this->validatorInput($inputs, $rules);

            if (!$validator->validated) {
                return $this->defaultJsonResponse(false, "Datos faltantes o incorrectos", "Uno o mas datos son invalidos", $validator->errors, 422);
            }

            $response = $this->service->recargarSaldo($inputs);
            $responseProccesed = $this->keyValueToArry($this->responseArrayToArray($response->recargarSaldoResult));
            if ($responseProccesed["success"] != "true") {
                return $this->defaultJsonResponseArray(false, $responseProccesed);
            }

            return $this->defaultJsonResponseArray(true, $responseProccesed);
        } catch (\Exception $e) {
            return $this->defaultJsonResponseWithoutData(false, "Lo sentimos, pero algo fallo", $e->getMessage(), null, 422);
        }
    }
}
