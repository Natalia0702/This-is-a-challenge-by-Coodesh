<script setup>
//Fazer um fecth para trazer os dados de expenses
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from 'vue-router';
import { toast } from '@/helpers/toast'
import { randomNumber, range } from '@/helpers/fake'

const API_URL = 'http://localhost:8000/api/expenses';
const token = localStorage.getItem('token');
const router = useRouter()

if (!token) {
    toast.error('Área restrita!\n Por favor, identifique-se!');
    router.push('/login');
}

let expenses = ref([])

onMounted(() => {
    const config = {
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      },
    };

    fetch(API_URL, config)
      .then(response => response.json())
      .then(responseData => {
            // console.log('responseData:', responseData.data);
            expenses.value = responseData.data;
      })
      .catch(error => {
          console.error('Erro ao buscar despesas:', error);
      });
});

// function onBeforeMount(callback: () => void): void

</script>

<style></style>

<template>
    <h2>Expensesss</h2>
    <ul>
      <li
          v-for="expense in expenses"
          :key="expense.id"
      >#{{ expense.id }} - {{ expense.description }}</li>
  </ul>
  <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>
</template>
