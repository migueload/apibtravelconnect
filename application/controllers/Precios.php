
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios extends RestApi_Controller
{
    public function __construct()
    {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        $this->load->model('Precios_model');
    }

    /**
     * GET - Precio internacional del oro
     */
    public function getGold()
    {
        if ($this->input->method(TRUE) !== 'GET') {
            return $this->response([
                'success' => false,
                'message' => 'Método no permitido'
            ], 405);
        }

        $resultado = $this->Precios_model->getGold();

        $status = $resultado['success'] ? 200 : 502;

        return $this->response($resultado, $status);
    }

    public function getCasiterita()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            return $this->response([
                'success' => false,
                'message' => 'Método no permitido. Utilice POST.'
            ], 405);
        }

        $body = $this->input->raw_input_stream;

        $datos = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE ||
            !is_array($datos)) {

            return $this->response([
                'success' => false,
                'message' => 'El cuerpo de la solicitud debe ser un JSON válido.'
            ], 400);
        }

        $campos = [
            'precioEstano',
            'ley'
        ];

        foreach ($campos as $campo) {

            if (!array_key_exists($campo, $datos) ||
                $datos[$campo] === null ||
                $datos[$campo] === '') {

                return $this->response([
                    'success' => false,
                    'message' => 'Campo obligatorio: ' . $campo
                ], 422);
            }
        }

        $resultado = $this->Precios_model->getCasiterita(
            $datos['precioEstano'],
            $datos['ley'],
            $datos['tipoLey'] ?? 'SNO2',
            $datos['factorPago'] ?? '70',
            $datos['cargos'] ?? '0'
        );

        $status = $resultado['success'] ? 200 : 422;

        return $this->response($resultado, $status);
    }
}
