<?php

//mysql> desc tb_addresses;
//+---------------+--------------+------+-----+-------------------+----------------+
//| Field         | Type         | Null | Key | Default           | Extra          |
//+---------------+--------------+------+-----+-------------------+----------------+
//| idaddress     | int(11)      | NO   | PRI | NULL              | auto_increment |
//| idperson      | int(11)      | NO   | MUL | NULL              |                |
//| desaddress    | varchar(128) | NO   |     | NULL              |                |
//| descomplement | varchar(32)  | YES  |     | NULL              |                |
//| descity       | varchar(32)  | NO   |     | NULL              |                |
//| desstate      | varchar(32)  | NO   |     | NULL              |                |
//| descountry    | varchar(32)  | NO   |     | NULL              |                |
//| nrzipcode     | int(11)      | NO   |     | NULL              |                |
//| dtregister    | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
//+---------------+--------------+------+-----+-------------------+----------------+

namespace main\Model;

use \main\Model;
use \main\DB\Sql;
use \main\Freight;

class Address extends Model{

    

}
?>