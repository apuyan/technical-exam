<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Note {
    private int $noteId;
    private string $title;
    private string $text;


    function getNoteId() {
        return $this->noteId;
    }

    function getTitle() {
        return $this->title;
    }

    function getText() {
        return $this->text;
    }

    static function mapJson(Request $json) : Note {
        $note = new Note();
        if(isset($json->noteId)) {
            $note->noteId = $json->noteId;
        }
        if(isset($json->title)) {
            $note->title = $json->title;
        }
        if(isset($json->text)) {
            $note->text = $json->text;
        }
        return $note;
    }
}

?>