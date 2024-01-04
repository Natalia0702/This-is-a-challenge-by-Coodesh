<template>
<h2>Login</h2>
  <form @submit.prevent="login">
    <input type="text" placeholder="Seu email" v-model="email" />
    <input type="password" placeholder="sua senha" v-model="senha" />
    <button type="submit">Login</button>
  </form>
</template>

<script setup>
import axios from 'axios';
import http from '@/services/http.js'
import { reactive, ref, onBeforeMount } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter()
const email = ref('usuario1@gmail.com');
const senha = ref('123');

onBeforeMount(() => {
  let token = localStorage.getItem('token');
  if (!token) {
    return;
  }

//verificar se o token é válido

//se o token for invalido remover do storage

//se o token for valido redireciono

/*
códigos úteis 
localStorage.setItem('token', 'fadtyhafsthydf')
localStorage.getItem('token')
localStorage.removeItem('token')
*/
    router.push('/expenses');
});

const user = {
    email: email.value,
    password: senha.value
}

const login = () => {
    fetch("http://localhost:8000/api/login", {
        method: "POST",
        body: JSON.stringify(user),
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
          router.push('/expenses');
        })
}
/*
const verificarToken = async (token) => {
  try {
    const response = await axios.get('http://localhost:8000/api/login', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    console.log(response);
    return true;

  } catch (error) {
    console.log(response+ '  sadad');
    return false;
  
  }
};

verificarToken(token)
    .then((tokenValido) => {
        if (tokenValido) {
            
            console.log('O token é válido.');   

            router.push('/expenses');
        } else {
            console.log('O token é inválido.');
            localStorage.removeItem('token')

        }
    })
  .catch((error) => {
    console.error('Erro ao verificar o token:', error);
  });

*/
</script>

<style>

</style>
