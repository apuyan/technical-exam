<script  lang="ts">

export default {
  data() {
    return {
      todoList: [],
      todo: {
        entry: null,
        isDone: false
      }
    }
  },
  methods: {
    addTodo() {
      this.todoList.push(this.todo);
      this.todo = {
        entry: null,
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
  <ul v-for="todo in todoList">
    <li><input type="checkbox" v-model="todo.isDone"> {{ todo.entry }}</li>
  </ul>
</template>
