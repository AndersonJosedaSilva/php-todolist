<?php
require 'vendor/autoload.php';



$app = new \Slim\Slim();

$app->get('/', function() use ($app){
    echo "Welcome to REST API";
});
$app->get('/tasks', function() use ($app){

    $task = getTasks();
    echo json_encode($task);
    
});

function getTasks(){
     $task[] = array(
        array('id'=>'1','description'=>'learn REST','done' => 'false'),
        array('id'=>'2','description'=>'learn JavaScript','done' => 'false'),
          
        );
    return $task;
}
$app->run();
?>