<template>
  <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/login">login</router-link> |
      <router-link to="/expenses">Expenses</router-link>
  </div>
  <router-view />
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
    };
  },
  methods: {
    getToken() {
      const data = {
        email: this.email,
        password: this.password,
      };
      fetch("http://localhost:8000/api/login", {
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
