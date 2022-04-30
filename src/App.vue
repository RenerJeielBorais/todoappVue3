<template>
  <TodoComposition />
</template>
//* Template Block and for html elements

<script>
import TodoComposition from "./components/TodoComposition.vue";

export default {
  name: "App",
  components: {
    TodoComposition,
  },
};
</script>
//* Script block for javascript and vue syntax

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
//*Style block used for CSS styling and styles applied to the component
