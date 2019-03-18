<?php

namespace main\Model;

use \main\Model;
use \main\Ticket;
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
       
        $sql->select("insert into tb_orders values (default, '$idcart', '$status','$vltotal',default,null);");
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

    public static function get_boleto($id_order,$bank){
        $order = Order::find_by_id($id_order);
        $status = Order::AGUARDANDO_PAGAMENTO;
        $sql = new Sql;
        $sql->select("update tb_orders set idstatus = '$status' where idorder = '$id_order';");
        $data = array();
        if($bank == 'itau'){
            $data['vltotal'] = $order['vltotal'];
            $data['vlfreight'] = $order['vlfreight'];
            $data['idorder'] = $order['idorder'];
            $data['desperson'] = $order['desperson'];
            $data['desaddress'] = $order['desaddress'];
            $data['descity'] = $order['descity'];
            $data['desstate'] = $order['desstate'];
            $data['deszipcode'] = $order['deszipcode'];
        }
        Ticket::ticket_factory($bank,$data);
    }

}
?>