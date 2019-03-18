<?php

namespace main;

class Ticket{
    public static function ticket_factory($bank,$data){
        switch($bank){
            case 'itau':
                Ticket::itau_factory($data);

        }
    }

    private static function itau_factory($data){
        // DADOS DO BOLETO PARA O SEU CLIENTE
        $dadosboleto['dias_de_prazo_para_pagamento'] = 5;
        $dadosboleto['taxa_boleto'] = 2.95;
        $dadosboleto['data_venc'] = date("d/m/Y", time() + ($dadosboleto['dias_de_prazo_para_pagamento'] * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
        $dadosboleto['valor_cobrado'] = $data['vltotal']+$data['vlfreight']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $dadosboleto['valor_cobrado'] = str_replace(",", ".",$dadosboleto['valor_cobrado']);
        $dadosboleto['valor_boleto']=number_format($dadosboleto['valor_cobrado']+$dadosboleto['taxa_boleto'], 2, ',', '');
        //Pulo do Gato Boleto Registrado
        $dadosboleto["nosso_numero"] = '12345678';  // Nosso numero - REGRA: Máximo de 8 caracteres! 
        $dadosboleto["numero_documento"] = $data['idorder'];	// Num do pedido ou nosso numero
        $dadosboleto["data_vencimento"] = $dadosboleto['data_venc']; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
        $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"] = $dadosboleto['valor_boleto']; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = $data['desperson'];
        $dadosboleto["endereco1"] = $data['desaddress'];
        $dadosboleto["endereco2"] = $data['descity']." ".$data['desstate']." CEP:".$data['deszipcode'];

        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja SHEEP";
        $dadosboleto["demonstrativo2"] = "Valor referente a <br>Taxa bancária - R$ ".number_format($dadosboleto['taxa_boleto'], 2, ',', '');
        $dadosboleto["demonstrativo3"] = "Sheep by Cabra IO- http://cabra.io";
        $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
        $dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
        $dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: contato@cabra.io";
        $dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Sheep by Cabra IO - http://cabra.io";

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "";
        $dadosboleto["valor_unitario"] = "";
        $dadosboleto["aceite"] = "";		
        $dadosboleto["especie"] = "R$";
        $dadosboleto["especie_doc"] = "";


        // ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


        // DADOS DA SUA CONTA - ITA�
        $dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
        $dadosboleto["conta"] = "13877";	// Num da conta, sem digito
        $dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

        // DADOS PERSONALIZADOS - ITA�
        $dadosboleto["carteira"] = "175";  // C�digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

        // SEUS DADOS
        $dadosboleto["identificacao"] = "Sheep - Framework Open Source para Comércio Virtual Cabra IO";
        $dadosboleto["cpf_cnpj"] = "42 3.14 0201";
        $dadosboleto["endereco"] = "Rua Nagé 20";
        $dadosboleto["cidade_uf"] = "Salvador / Bahia";
        $dadosboleto["cedente"] = "Cabra IO Gestão Ágil de Projetos";
        
        include("vendor/cobregratis/boletophp/include/funcoes_itau.php"); 
        include("vendor/cobregratis/boletophp/include/layout_itau.php");
       
  

    }
}
?>