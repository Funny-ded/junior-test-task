<template>
  <div id="content">
    <ul id="notes-list" v-if="!error.fetch">
      <li class="single-note" v-for="(note, id) in notes">
        <p class="body" v-show="!note.edit" v-on:click="editModeOn(id)">{{ note.body }}</p>
        <div class="edit-note" v-show="note.edit">
          <textarea v-on:keydown.enter="editNote($event, id)" v-model="editedNote">{{ note.body }}</textarea>

          <p class="error-message"  v-if="error.update">{{ error.update }}</p>
          <p class="error-message" v-if="error.delete">{{ error.delete }}</p>
        </div>
        <div id="buttons">
          <button id="delete" v-on:click="deleteNote(id)">
            <img src="https://image.flaticon.com/icons/png/512/67/67345.png" alt="delete-button">
          </button>
          <button id="no-changes" v-show="note.edit" v-on:click="cancelChanges(id)">
            <img src="https://www.svgrepo.com/show/54336/return-button.svg" alt="exit from edit mode without any changes">
          </button>
        </div>
      </li>
    </ul>

  </div>
</template>

<script>
import axios from "axios"

export default {
  data() {
    return {
      editMode: false,
      editedNote: '',
      notes: [],
      error: {
        update: '',
        delete: ''
      }
    }
  },
  methods:{
    fetchData: function () {
      // send request to PHP script to fetch data
      axios({
        method: "POST",
        url: "./action/action.php",
        data:{
          action: 'fetchAll'
        }
      }).then(response => {
        // save data to print it
        if (response.data.status === 'success') {
          this.notes = response.data.send;
        } else{
          throw response.data.send;
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
        this.editedNote = this.notes[noteId].body;
      }
    },

    cancelChanges: function(noteId){
      this.editMode = false;
      this.notes[noteId].edit = false;
      this.editedNote = '';
    },

    editNote: function(evt, noteId){
      if (!evt.shiftKey) {
        evt.preventDefault();
        // save note and id as variables
        var body = this.editedNote;
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
          if (response.data.status === 'success') {
            //  update data
            this.fetchData();
            this.error.update = '';
            this.editMode = false;
          } else {
            // create an error message
            throw response.data.send;
          }
        })
          .catch(error => {
            this.error.update = error;
          });
      }
    },

    deleteNote: function(noteId){
      this.editMode = false;
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
    }
  },

  created() {
    this.fetchData();
  },
  mounted(){
    this.$root.$on('fetchAll', this.fetchData);
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
  white-space: pre-line;
}
#buttons, #buttons button{
  display: inline-block;
  position: absolute;
  margin: 0;
  padding: 0;
  height: 30px;
  width: 30px;
}
#buttons button img{
  height: 25px;
  width: 25px;
  position: relative;
}
#buttons button{
  left: 12px;
}
#buttons #no-changes{
  top: 30px;
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
