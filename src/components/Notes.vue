<script  lang="ts">
type Note = {
      noteId?: number,
      title?: string,
      text?: string,
      toUpdate? : boolean
    }
export default {
  data() {
    return {
      noteList: [] as Note[], 
      note: {} as Note,
      noteUpdate: {} as Note
    }
  },
  computed: {
    isNonNullNoteTitleAndText() {
      return this.note.text && this.note.text;
    }
  },
  mounted() {
    this.getNotes();
  },
  methods: {
    async addNote() {
      await fetch("http://127.0.0.1:8000/api/addNote", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.note)
      })
      .then(() => {
        this.note = {
          title: "",
          text: ""
        };
        this.getNotes();
      });
    },
    prepareUpdate(note : Note) {
      if(note.toUpdate == true) {
        note.toUpdate = false;
        this.noteUpdate = {};
        return;
      }
      note.toUpdate = true;
      this.noteUpdate = Object.assign({},note);
    },
    updateNote(note : Note) {
      if(this.noteUpdate.text && this.noteUpdate.text) {
        fetch("http://127.0.0.1:8000/api/updateNote", {
          method: "POST",
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.noteUpdate)
        })
        .then(() => {
          this.note = {
            title: "",
            text: ""
          };
          this.getNotes();
          note.toUpdate = false;
        });
      }
      else {
        alert("Title and text can't be empty");
      }
    },
    deleteNote(note : Note) {
      fetch("http://127.0.0.1:8000/api/deleteNote", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(note)
      })
      .then(() => {
        this.getNotes();
      });
    },
    async getNotes() {
      const response = await fetch("http://127.0.0.1:8000/api/getNotes");
      this.noteList = await response.json();
    }
  }
}

</script>

<template>
  <div>
    <tr>
      <td>Title : </td>
      <td><input v-model="note.title"></td>
    </tr>
    <tr>
      <td>Text : </td>
      <td><input v-model="note.text"> <button :disabled="!isNonNullNoteTitleAndText" @click="addNote()">Add note</button></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </div>
  <div class="card" style="display: inline-block; width:30vw;margin-top:30px;">
    <span style="padding:5px">My Notes</span>
    <ul v-for="note in noteList">
      <div class="card">
        <div class="container">
          <div class="row mb-2"> 
            <div class="col-md-12">
              <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">                               
                  <h3 class="card-title d-flex">
                    <template v-if="note.toUpdate">
                      <input placeholder="Update title" v-model="noteUpdate.title">
                    </template>
                    <template v-else>
                      <b>{{note.title}}</b> 
                    </template>
                    <a @click="prepareUpdate(note)" class="btn btn-sm btn-danger ml-3" href="#">{{ note.toUpdate ? "Cancel" : "Edit" }}</a>
                    <a v-if="note.toUpdate" @click="updateNote(note)" class="btn btn-sm btn-danger ml-3" href="#" style="margin-left: 5px;">{{ "Update" }}</a>
                    <a @click="deleteNote(note)" class="btn btn-sm btn-danger ml-3" href="#" style="margin-left: 5px;">{{ "Delete" }}</a>
                  </h3>
                  <p class="card-text">
                    <template v-if="note.toUpdate">
                      <input placeholder="Update text" v-model="noteUpdate.text">
                    </template>
                    <template v-else>
                      <b>{{note.text}}</b> 
                    </template>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </ul>
  </div>
  
</template>

<style scoped>
.card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(142, 167, 149, 0.2);
  transition: 0.3s;
  padding: 2px;
}

/* On mouse-over, add a deeper shadow */
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.container {
  padding: 2px 16px;
}
</style>
