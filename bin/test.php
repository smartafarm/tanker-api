<?php
require('ElephantIOClient.class.php');

$elephant = new ElephantIOClient('http://127.0.0.1:8080');

$elephant->init();
$elephant->send(ElephantIOClient::TYPE_MESSAGE, null, null, 'Hello World!');
$elephant->keepAlive();
