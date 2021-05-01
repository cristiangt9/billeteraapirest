<?php

namespace App\Traits;


trait ApiCustomResponse
{
	protected function defaultJsonResponse($success, $title, $message = "", $messages = [], $data = null, $code = 200)
	{

		return response()->json(
			[
				"success" => $success,
				"title" => $title,
				"message" => $message,
				"messages" => $messages,
				"data" => $data,
				"code" => $code,
			],
			$code
		);
	}
	protected function defaultJsonResponseArray($success, $arrayResponse)
	{

		return response()->json(
			[
				"success" => $success,
				"title" => $arrayResponse["title"],
				"message" => $arrayResponse["message"],
				"messages" => $arrayResponse["messages"],
				"data" => $arrayResponse["data"],
				"code" => $arrayResponse["code"],
			],
			$arrayResponse["code"]
		);
	}

	protected function defaultJsonResponseWithoutData($success, $title, $message = "", $messages = [], $code = 200)
	{

		return response()->json(
			[
				"success" => $success,
				"title" => $title,
				"message" => $message,
				"messages" => $messages,
				"data" => null,
				"code" => $code
			],
			$code
		);
	}
}
