<template>
  <div>
    <h1>Welcome to Budget Buddy</h1>
    <p>Please choose an option:</p>
    <button @click="$router.push('/login')">Login</button>
    <button @click="$router.push('/register')">Register</button>
    <button @click="$router.push('/guest-budget')">Enter as Guest</button>
    <!-- Dodajemo gumb za goste -->
  </div>
</template>

<script>
export default {
  name: 'HomeView',
  methods: {
    enterAsGuest() {
      // Postavimo korisnika kao gosta u local storage
      localStorage.setItem('currentUser', JSON.stringify({ role: 'guest' }))

      // Preusmjeri gosta na stranicu s tabelom
      this.$router.push('/budget')
    },
  },
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
