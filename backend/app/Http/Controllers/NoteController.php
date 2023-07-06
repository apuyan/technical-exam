<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller implements NoteService
{
    //

    private static array $noteList = [];

    public function __construct() {
        self::$noteList = $this->getNotes();
    }

    public function addNote(Request $request) 
    {
        $note = new Note();
        $newNote = $note->mapJson($request);
        self::$noteList [] = [
            "noteId" => count(self::$noteList) + 1,
            "title" => $newNote->getTitle(),
            "text" => $newNote->getText()
        ];

        $this->updateNoteListRepository();
    }

    public function deleteNote(Request $request)
    {
        $noteId = $request->noteId;
        self::$noteList = $this->getNotes();
        for($i = 0;$i < count(self::$noteList);$i++) {
            if(self::$noteList[$i]['noteId'] == $noteId) {
                array_splice(self::$noteList,$i,1);
                $this->updateNoteListRepository();
                break;
            }
        }
    }

    public function updateNote(Request $request)
    {
        $note = new Note();
        $newNote = $note->mapJson($request);
        for($i = 0;$i < count(self::$noteList);$i++) {
            if(self::$noteList[$i]['noteId'] == $newNote->getNoteId()) {
                self::$noteList[$i]['title'] = $newNote->getTitle();
                self::$noteList[$i]['text'] = $newNote->getText();
                $this->updateNoteListRepository();
                break;
            }
        }
        return self::$noteList;
    }

    public function getNotes()
    {
        $jsonNotes = [];
        if(file_exists('note_repository.txt')) {
            $jsonNotes = json_decode(file_get_contents('note_repository.txt'),true);
        }
        else {
            file_put_contents('note_repository.txt', "[]");
        }
        return $jsonNotes;
    }

    private function updateNoteListRepository() {
        file_put_contents('note_repository.txt', json_encode(self::$noteList));
    }
}
