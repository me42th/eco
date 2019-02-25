<?php

namespace main;


class Freight {

    const URL = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazoData?";
    const CEP = "40240550";
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
        $data = simplexml_load_file(Freight::get_query_string($data));
        $data = [
                'vlfreight' => $data->Servicos->cServico->Valor, 
                'nrdays' => $data->Servicos->cServico->PrazoEntrega
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



}

?>