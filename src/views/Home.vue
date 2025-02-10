<template>
  <div>
    <h1>Welcome to Budget Buddy</h1>
    <p>Please choose an option:</p>
    <button @click="$router.push('/login')">Login</button>
    <button @click="$router.push('/register')">Register</button>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
}
</script>

<style scoped>
h1 {
  color: #295fa6;
}
button {
  margin: 10px;
  padding: 10px 20px;
  background-color: #2a95bf;
  color: white;
  border: none;
  cursor: pointer;
}
button:hover {
  background-color: #bf0413;
}
</style>
