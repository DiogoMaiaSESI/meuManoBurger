<?php
namespace Model;
use Model\Connection;
require 'Connection.php';


$db = Connection::getInstance();

$sql = 'SELECT id_pedido FROM pedido ORDER BY id_pedido DESC LIMIT 1';
$stmt = $db->prepare($sql);
$stmt->execute();
echo $stmt->fetchColumn();

?>