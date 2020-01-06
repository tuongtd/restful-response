<?php

namespace tuongtd\RestResponse;

class Response
{
	public $meta = [];
	public $data = [];
	public $errors = [];
	public $status_code = 200;
	public $header_status_code = 200;

	const STATUS_CODE_RESPONSE_SUCCESS = 200;
	const STATUS_CODE_TOKEN_INVALID = 403;
	const STATUS_CODE_TOKEN_EXPIRED = 403;

	public function addAttribute($attr, $value)
	{
		$this->$attr = $value;
		return $this;
	}

	public function getMeta()
	{
		return $this->meta;
	}

	/**
	 * @param array $meta
	 * @return $this
	 */
	public function setMeta($meta)
	{
		$this->meta = $meta;
		return $this;
	}

	public function addMeta($name, $value)
	{
		$this->meta[$name] = $value;
		return $this;
	}

	public function setHeaderStatus($status)
	{
		$this->header_status_code = $status;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function setDataHtml($html)
	{
		$this->data['html'] = $html;
		return $this;
	}


	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @param array $error
	 * @return $this
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
		return $this;
	}

	public function addError($message)
	{
		$this->errors[] = $message;
		return $this;
	}


	public function getStatusCode()
	{
		return $this->status_code;
	}

	/**
	 * @param integer $status_code
	 * @return $this
	 */
	public function setStatusCode($status_code)
	{
		$this->status_code = $status_code;
		return $this;
	}

	public function ouput_reconstruct()
	{

	}

	/**
	 * @return mixed
	 */
	public function output_json()
	{
		$output = clone $this;

		if (empty($output->errors))
			unset($output->errors);

		if (!empty($output->errors) AND empty($output->data))
			unset($output->data);

		header('Content-Type: application/json');
		http_response_code($output->header_status_code);

		if (function_exists('response')) {
			return response()->json($output);
		}

		echo json_encode($output);
		die;
	}

	public function outputJson()
	{
		return $this->output_json();
	}
}