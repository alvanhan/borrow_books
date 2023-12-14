<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <router-link v-if="!isLoggedIn" :to="{ name: 'login' }" class=" ms-3 navbar-brand">SIMPLE LIBRARY</router-link>
    <router-link v-if="isLoggedIn" :to="{ name: 'dashboard' }" class=" ms-3 navbar-brand">SIMPLE LIBRARY</router-link>
    <router-link v-if="isLoggedIn" :to="{ name: 'returnbook' }" class="btn btn-success btn-sm navbar-btn me-3">RETURN YOUR BOOK</router-link>
    <button v-if="isLoggedIn" @click="logout" class="btn btn-primary btn-sm navbar-btn">Logout</button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item" v-if="!isLoggedIn">
          <router-link :to="{ name: 'register' }" class="nav-link" href="#">REGISTER</router-link>
        </li>
        <li class="nav-item" v-if="!isLoggedIn">
          <router-link :to="{ name: 'login' }" class="nav-link" href="#">LOGIN</router-link>
        </li>
      </ul>
    </div>
  </nav>
  <router-view />
</template>

<script>
export default {
  computed: {
    isLoggedIn() {
      const authToken = localStorage.getItem('authToken');
      return !!authToken;
    },
  },
  methods: {
    async logout() {
      localStorage.removeItem('authToken');
      await this.$router.push({ name: 'login' });
      window.location.reload(true);
    },
  },
};
</script>
