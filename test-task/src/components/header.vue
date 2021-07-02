<template>
  <div id="header">
    <div id="head">
      <h1>{{ name }}</h1>
    </div>
    <nav>
      <ul>
        <li><a href="#new-note">Add new note</a></li>
        <li>Search existing note</li>
      </ul>
    </nav>
  </div>
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
#header{
  height: 100px;
  background: #0071bc;
  color: white;
  text-align: left;
  margin: 0;
  border: 2px solid #51aff5;
}
#head{
  display: inline-block;
  padding: 8px 0;
  width: 20%;
  position: relative;
  cursor: default;
}
#head h1{
  display: inline-block;
  margin-left: 25px;
}
nav{
  display: inline-block;
  width: 75%;
}
nav ul{
  list-style: none;
  padding: 0;
  text-align: right;
}
li{
  display: inline-block;
  background: #ddd;
  border-radius: 5px;
  padding: 5px;
  margin: 0 5px;
  text-shadow: 1px 1px 2px #000 ;
}
li a{
  color: #fff;
  text-decoration: none;
}
</style>
