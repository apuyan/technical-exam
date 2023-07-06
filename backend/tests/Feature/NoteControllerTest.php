<?php

namespace Tests\Feature;

use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class NoteControllerTest extends TestCase
{

    public function test_simple_adding_of_note() : void {
        $this->deleteNoteRepository();
        $newNote = [
            "title" => "test-title",
            "text" => "test-text"
        ];
        $response = $this->post('/api/addNote',$newNote);
        $response->assertStatus(200);

        $noteList = $this->get('/api/getNotes')->collect();
        assertEquals(1, count($noteList));
    }

    public function test_simple_adding_and_then_deleting_of_note() : void {
        $this->deleteNoteRepository();
        $newNote = [
            "title" => "test-title",
            "text" => "test-text"
        ];
        $response = $this->post('/api/addNote',$newNote);
        $response->assertStatus(200);

        $noteList = $this->get('/api/getNotes')->collect();
        assertEquals(1, count($noteList));

        $noteIdToDelete = 1;
        $this->post('/api/deleteNote',["noteId" => $noteIdToDelete]);
        $noteList = $this->get('/api/getNotes')->collect();
        assertEquals(0, count($noteList));
    }

    public function test_simple_adding_and_then_updating_of_note() : void {
        $this->deleteNoteRepository();
        $newNote = [
            "title" => "test-title",
            "text" => "test-text"
        ];
        $response = $this->post('/api/addNote',$newNote);
        $response->assertStatus(200);

        $noteList = $this->get('/api/getNotes')->collect();


        assertEquals("test-title",$noteList[0]['title']);
        assertEquals("test-text",$noteList[0]['text']);

        $updateNote = [
            "noteId" => 1,
            "title" => "test-title-updated",
            "text" => "test-text-updated"
        ];
        $this->post('/api/updateNote',$updateNote);
        $noteList = $this->get('/api/getNotes')->collect();



        assertEquals("test-title-updated",$noteList[0]['title']);
        assertEquals("test-text-updated",$noteList[0]['text']);
    }

    private function deleteNoteRepository() {
        if(file_exists("note_repository.txt")) {
            unlink("note_repository.txt");
        }
    }
}
