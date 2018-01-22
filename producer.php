<?php

// Classes necessarias para a execução
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Realiza conexão com o servidor do RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Declara a fila que irá utilizar
$channel->queue_declare('hello', true, false, false, false);

$count = 1;

while(true){
    // Prepara a mensagem e envia
    $msg = new AMQPMessage('['. $count .']' . ' Sejam bem-vindos(as) ao RabbitMQ');
    $channel->basic_publish($msg, '', 'hello');

    echo " [". $count ."] Mensagem enviada\n";
    
    $count++;
    
    sleep(1);
}

$channel->close();
$connection->close();
