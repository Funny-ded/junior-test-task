<template>
  <div>
    <notes-header></notes-header>
    <notes></notes>
    <adder></adder>
    <notes-footer></notes-footer>
  </div>
</template>

<script>
import header from './components/header.vue'
import notes from './components/notes.vue'
import adder from './components/adder.vue'
import footer from './components/footer'

export default {
  components: {
    'notes-header': header,
    'notes': notes,
    'adder': adder,
    'notes-footer': footer
  },
  data () {
    return {

    }
  }
}
</script>

<style>
body{
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  background: #eee;
  margin: 4px 0;
}
.error-message{
  color: red;
}
</style>
