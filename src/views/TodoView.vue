<script  lang="ts">
import Todo from '@/components/Todo.vue';
export default {
  components: {
    Todo
  }
}
</script>
<template>
  <div class="about">
    <Todo/>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
