<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface NoteService {
    function addNote(Request $request);
    function deleteNote(Request $request);
    function updateNote(Request $request);
    function getNotes();
}




?>