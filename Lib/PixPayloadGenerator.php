<?php
namespace Lib;

class PixPayloadGenerator
{
    // IDs dos campos EMV
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_CRC16 = '63';

    // Sub-campos
    const ID_GUI = '00';
    const ID_KEY = '01';
    const ID_TXID = '05';

    private $chavePix;
    private $nomeRecebedor;
    private $cidadeRecebedor;
    private $valor;
    private $txid;

    public function setChavePix($chavePix) {
        $this->chavePix = preg_replace('/[^\w@.-]/', '', $chavePix);
        return $this;
    }

    public function setNomeRecebedor($nomeRecebedor)
    {
        $this->nomeRecebedor = preg_replace('/[^a-zA-Z0-9\s]/', '', $nomeRecebedor); // Remove caracteres especiais
        return $this;
    }

    public function setCidadeRecebedor($cidadeRecebedor)
    {
        $this->cidadeRecebedor = preg_replace('/[^a-zA-Z0-9\s]/', '', $cidadeRecebedor); // Remove caracteres especiais
        return $this;
    }

    public function setValor($valor)
    {
        $this->valor = number_format($valor, 2, '.', '');
        return $this;
    }

    public function setTxid($txid)
    {
        $this->txid = preg_replace('/[^a-zA-Z0-9]/', '', $txid); // Remove caracteres especiais
        return $this;
    }

    // --- [FIM DA CORREÇÃO] ---

    private function formatarCampo($id, $valor)
    {
        $tamanho = str_pad(strlen($valor), 2, '0', STR_PAD_LEFT);
        return $id . $tamanho . $valor;
    }

    private function getMerchantAccountInformation()
    {
        $gui = $this->formatarCampo(self::ID_GUI, 'br.gov.bcb.pix');
        $key = $this->formatarCampo(self::ID_KEY, $this->chavePix);
        return $this->formatarCampo(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key);
    }

    private function getAdditionalDataFieldTemplate()
    {
        $txid = $this->formatarCampo(self::ID_TXID, $this->txid);
        return $this->formatarCampo(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    public function getPayload()
    {
        $payload = $this->formatarCampo(self::ID_PAYLOAD_FORMAT_INDICATOR, '01') .
            $this->getMerchantAccountInformation() .
            $this->formatarCampo(self::ID_MERCHANT_CATEGORY_CODE, '0000') .
            $this->formatarCampo(self::ID_TRANSACTION_CURRENCY, '986') .
            $this->formatarCampo(self::ID_TRANSACTION_AMOUNT, $this->valor) .
            $this->formatarCampo(self::ID_COUNTRY_CODE, 'BR') .
            $this->formatarCampo(self::ID_MERCHANT_NAME, $this->nomeRecebedor) .
            $this->formatarCampo(self::ID_MERCHANT_CITY, $this->cidadeRecebedor) .
            $this->getAdditionalDataFieldTemplate();

        // Aqui NÃO coloca 6304 ainda — ele é adicionado apenas dentro do getCRC16()
        return $payload . $this->getCRC16($payload);
    }

    private function getCRC16($payload) {
    $payload .= self::ID_CRC16 . '04';

    $polinomio = 0x1021;
    $resultado = 0xFFFF;

    if (($length = strlen($payload)) > 0) {
        for ($offset = 0; $offset < $length; $offset++) {
            $resultado ^= (ord($payload[$offset]) << 8);
            for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                if (($resultado <<= 1) & 0x10000) {
                    $resultado ^= $polinomio;
                }
                $resultado &= 0xFFFF;
            }
        }
    }

    return self::ID_CRC16 . '04' . strtoupper(str_pad(dechex($resultado), 4, '0', STR_PAD_LEFT));
}
}
