<template>
  <h2>Expensesss</h2>
  <ul>
    <li
        v-for="(expense, index) in expenses"
        :key="index"
    >{{ expense.label }}</li>
</ul>
</template>

<script setup>
//Fazer um fecth para trazer os dados de expenses
import { ref } from "vue";
import axios from "axios";

const API_URL = 'http://localhost:8000/api/expenses';
const token = localStorage.getItem('token');

if (token) {
  const config = {
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
  };

  axios.get(API_URL, config)
    .then(response => {
      console.log('Despesas:', response.data);
      // Função para despesas recebidas
    })
    .catch(error => {
      console.error('Erro ao buscar despesas:', error);
    });
} else {
  console.log('Token não disponível. Faça o login para obter um token válido.');
  // Função caso o token não esteja disponível
}

let expenses = ref([
    {label: 'fasdgrd'},
    {label: 'fasdgrczxcd'},
    {label: 'fasdgrd'},
    {label: 'fasdgrd'},
])
</script>

<style>

</style>