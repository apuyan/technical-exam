<script  lang="ts">
type Todo = {
  todoId? : number,
  entry? : string,
  isDone? : boolean
}
export default {
  
  data() {
    return {
      todoList: [] as Todo[],
      todo: {} as Todo
    }
  },
  methods: {
    addTodo() {
      this.todoList.push(this.todo);
      this.todo = {
        entry: "",
        isDone: false
      };
    }
  }
}

</script>

<template>
  <div>
    <tr>
      <td>Todo : </td>
      <td><input v-model="todo.entry"></td>
    </tr>
    <tr>
      <td><button @click="addTodo()">Add todo</button></td>
    </tr>
  </div>
  <div class="card" style="display: inline-block; width:30vw">
    <ul v-for="todo in todoList">
      <li><input type="checkbox" v-model="todo.isDone"> {{ todo.entry }}</li>
    </ul>
  </div>
</template>

<style>
.card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(142, 167, 149, 0.2);
  transition: 0.3s;
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