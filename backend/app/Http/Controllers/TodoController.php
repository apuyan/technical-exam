<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller implements TodoService
{
    //
    private static array $todoList = [];

    public function __construct() {
        self::$todoList = $this->getTodos();
    }

    public function addTodo(Request $request) 
    {
        $todo = new Todo();
        $newTodo = $todo->mapJson($request);
        self::$todoList [] = [
            "todoId" => count(self::$todoList) + 1,
            "entry" => $newTodo->getEntry(),
            "isDone" => $newTodo->isDone()
        ];

        $this->updateTodoListRepository();
        return $request;
    }

    public function deleteTodo(Request $request)
    {
        $todoId = $request->todoId;
        self::$todoList = $this->getTodos();
        for($i = 0;$i < count(self::$todoList);$i++) {
            if(self::$todoList[$i]['todoId'] == $todoId) {
                array_splice(self::$todoList,$i,1);
                $this->updateTodoListRepository();
                break;
            }
        }
    }

    public function updateTodo(Request $request)
    {
        $todo = new Todo();
        $newTodo = $todo->mapJson($request);
        for($i = 0;$i < count(self::$todoList);$i++) {
            if(self::$todoList[$i]['todoId'] == $newTodo->getTodoId()) {
                self::$todoList[$i]['entry'] = $newTodo->getEntry();
                self::$todoList[$i]['isDone'] = $newTodo->isDone();
                $this->updateTodoListRepository();
                break;
            }
        }
        return self::$todoList;
    }

    public function getTodos()
    {
        $jsonTodo = [];
        if(file_exists('todo_repository.txt')) {
            $jsonTodo = json_decode(file_get_contents('todo_repository.txt'),true);
        }
        else {
            file_put_contents('todo_repository.txt', "[]");
        }
        return $jsonTodo;
    }

    private function updateTodoListRepository() {
        file_put_contents('todo_repository.txt', json_encode(self::$todoList));
    }
}
