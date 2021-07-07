<template>
  <div class="new-note">
    <label for="new-note">Add new note now</label>
    <textarea id="new-note" v-model="newNote" v-on:keydown.enter="addNote"></textarea>
    <p class="error-message" v-if="error.add">{{ error.add }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data(){
    return {
      error: {
        add: ''
      },
      newNote: ''
    }
  },
  methods:{
    addNote: function(){
      // send request to PHP script to add note
      axios({
        method: "POST",
        url: "./action/action.php",
        data: {
          action: "addNote",
          body: this.newNote
        }
      }).then(response => {
        // check if it is not success
        if (response.data.status === 'success'){
          // update data
          this.$parent.$children[1].fetchData();
          this.error.add = '';
          this.newNote = "";

        } else {
          // create an error message
          throw response.data.send;
        }
      })
        .catch(error => {
          this.error.add = error;
        });
    },
  }
}
</script>

<style scoped>
label{
  display: block;
  margin-bottom: 5px;
  color: #fff;
  font-weight: bold;
}
textarea{
  resize: none;
  width: 60%;
  height: 60px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;

}
.new-note{
  margin: 15px 0;
  padding: 5px 40px;
  text-align: center;
  background: #0071bc;
}
</style>
