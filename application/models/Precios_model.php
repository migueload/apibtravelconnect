<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios_model extends CI_Model
{
    private $apiUrl = 'https://api.goldprice.dev/v1/prices';
    private $symbol = 'XAU-USD-SPOT';

    private $gramosPorOnza = '31.1034768';

    public function __construct()
    {
        parent::__construct();
    }

    public function getGold()
    {
        if (!function_exists('curl_init')) {
            return $this->error('La extensión cURL no está habilitada.');
        }

        $url = $this->apiUrl . '?' . http_build_query([
            'symbol' => $this->symbol
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($response === false) {
            log_message('error', 'Gold API: ' . $curlError);

            return $this->error(
                'No fue posible conectar con el proveedor de oro.'
            );
        }

        if ($httpCode !== 200) {
            log_message('error', 'Gold API HTTP: ' . $httpCode);

            return $this->error(
                'El proveedor respondió con un error.',
                $httpCode
            );
        }

        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->error('El proveedor devolvió un JSON inválido.');
        }

        if (
            !isset($json['symbols']) ||
            !is_array($json['symbols']) ||
            empty($json['symbols'])
        ) {
            return $this->error('No se encontraron cotizaciones.');
        }

        $oro = null;

        foreach ($json['symbols'] as $item) {
            if (
                isset($item['symbol'], $item['quote_currency'], $item['unit']) &&
                $item['symbol'] === 'XAU' &&
                $item['quote_currency'] === 'USD' &&
                $item['unit'] === 'troy_ounce' &&
                ($item['contract_type'] ?? null) === 'spot'
            ) {
                $oro = $item;
                break;
            }
        }

        if ($oro === null) {
            return $this->error('No se encontró el precio spot del oro.');
        }

        $precio = $oro['price'] ?? null;

        if (
            !is_string($precio) &&
            !is_int($precio)
        ) {
            return $this->error('Formato de precio inválido.');
        }

        $precio = (string) $precio;

        if (
            !preg_match('/^\d+(\.\d+)?$/', $precio) ||
            !function_exists('bccomp') ||
            !function_exists('bcdiv')
        ) {
            return $this->error(
                'Precio inválido o extensión BCMath no disponible.'
            );
        }

        if (bccomp($precio, '0', 8) <= 0) {
            return $this->error('El precio recibido no es válido.');
        }

        $precioGramo = bcdiv(
            $precio,
            $this->gramosPorOnza,
            8
        );

        return [
            'success' => true,
            'message' => 'Precio del oro consultado correctamente',
            'data' => [
                'metal' => 'GOLD',
                'symbol' => 'XAU',
                'currency' => 'USD',
                'unit' => 'troy_ounce',
                'contract_type' => 'spot',
                'price_per_ounce' => $precio,
                'price_per_gram' => $precioGramo,
                'provider' => 'goldprice.dev',
                'quoted_at' => $oro['computed_at'] ?? null,
                'fetched_at' => gmdate('Y-m-d\TH:i:s\Z'),
                'stale' => $oro['is_stale'] ?? null
            ]
        ];
    }


    public function getCasiterita(
        $precioEstano,
        $ley,
        $tipoLey = 'SNO2',
        $factorPago = '70',
        $cargos = '0'
    ) {
        if (!extension_loaded('bcmath')) {
            return [
                'success' => false,
                'message' => 'La extensión BCMath no está habilitada.'
            ];
        }

        $valores = [
            'precioEstano' => $precioEstano,
            'ley' => $ley,
            'factorPago' => $factorPago,
            'cargos' => $cargos
        ];

        foreach ($valores as $nombre => $valor) {
            if (
                !is_string($valor) &&
                !is_int($valor)
            ) {
                return [
                    'success' => false,
                    'message' => "Valor inválido: {$nombre}"
                ];
            }

            if (!preg_match('/^\d+(\.\d+)?$/', (string) $valor)) {
                return [
                    'success' => false,
                    'message' => "Formato inválido: {$nombre}"
                ];
            }
        }

        $precioEstano = (string) $precioEstano;
        $ley = (string) $ley;
        $factorPago = (string) $factorPago;
        $cargos = (string) $cargos;

        $tipoLey = strtoupper($tipoLey);

        if (!in_array($tipoLey, ['SN', 'SNO2'], true)) {
            return [
                'success' => false,
                'message' => 'El tipo de ley debe ser SN o SNO2.'
            ];
        }

        if (
            bccomp($precioEstano, '0', 8) <= 0 ||
            bccomp($ley, '0', 8) <= 0 ||
            bccomp($ley, '100', 8) > 0 ||
            bccomp($factorPago, '0', 8) < 0 ||
            bccomp($factorPago, '100', 8) > 0
        ) {
            return [
                'success' => false,
                'message' => 'Los valores están fuera del rango permitido.'
            ];
        }

        // Convertir la ley reportada a porcentaje de estaño metálico
        $leyMetalica = $tipoLey === 'SNO2'
            ? bcmul($ley, '0.7877', 8)
            : $ley;

        // Convertir porcentajes a factores decimales
        $factorLey = bcdiv($leyMetalica, '100', 12);
        $factorComercial = bcdiv($factorPago, '100', 12);

        // Valor teórico del contenido de estaño
        $valorTeorico = bcmul(
            $precioEstano,
            $factorLey,
            8
        );

        // Aplicar factor de pago
        $valorBruto = bcmul(
            $valorTeorico,
            $factorComercial,
            8
        );

        // Descontar cargos comerciales
        $valorNeto = bcsub($valorBruto, $cargos, 8);

        return [
            'success' => true,
            'message' => 'Estimación de casiterita calculada correctamente',
            'data' => [
                'mineral' => 'CASITERITA',
                'formula' => 'SnO2',
                'currency' => 'USD',
                'unit' => 'metric_tonne',
                'tin_price_usd_per_tonne' => $precioEstano,
                'assay_type' => $tipoLey,
                'assay_percentage' => $ley,
                'tin_grade_percentage' => $leyMetalica,
                'payable_factor_percentage' => $factorPago,
                'theoretical_value' => $valorTeorico,
                'gross_estimated_price' => $valorBruto,
                'charges_per_tonne' => $cargos,
                'net_estimated_price' => $valorNeto,
                'estimated_at' => gmdate('Y-m-d\TH:i:s\Z'),
                'disclaimer' => 'Estimación indicativa, no constituye una oferta firme de compra.'
            ]
        ];
    }


    private function error($message, $httpCode = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'http_code' => $httpCode
        ];
    }
}
