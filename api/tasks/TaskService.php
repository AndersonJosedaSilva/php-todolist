<?php


class TaskService {
    
    public static function listTasks(){
         $db = Connectionfactory::getDB();
         $tasks = array();
         
         foreach($db->tasks() as $task){
             $tasks[] = array(
                 'is'=> $task['id'],
                 'description'=> $task['description'],
                 'done'=> $task['done']
                 );
             
         }
         
        $tasks;
        
    }
    
    
    
}

?>