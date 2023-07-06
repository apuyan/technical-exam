<?php

namespace Tests\Feature;

use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodoControllerTest extends TestCase
{
    public function test_simple_adding_of_entry_in_todo() : void {
        $this->deleteTodoRepository();
        $newTodo = [
            "entry" => "jogging"        
        ];
        $response = $this->post('/api/addTodo',$newTodo);
        $response->assertStatus(200);

        $todoList = $this->get('/api/getTodos')->collect();
        assertEquals(1, count($todoList));
    }

    public function test_simple_adding_of_entry_then_deleting_it() : void {
        $this->deleteTodoRepository();
        $newTodo = [
            "entry" => "jogging"        
        ];
        $response = $this->post('/api/addTodo',$newTodo);
        $response->assertStatus(200);

        $todoList = $this->get('/api/getTodos')->collect();
        assertEquals(1, count($todoList));

        $todoIdToDelete = 1;
        $this->post('/api/deleteTodo',["todoId" => $todoIdToDelete]);
        $todoList = $this->get('/api/getTodos')->collect();
        assertEquals(0, count($todoList));
    }

    public function test_simple_adding_and_then_updating_of_todo() : void {
        $this->deleteTodoRepository();
        $newTodo = [
            "entry" => "jogging"        
        ];
        $response = $this->post('/api/addTodo',$newTodo);
        $response->assertStatus(200);

        $todoList = $this->get('/api/getTodos')->collect();


        assertEquals("jogging",$todoList[0]['entry']);
        assertEquals(false,$todoList[0]['isDone']);

        $updateTodo = [
            "todoId" => 1,
            "entry" => "jogging",
            "isDone" => true
        ];
        $this->post('/api/updateTodo',$updateTodo);
        $todoList = $this->get('/api/getTodos')->collect();

        assertEquals("jogging",$todoList[0]['entry']);
        assertEquals(true,$todoList[0]['isDone']);
    }

    public function test_simple_adding_todo_three_times_and_then_check_if_fetched_data_is_in_reversed_order() {
        $this->deleteTodoRepository();
        $newTodo = [
            "entry" => "jogging"        
        ];
        $this->post('/api/addTodo',$newTodo);
        $this->post('/api/addTodo',$newTodo);
        $this->post('/api/addTodo',$newTodo);

        $todoList = $this->get('/api/getTodos')->collect();
        for($i = 0;$i < count($todoList);$i++) {
            $expected = count($todoList) - $i;
            $actual = $todoList[$i]['todoId'];
            assertEquals($expected, $actual);
        }
    }

    private function deleteTodoRepository() {
        if(file_exists("todo_repository.txt")) {
            unlink("todo_repository.txt");
        }
    }
}
