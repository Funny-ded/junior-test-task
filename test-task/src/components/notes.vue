<template>
  <div>
    <div class="search">
      <input type="text" v-model="search" placeholder="Search note">
      <button id="search" v-on:click="fetchData">
        <img src="https://image.flaticon.com/icons/png/512/58/58427.png" alt="search">
      </button>
    </div>
    <ul v-if="!error.fetch">
      <li class="note" v-for="(note, id) in notes">
        <p class="body" v-show="!note.edit" v-on:click="editModeOn(id)">{{ note.body }}</p>
        <div class="edit-note" v-show="note.edit">
          <textarea v-on:keydown.enter="editNote(id)" ref="editedNote">{{ note.body }}</textarea>
          <p class="error-message"  v-if="error.update">{{ error.update }}</p>
          <p class="error-message" v-if="error.delete">{{ error.delete }}</p>
        </div>
        <div class="delete">
          <button class="delete" v-on:click="deleteNote(id)">
            <img class="delete" src="https://image.flaticon.com/icons/png/512/67/67345.png" alt="delete-button">
          </button>
        </div>
      </li>
    </ul>

    <p id="not-exist" v-else>{{ error.fetch }}</p>

  </div>
</template>

<script>
import axios from "axios"

export default {
  data() {
    return {
      editMode: false,
      search: '',
      notes: [],
      error: {
        update: '',
        delete: '',
        fetch: ''
      }
    }
  },
  methods:{
    fetchData: function () {
      var search = this.search
      // send request to PHP script to fetch data
      axios({
        method: "POST",
        url: "./action/action.php",
        data: {
          action: "fetchAll",
          search: search
        },
      }).then(response => {
        // save data to print it
        if (response.data.status === 'success') {
          this.notes = response.data.send;
          this.error.fetch = '';
        } else{
          throw response.data.send;
        }
        if (!this.notes.length){
          throw 'There is no notes containing string "' + this.search + '"';
        }
      })
        .catch(error => {
          this.error.fetch = error;
        });
    },

    editModeOn: function(noteId){
      if(!this.editMode){
        this.editMode = true;
        this.notes[noteId].edit = true;
      }
    },

    editNote: function(noteId){
      // save note and id as variables
      var body = this.$refs.editedNote[noteId].value;
      var id = this.notes[noteId].id;
      // send request to PHP script to edit note
      axios({
        method: 'POST',
        url: "./action/action.php",
        data: {
          action: 'updateData',
          id: id,
          body: body
        },
      }).then(response => {
        // check if it is not success
        if (response.data.status === 'success'){
          //  update data
          this.fetchData();
          this.error.update = '';
          this.editMode = false;
        } else {
          // create an error message
          throw response.data.send;
        }
      })
        .catch(error =>{
          this.error.update = error;
        });
    },

    deleteNote: function(noteId){
      // save id as a variable
      var id = this.notes[noteId].id;
      // send request to PHP script to delete note
      axios({
        method: 'POST',
        url: "./action/action.php",
        data: {
          action: 'deleteData',
          id: id
        },
      }).then(response => {
        // check if it is not success
        if (response.data.status === 'success'){
          // update data
          this.fetchData();
          this.error.delete = '';

        } else {
          // create an error message
          throw response.data.send;
        }
      })
        .catch(error =>{
          this.error.delete = error;
        });
    },
  },
  created() {
    this.fetchData();
  }
}
</script>

<style scoped>
li.note {
  border-radius: 5px;
  background: #ddd;
  display: inline-block;
  text-shadow: none;
  margin: 4px;
  max-width: 600px;
  width: 40%;
  padding: 10px 7px;
  text-align: left;
  position: relative;
}
div ul{
  text-align: center;
}
.body{
  width: 90%;
  display: inline-block;
  word-wrap: break-word;
}
.delete{
  display: inline-block;
  position: absolute;
  margin: 0;
  padding: 0;
  height: 30px;
  width: 30px;
}
img.delete{
  height: 25px;
  width: 25px;
  position: relative;
}
button.delete{
  left: 12px;
}

.edit-note{
  display: inline-block;
  width: 90%;
  position: relative;
  height: 80px;
}
textarea{
  resize: none;
  width: 100%;
  height: 100%;
}
input{
  width: 300px;
  height: 25px;
  position: relative;
  bottom: 7px;
  left: 4px;
}
#search{
  height: 31px;
  width: 31px;
  padding: 1px 2px;
  border-radius: 0;
  border: none;
  cursor: pointer;
}
#search img{
  height: 23px;
  width: 23px;
}
.search{
  height: 30px;
}
#not-exist{
  color: red;
  text-align: center;
  border-radius: 5px;
}
</style>
