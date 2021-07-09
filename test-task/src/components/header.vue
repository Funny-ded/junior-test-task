<template>
  <header>
    <h1>{{ name }}</h1>
    <a href="#new-note">Add new note</a>
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
h1 {
  display: inline-block;
  width: 85%;
  position: relative;
  top: 50%;
  margin: -0.625em 0 0 12px;
}
a{
  position: relative;
  color: #fff;
  text-decoration: none;
  top: 50%;
  margin: -0.625em 0 0 0;
}

@media screen and (max-width: 1000px){
  h1{
    width: 80%;
  }
}
@media screen and (max-width: 640px){
  h1{
    width: 75%;
  }
}
@media screen and (max-width: 500px){
  h1{
    width: 70%;
  }
}
@media screen and (max-width: 420px){
  h1{
    width: 65%;
  }
}
@media screen and (max-width: 360px){
  h1{
    width: 60%;
    font-size: 1.5em;
  }
  a{
    font-size: 0.9em;
  }
  header{
    height: 80px;
  }
}
@media screen and (max-width: 290px){
  h1{
    width: 50%;
    font-size: 1.25em;
  }
  a{
    font-size: 0.7em;
  }
}
@media screen and (max-width: 260px){
  h1{
    width: 35%;
    font-size: 1em;
    top: 40%;
    margin-right: 10px;
    margin-left: 0;
  }
  a{
    font-size: 0.7em;
    top: 30%;
  }
}
</style>
