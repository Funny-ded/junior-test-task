<template>
  <header>
    <div>
      <h1>{{ name }}</h1>
    </div>
    <span><a href="#new-note">Add new note</a></span>
  </header>
</template>

<script>
export default {
  data(){
    return {
      name: ''
    }
  },
  created(){
    this.name = 'uNotes Page';
  }
}

</script>

<style scoped>
header{
  height: 100px;
  background: #0071bc;
  color: white;
  text-align: left;
  margin: 0;
  border: 2px solid #51aff5;
}
div{
  width: 80%;
  display: inline-block;
  margin-left: 25px;
}
a{
  position: relative;
  right: 0;
  color: #fff;
  text-decoration: none;
  text-align: right;
}
</style>
