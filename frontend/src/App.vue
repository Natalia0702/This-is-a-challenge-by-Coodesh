<template>
    <header data-bs-theme="dark">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <router-link to="/" class="navbar-brand active">
            My Expenses
        </router-link>
    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse"
        aria-controls="navbarCollapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
        @click="toggleExpandNavbar"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
      <div
            class="collapse navbar-collapse"
            id="navbarCollapse"
            :class="{
                show: expandNavbar,
            }"
        >
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <router-link to="/" class="nav-link active">Home</router-link>
          </li>
          <router-link to="/expenses" class="nav-link active">Expenses</router-link>
        </ul>
        <div class="d-flex">
            <router-link
                v-if="token ? 1 : 0"
                to="/login" class="btn btn-sm btn-outline-info"
            >Login</router-link>
        </div>
      </div>
    </div>
  </nav>
</header>
  <div class="container-box pt-5 mt-5 px-3">
    <router-view />
  </div>
</template>



<script>
import axios from 'axios';
import Expenses from './views/Expenses.vue'

export default {
  data() {
    return {
      email: "",
      password: "",
      post: {},
      expandNavbar: false,
    };
  },
  methods: {
    toggleExpandNavbar() {
        this.expandNavbar = !this.expandNavbar;
    },
    get token() {
        return localStorage.getItem('token');
    },
    getToken() {
      const data = {
        email: this.email,
        password: this.password,
      };
      fetch("http://localhost:8000/api/auth/login", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
      })
        .then(response => response.json())
        .then(data => {
          if (!data || !data?.token) {
            return
          }


          localStorage.setItem('token', JSON.stringify(data.token));
          console.log(data);
        });
      },
  },


};
</script>
