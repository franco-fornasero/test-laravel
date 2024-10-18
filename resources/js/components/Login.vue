<template>
  <div class="h-100 d-flex align-items-center justify-content-center row">
    <form class="p-5 bg-white rounded container-sm col-7 col-lg-5 col-xl-4" @submit.prevent="login">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input :disabled="disabledLogin" type="email" v-model="this.email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input :disabled="disabledLogin" type="password" name="password" v-model="password" class="form-control" id="password">
      </div>
      <div v-if="errorMessage != ''" class="alert alert-danger py-2" role="alert">
        {{ errorMessage }}
      </div>
      <button :disabled="disabledLogin" type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
      disabledLogin: false,
      errorMessage: '',
    };
  },
  methods: {
    async login() {
      this.disabledLogin = true;
      this.errorMessage = '';
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        });

        // Save token in local storage
        const token = response.data.token;
        localStorage.setItem('token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        // Redirect to breweries page
        this.$router.push({ name: 'Breweries' });
      } catch (error) {
        this.disabledLogin = false;
        console.log(error.response.data);
        // Show error message
        if (error.response.data.errors) {
          this.errorMessage = Object.values(error.response.data.errors)[0][0];
        } else {
          this.errorMessage = error.response.data.message;
        }
      }
    },
  },
};
</script>

<style scoped></style>