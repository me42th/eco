<?php

namespace main\Model;

use \main\Model;
use \main\DB\Sql;

class Order extends Model{

    const EM_ABERTO = 1;
    const AGUARDANDO_PAGAMENTO = 2;
    const PAGO = 3;
    const ENTREGUE = 4;

    public static function create($data){
        $idcart = $data['idcart'];
        $vltotal = $data['vltotal'];
        $status = Order::EM_ABERTO;
        $sql = new Sql;
        $sql->select("insert into tb_orders values (default, '$idcart', '$status','$vltotal',default);");
        return $sql->select("select max(idorder) from tb_orders;")[0]['max(idorder)'];
    }

    public static function find_by_id($id_order){
        $sql = new Sql;    
        $order = $sql->select(
                "select * from tb_orders tb_o 
                join tb_ordersstatus tb_os on tb_o.idstatus = tb_os.idstatus
                join tb_carts tb_c on tb_o.idcart = tb_c.idcart
                join tb_users tb_u on tb_u.iduser = tb_c.iduser
                join tb_persons tb_p on tb_p.idperson = tb_u.idperson
                join tb_addressescarts tb_ac on tb_ac.idcart = tb_c.idcart
                join tb_addresses tb_a on tb_a.idaddress = tb_ac.idaddress 
                where tb_o.idorder = '$id_order' and tb_ac.dtremoved is null;"
            );
        if(count($order) == 0)
            throw new \Exception('Pedido não encontrado');
        return $order[0];        
    }

    public static function boleto_data_by_order_id($id_order){
        $order = Order::find_by_id($id_order);
        // DADOS DO BOLETO PARA O SEU CLIENTE
        $dias_de_prazo_para_pagamento = 5;
        $taxa_boleto = 2.95;
        $data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
        $valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $valor_cobrado = str_replace(",", ".",$valor_cobrado);
        $valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

        $dadosboleto["nosso_numero"] = '12345678';  // Nosso numero - REGRA: M�ximo de 8 caracteres!
        $dadosboleto["numero_documento"] = '0123';	// Num do pedido ou nosso numero
        $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
        $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = "Nome do seu Cliente";
        $dadosboleto["endereco1"] = "Endere�o do seu Cliente";
        $dadosboleto["endereco2"] = "Cidade - Estado -  CEP: 00000-000";

        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
        $dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa banc�ria - R$ ".number_format($taxa_boleto, 2, ',', '');
        $dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
        $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% ap�s o vencimento";
        $dadosboleto["instrucoes2"] = "- Receber at� 10 dias ap�s o vencimento";
        $dadosboleto["instrucoes3"] = "- Em caso de d�vidas entre em contato conosco: xxxx@xxxx.com.br";
        $dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

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
        $dadosboleto["identificacao"] = "BoletoPhp - C�digo Aberto de Sistema de Boletos";
        $dadosboleto["cpf_cnpj"] = "";
        $dadosboleto["endereco"] = "Coloque o endere�o da sua empresa aqui";
        $dadosboleto["cidade_uf"] = "Cidade / Estado";
        $dadosboleto["cedente"] = "Coloque a Raz�o Social da sua empresa aqui";

    }

}
?>