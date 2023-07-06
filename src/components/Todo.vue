<script  lang="ts">
type Todo = {
  todoId? : number,
  entry? : string,
  isDone? : boolean,
  toUpdate? : boolean
}
export default {
  
  data() {
    return {
      todoList: [] as Todo[],
      todo: {} as Todo,
      todoUpdate: {} as Todo
    }
  },
  mounted() {
    this.getTodos();
  },
  methods: {
    async addTodo() {
      await fetch("http://127.0.0.1:8000/api/addTodo", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.todo)
      })
      .then(() => {
        this.todo = {
          entry: "",
          isDone: false
        };
        this.getTodos();
      });
    },
    prepareUpdate(todo : Todo) {
      if(todo.toUpdate == true) {
        todo.toUpdate = false;
        this.todoUpdate = {};
        return;
      }
      todo.toUpdate = true;
      this.todoUpdate = Object.assign({},todo);
    },
    updateTodo(todo : Todo) {
      if(this.todoUpdate.entry) {
        this.todoUpdate.isDone = todo.isDone;
        fetch("http://127.0.0.1:8000/api/updateTodo", {
          method: "POST",
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.todoUpdate)
        })
        .then(() => {
          this.todoUpdate = {
            entry: "",
            isDone: false
          };
          todo.toUpdate = false;
          this.getTodos();
        });
      }
      else {
        alert("Entry can't be empty");
      }
    },
    deleteTodo(todo : Todo) {
      fetch("http://127.0.0.1:8000/api/deleteTodo", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(todo)
      })
      .then(() => {
        this.getTodos();
      });
    },
    async getTodos() {
      const response = await fetch("http://127.0.0.1:8000/api/getTodos");
      this.todoList = await response.json();
    }
  }
}

</script>

<template>
  <div>
    <tr>
      <td>Todo : </td>
      <td><input v-model="todo.entry"> <button :disabled="!todo.entry" @click="addTodo()">Add todo</button></td>
    </tr>
  </div>
  <div class="card" style="width:30vw;margin-top:30px;">
    <span style="padding:5px">My Todos</span>
    <ul style="list-style-type: none" v-for="todo in todoList">
      <li><input :disabled="todo.toUpdate" @change="todoUpdate = Object.assign({},todo);updateTodo(todo)" type="checkbox" v-model="todo.isDone"> 
        <template v-if="todo.toUpdate">
          <input placeholder="Update entry" v-model="todoUpdate.entry">
        </template>
        <template v-else>
          <b>{{todo.entry}}</b> 
        </template>
        <a @click="prepareUpdate(todo)" class="btn btn-sm btn-danger ml-3" href="#">{{ todo.toUpdate ? "Cancel" : "Edit" }}</a>
        <a v-if="todo.toUpdate" @click="updateTodo(todo)" class="btn btn-sm btn-danger ml-3" href="#" style="margin-left: 5px;">{{ "Update" }}</a>
        <a @click="deleteTodo(todo)" class="btn btn-sm btn-danger ml-3" href="#" style="margin-left: 5px;">{{ "Delete" }}</a>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(142, 167, 149, 0.2);
  transition: 0.3s;
  padding: 20px 16px;
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