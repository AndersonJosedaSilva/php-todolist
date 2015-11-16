<?php
require 'vendor/autoload.php';



$app = new \Slim\Slim();

$app->get('/', function() use ($app){
    echo "Welcome to REST API";
});

//http://domain/api/tasks
$app->get('/tasks', function() use ($app){

    $tasks = getTasks();
    //Define qual é o tipo de resposta
    $app->response()->header('Content-type','application/json');
    echo json_encode($tasks);
    
});
//http://domain/api/tasks/1
//get a task by id
/*
http get http://domain/api/tasks/1
RESPONSE 200 ok
 {
    "id": "1",
    "description": "learn REST",
    "done": "false"
  }
  RESPONSE 204 no content
*/
$app->get('/tasks/:id',function($id) use ($app){
   $tasks = getTasks();
   $index = array_search($id,array_column($tasks,'id'));
   
   if($index > -1){
       
   $app->response()->header('Content-Type','application/json');
   echo json_encode($tasks[$index]);
    
   }
   else{
    $app->response()->setStatus(204);
    echo "Not found";
        
   }
   
   
});

/*
HTTP POST http://domain/api/tasks
REQUEST  body
{
 "description": "learn REST",
}
RESPONSE  Body
Learn REST added

*/
$app->post('/tasks', function() use($app){
    
   $taskJson =  $app->request()->getBody(); 
   $task = json_decode($taskJson);
    if($task ){
        echo "{$task->description} added";
        
    }
    else{
        $app->response()->setstatus(400);
        echo "MalFormat JSON";
        
    }
    
});


//TODO move it to a DAO class
function getTasks(){
     $tasks = array(
        array('id'=>'1','description'=>'learn REST','done' => 'false'),
        array('id'=>'2','description'=>'learn JavaScript','done' => 'false'),
          
        );
    return $tasks;
}


$app->run();
?>