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

    /**
     * Cria um novo pedido no banco de dados
     */
    public static function create($data){
        $idcart = $data['idcart'];
        $vltotal = $data['vltotal'];
        $status = Order::EM_ABERTO;
        $sql = new Sql;        
        $sql->select("insert into tb_orders values (default, '$idcart', '$status','$vltotal',default,null);");
        return $sql->select("select max(idorder) from tb_orders;")[0]['max(idorder)'];
    }

    /**
     * Retorna todos os pedidos do usuário informado ou do usuário da sessão se nada for informado
     */
    public static function list_by_user($user_id = null){
        
        if(is_null($user_id)){
            $user_id = User::find_by_session()['iduser'];
        }
        $sql = new Sql;
        return $sql->select("select * from tb_orders tb_o 
        join tb_ordersstatus tb_os on tb_o.idstatus = tb_os.idstatus
        join tb_carts tb_c on tb_o.idcart = tb_c.idcart
        join tb_addressescarts tb_ac on tb_ac.idcart = tb_c.idcart
        join tb_addresses tb_a on tb_a.idaddress = tb_ac.idaddress 
        where tb_c.iduser = '$user_id' and tb_ac.dtremoved is null and tb_o.dtremoved is null;");
    }

    /**
     * Localiza os dados referentes ao pedido: carrinho, usuário, dados pessoais do usuário
     * e endereço para entrega
     */
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
                where tb_o.idorder = '$id_order' and tb_ac.dtremoved is null and tb_o.dtremoved is null;"
            );
        if(count($order) == 0)
            throw new \Exception('Pedido não encontrado');
        return $order[0];        
    }

    /**
     * Seta o status do pedido com as constantes declaradas no inicio desta classe
     */
    public static function set_status($id_order,$status){
        $sql = new Sql;
        $sql->select("update tb_orders set idstatus = '$status' where idorder = '$id_order';");
    }

    /**
     * Retorna html com os dados da compra e do cliente para pagamento
     */
    public static function get_boleto($id_order,$bank){
        $order = Order::find_by_id($id_order);
        $status = Order::AGUARDANDO_PAGAMENTO;
        Order::set_status($id_order,Order::AGUARDANDO_PAGAMENTO);        
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

    public static function list_all(){
        $sql = new Sql;
        $orders = $sql->select(
            'select * from tb_orders as a 
            join tb_carts as b using(idcart) 
            join tb_users as c using(iduser) 
            join tb_persons as d using(idperson) 
            join tb_ordersstatus as e using(idstatus) where dtremoved is null'
        );
        if(count($orders) == 0)
            throw new \Exception('Nenhum pedido realizado');
        return $orders;
    }

    public static function list_status(){
        $sql = new Sql;
        $data = $sql->select("select * from tb_ordersstatus;");
        return $data;
    }

    public static function delete($idorder){
        $dtremoved = date('Y-m-d h:i:s');
        $sql = new Sql;
        $sql->select("update tb_orders set dtremoved = '$dtremoved' where idorder = $idorder");
    }
}
?>