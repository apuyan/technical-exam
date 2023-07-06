<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Todo {
    private int $todoId;
    private string $entry;
    private bool $isDone;



    function getTodoId() : int {
        return $this->todoId;
    }

    function getEntry() : string {
        return $this->entry;
    }

    function isDone() : bool {
        return $this->isDone;
    }

    static function mapJson(Request $json) : Todo {
        $todo = new Todo();
        if(isset($json->todoId)) {
            $todo->todoId = $json->todoId;
        }
        if(isset($json->entry)) {
            $todo->entry = $json->entry;
        }
        if(isset($json->isDone)) {
            $todo->isDone = $json->isDone;
        }
        else {
            $todo->isDone = false;
        }
        return $todo;
    }
}

?>