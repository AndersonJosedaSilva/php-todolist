<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'tasks/TaskService.php';


$app = new \Slim\Slim();
// http://hostname/api/
$app->get('/', function() use ( $app ) {
    echo "Welcome to Task REST API";
});
/*
HTTP GET http://domain/api/tasks
RESPONSE 200 OK
[
  {
    "id": 1,
    "description": "Learn REST",
    "done": false
  },
  {
    "id": 2,
    "description": "Learn JavaScript",
    "done": false
  },
  {
    "id": 3,
    "description": "Learn English",
    "done": false
  }
]
*/
$app->get('/tasks/', function() use ( $app ) {
    $tasks = TaskService::listTasks();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($tasks);
});
/*
HTTP GET http://domain/api/tasks/1
RESPONSE 200 OK
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}
RESPONSE 204 NO CONTENT
*/
$app->get('/tasks/:id', function($id) use ( $app ) {
    $task = TaskService::getById($id);
    
    if($task) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($task);
    }
    else {
        $app->response()->setStatus(204);
    }
});
/*
HTTP POST http://domain/api/tasks
REQUEST Body
{
  "description": "Learn REST",
}
RESPONSE 200 OK Body
Learn REST added
*/
$app->post('/tasks/', function() use ( $app ) {
    $taskJson = $app->request()->getBody();
    $newTask = json_decode($taskJson, true);
    if($newTask) {
        $task = TaskService::add($newTask);
        echo "Task {$task['description']} added";
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});
/*
HTTP PUT http://domain/api/tasks/1
REQUEST Body
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}
RESPONSE 200 OK
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}
*/
$app->put('/tasks/', function() use ( $app ) {
    $taskJson = $app->request()->getBody();
    $updatedTask = json_decode($taskJson, true);
    
    if($updatedTask && $updatedTask['id']) {
        if(TaskService::update($updatedTask)) {
          echo "Task {$updatedTask['description']} updated";  
        }
        else {
          $app->response->setStatus('404');
          echo "Task not found";
        }
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});
/*
HTTP DELETE http://domain/api/tasks/1
RESPONSE 200 OK
Task with id = 1 was deleted
RESPONSE 404
Task with id = 1 not found
*/
$app->delete('/tasks/:id', function($id) use ( $app ) {
    if(TaskService::delete($id)) {
      echo "Task with id = $id was deleted";
    }
    else {
      $app->response->setStatus('404');
      echo "Task with id = $id not found";
    }
});
$app->run();
?>