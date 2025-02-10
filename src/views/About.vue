<template>
  <div class="about">
    <h1>Welcome, {{ username }}!</h1>
    <p>
      This application is under development by students <b>Marija Kristić</b> and
      <b>Alija Kičin</b> for the course <i>Programming for the Internet</i>. The development started
      in October 2024, and the final version will be a personal finance management app with an AI
      advisor. The goal is to be simple and user-friendly, helping users better manage their
      finances.
    </p>

    <!-- Dugme za početak budžetiranja -->
    <button class="start-button" @click="startBudgeting">Start Budgeting</button>
  </div>
</template>

<script>
export default {
  name: 'AboutPage',
  computed: {
    username() {
      return localStorage.getItem('username') || 'Guest'
    },
  },
  methods: {
    startBudgeting() {
      this.$router.push('/budget') // Preusmjeravanje na budgettable
    },
  },
}
</script>

<style scoped>
.about {
  text-align: center;
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  border-radius: 8px;
  background-color: #f8f9fa;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #295fa6;
}

p {
  font-size: 18px;
  color: #595959;
}

/* Stilizacija dugmeta */
.start-button {
  margin-top: 20px;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  color: white;
  background-color: #295fa6;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.start-button:hover {
  background-color: #2a95bf;
}
</style>
