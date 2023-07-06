<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface TodoService {
    function getTodos();
    function addTodo(Request $request);
    function updateTodo(Request $request);
    function deleteTodo(Request $request);
}


?>