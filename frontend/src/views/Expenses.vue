<script setup>
//Fazer um fecth para trazer os dados de expenses
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from 'vue-router';
import { toast } from '@/helpers/toast'
import { randomNumber, range } from '@/helpers/fake'
import Modal from '@/components/BS5/Modal.vue'

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

const formatDate = (date, preset = 'pt-BR') => {
    date = new Date(date);
    return date.toLocaleString(preset);
}

let expenseToShow = ref();
let expenseToEdit = ref();

</script>

<style></style>

<template>
    <h2>Expenses</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th
                    scope="col"
                    class="text-truncate"
                    style="max-width: 200px;"
                >Descrição</th>
                <th scope="col">Data</th>
                <th scope="col">Usuário</th>
                <th scope="col">Valor</th>
                <!-- <th scope="col">created_at</th>
                <th scope="col">updated_at</th> -->
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
                <tr
                    v-for="expense in expenses"
                    :key="expense.id"
                >
                    <th scope="row">{{ expense.id }}</th>
                    <td class="text-truncate" style="max-width: 200px;">{{ expense.description }}</td>
                    <td>{{ formatDate(expense.date) }}</td>
                    <td>{{ expense.user_id }}</td>
                    <td>{{ expense.value }}</td>
                    <!-- <td>{{ formatDate(expense.created_at) }}</td>
                    <td>{{ formatDate(expense.updated_at) }}</td> -->
                    <td>
                        <div class="btn-group">
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger"
                            >Excluir</button>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-info"
                                @click="expenseToShow = expense"
                            >Ver mais</button>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary"
                                @click="expenseToEdit = expense"
                            >Editar</button>
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>
    <Modal
        v-if="expenseToShow && expenseToShow.id"
        open="1"
    >
        <template #heading>Expense detail</template>
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th scope="col">ID</th>
                    <td>{{ expenseToShow.id }}</td>
                </tr>
                <tr>
                    <th scope="col">Descrição</th>
                    <td>{{ expenseToShow.description }}</td>
                </tr>
                <tr>
                    <th scope="col">Data</th>
                    <td>{{ expenseToShow.date }}</td>
                </tr>
                <tr>
                    <th scope="col">Usuário</th>
                    <td>{{ expenseToShow.user_id }}</td>
                </tr>
                <tr>
                    <th scope="col">Valor</th>
                    <td>{{ expenseToShow.value }}</td>
                </tr>
                <tr>
                    <th scope="col">Criado em</th>
                    <td>{{ expenseToShow.created_at }}</td>
                </tr>
                <tr>
                    <th scope="col">Atualizado em</th>
                    <td>{{ expenseToShow.updated_at }}</td>
                </tr>
            </tbody>
        </table>

        <template #modal_footer>
            <button
                type="button"
                class="btn btn-outline-primary"
            >
                Editar
            </button>

            <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="expenseToShow = null"
            >
                Fechar
            </button>
        </template>
    </Modal>

    <Modal
        v-if="expenseToEdit && expenseToEdit.id"
        open="1"
    >
        <template #heading>Expense edit</template>
        <div class="row">
            <div class="col-12">
                <div class="mb-3 row">
                    <label for="staticId" class="col-sm-4 col-form-label">ID</label>
                    <div class="col-sm-8">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="staticId"
                            :value="expenseToEdit.id"
                        >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputDescription" class="col-sm-4 col-form-label">Descrição</label>
                    <div class="col-sm-8">
                        <input
                            type="text"
                            class="form-control"
                            id="inputDescription"
                            v-model="expenseToEdit.description"
                        >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputDate" class="col-sm-4 col-form-label">Data</label>
                    <div class="col-sm-8">
                        <input
                            type="text"
                            class="form-control flatpickr-input-date"
                            id="inputDate"
                            v-model="expenseToEdit.date"
                        >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputUserId" class="col-sm-4 col-form-label">Usuário</label>
                    <div class="col-sm-8">
                        <input
                            type="text"
                            class="form-control"
                            id="inputUserId"
                            v-model="expenseToEdit.user_id"
                        >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputValue" class="col-sm-4 col-form-label">Valor</label>
                    <div class="col-sm-8">
                        <input
                            type="text"
                            class="form-control"
                            id="inputValue"
                            v-model="expenseToEdit.value"
                        >
                    </div>
                </div>
            </div>
        </div>

        <template #modal_footer>
            <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="expenseToEdit = null"
            >
                Cancel
            </button>

            <button
                type="button"
                class="btn btn-outline-success"
            >
                Save
            </button>
        </template>
    </Modal>
</template>
