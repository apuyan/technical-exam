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

    public function test_simple_adding_note_three_times_and_then_check_if_fetched_data_is_in_reversed_order() {
        $this->deleteNoteRepository();
        $newNote = [
            "title" => "test-title",
            "text" => "test-text"      
        ];
        $this->post('/api/addNote',$newNote);
        $this->post('/api/addNote',$newNote);
        $this->post('/api/addNote',$newNote);

        $noteList = $this->get('/api/getNotes')->collect();
        for($i = 0;$i < count($noteList);$i++) {
            $expected = count($noteList) - $i;
            $actual = $noteList[$i]['noteId'];
            assertEquals($expected, $actual);
        }
    }

    private function deleteNoteRepository() {
        if(file_exists("note_repository.txt")) {
            unlink("note_repository.txt");
        }
    }
}
