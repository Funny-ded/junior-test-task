<template>
  <div>
    <ul>
      <li class="note" v-for="(note, id) in notes">
        <p class="body" v-show="!note.edit" v-on:click="editModeOn(id)">{{ note.note }}</p>
        <div class="edit-note" v-show="note.edit">
          <textarea v-on:keydown.enter="editNote(id)" ref="editedNote">{{ note.note}}</textarea>
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

  </div>
</template>

<script>
import axios from "axios"

export default {
  data() {
    return {
      editMode: false,
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
        data: {
          action: "fetchAll",
        },
      }).then(response => {
        // save data to print it
        this.notes = response.data;
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
      var note = this.$refs.editedNote[noteId].value;
      var id = this.notes[noteId].id;
      // send request to PHP script to edit note
      axios({
        method: 'POST',
        url: "./action/action.php",
        data: {
          action: 'updateData',
          id: id,
          note: note
        },
      }).then(response => {
        // check if it is not success
        if (response.data !== 'update success'){
          // create an error message
          this.error.update = response.data;
        } else {
          //  update data
          this.fetchData();
          this.error.update = '';
          this.editMode = false;
        }
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
        if (response.data !== 'delete success'){
          // create an error message
          this.error.delete = response.data;
        } else {
          // update data
          this.fetchData();
          this.error.delete = '';
        }
      });
    }

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
</style>
