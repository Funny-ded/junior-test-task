<template>
  <div id="content">
    <div id="search">
      <input type="text" v-model="search" placeholder="Search note">
      <button v-on:click="fetchData">
        <img src="https://image.flaticon.com/icons/png/512/58/58427.png" alt="search">
      </button>
    </div>
    <ul id="notes-list" v-if="!error.fetch">
      <li class="single-note" v-for="(note, id) in notes">
        <p class="body" v-show="!note.edit" v-on:click="editModeOn(id)">{{ note.body }}</p>
        <div class="edit-note" v-show="note.edit">
          <textarea v-on:keydown.enter.prevent="editNote(id)" ref="editedNote">{{ note.body }}</textarea>
          <p class="error-message"  v-if="error.update">{{ error.update }}</p>
          <p class="error-message" v-if="error.delete">{{ error.delete }}</p>
        </div>
        <div id="delete">
          <button v-on:click="deleteNote(id)">
            <img src="https://image.flaticon.com/icons/png/512/67/67345.png" alt="delete-button">
          </button>
        </div>
      </li>
    </ul>

    <p class="error-message" v-else>{{ error.fetch }}</p>

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
      this.editMode = false;
      this.error.fetch = '';
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
      this.error.update = '';
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
      this.editMode = false;
      this.error.delete = '';
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
#notes-list{
  overflow: hidden;
  list-style: none;
  padding: 0 0 0 30px;
  margin: 20px 0 0 7%;
}
.single-note{
  float: left;
  width: 50%;
  border-radius: 5px;
  background: #ddd;
  margin: 4px;
  max-width: 600px;
  padding: 10px 7px;
  text-align: left;
}
.body{
  width: 90%;
  display: inline-block;
  word-wrap: break-word;
}
#delete, #delete button{
  display: inline-block;
  position: absolute;
  margin: 0;
  padding: 0;
  height: 30px;
  width: 30px;
}
#delete button img{
  height: 25px;
  width: 25px;
  position: relative;
}
#delete button{
  left: 12px;
}
.edit-note{
  display: inline-block;
  width: 90%;
  position: relative;
  height: 120px;
}
textarea{
  resize: none;
  width: 100%;
  height: 100%;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}
input{
  max-width: 300px;
  width: 65%;
  height: 25px;
  position: relative;
  bottom: 7px;
  left: 4px;
}
#search button{
  height: 31px;
  width: 31px;
  padding: 1px 2px;
  border-radius: 0;
  border: none;
  cursor: pointer;
}
#search button img{
  height: 23px;
  width: 23px;
}

@media screen and (max-width: 1400px){
  .single-note{
    width: 45%;
  }
}

@media screen and (max-width: 1000px){
  .single-note{
    width: 90%;
    max-width: 1000px;
  }
}

@media screen and (max-width: 640px){
  .single-note{
    width: 100%;
    border-radius: 0;
  }
  #notes-list{
    margin-left: 0;
    padding-left: 0;
  }
  .body{
    width: 85%;
  }
  .edit-note{
    width: 85%;
  }
}
@media screen and (max-width: 420px){
  .body{
    width: 80%;
  }
  .edit-note{
    width: 80%;
  }
}
@media screen and (max-width: 360px){
  .body{
    font-size: 0.8em;
    width: 75%;
  }
  .edit-note{
    width: 75%;
  }
}
@media screen and (max-width: 260px){
  .body{
    width: 65%;
  }
  .edit-note{
    width: 65%;
  }
}
</style>
