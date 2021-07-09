<template>
  <footer>
    <p>Copyright 2021 uNotes Page</p>
  </footer>
</template>

<script>
export default {
  name: "footer"
}
</script>

<style scoped>
footer{
  height: 50px;
  background: #0071bc;
  text-align: center;
  padding: 10px;
}
p{
  font-weight: bold;
  color: #fff;
}
@media screen and (max-width: 260px){
  p{
    font-weight: normal;
    font-size: 0.9em;
  }
}
</style>
