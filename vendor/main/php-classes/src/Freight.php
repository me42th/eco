<?php

namespace main;


class Freight {

    const URL = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazoData?";
    const CEP = "40240550";
    const SESSION_ERROR = 'ERROR';

    public static function get_value($data){
        return $data;
    }

    
    private static function get_query_string($data){
        $query = http_build_query([
            //Opcional, porem precisa ser informado mesmo vazio
            'nCdEmpresa' => '', 
            //Opcional, porem precisa ser informado mesmo vazio 
            'sDsSenha' => '',   
            'nCdServico' => $data['nCdServico'],
            'sCepOrigem' => Freight::CEP,
            'sCepDestino' => $data['deszipcode'],
            'nVlPeso'=>$data['vlweight'],
            'nCdFormato'=>$data['nCdFormato'],
            'nVlComprimento'=>$data['vllength'],
            'nVlAltura' =>$data['vlheight'],
            'nVlLargura'=>$data['vlwidth'],
            'nVlDiametro'=>'0',
            'sCdMaoPropria'=>$data['sCdMaoPropria'],
            'nVlValorDeclarado'=>$data['amount'],
            'sCdAvisoRecebimento'=>$data['sCdAvisoRecebimento'],
            'sDtCalculo' => date('d/m/Y',time())
        ]);
        return Freight::URL.$query;
    }
    
    private static function get_data($nCdServico,$data){
        $data['nCdServico'] = $nCdServico;
        $data['nCdFormato'] = '1';
        $data['sCdMaoPropria'] = 'S';
        $data['sCdAvisoRecebimento'] = 'S';
        $data = simplexml_load_file(Freight::get_query_string($data))->Servicos->cServico;
        if($data->MsgErro[0] != '')
            MSN::set_error_msg('Erro: '.$data->MsgErro[0]);
        $data = [
            'vlfreight' => $data->Valor, 
            'nrdays' => $data->PrazoEntrega
        ];
        return $data;
    }

   
    public static function get_sedex_data($data){
        return Freight::get_data('40010',$data);
    }

    public static function get_sedex10_data($data){
        return Freight::get_data('40215',$data);
    }

    public static function get_sedexhoje_data($data){
        return Freight::get_data('40290',$data);
    }

    public static function get_pac_data($data){
        return Freight::get_data('41106',$data);
    }

    /**
     * Captura os dados do endereço a partir do CEP
     */
    public static function get_address($deszipcode){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/$deszipcode/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        $data = json_decode($data,true);       
        curl_close($ch);
        return $data;
    }

}

?>