<script setup>
//Fazer um fecth para trazer os dados de expenses
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from 'vue-router';
import { toast } from '@/helpers/toast'
import { randomNumber, range } from '@/helpers/fake'
import Modal from '@/components/BS5/Modal.vue'
import { getUrl } from '@/services/api'

const API_URL = 'http://localhost:8000/api/expenses';
const token = localStorage.getItem('token');
const router = useRouter();
const route = useRoute();
let pageNumber = ref(
    (new URL(window.location)).searchParams.get('page')
)

if (!token) {
    toast.error('Área restrita!\n Por favor, identifique-se!');
    router.push('/login');
}

let expenses = ref([])
let pagination = ref({
    links: null,
    from: null,
    from: null,
    first_page_url: null,
    last_page_url: null,
    next_page_url: null,
    prev_page_url:null,
    per_page: null,
    to:null,
    total:null,
})

const updateExpenseList = (page = null) => {
    page = page && page >= 1 ? page : pageNumber.value;
    const config = {
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      },
    };

    fetch(
        API_URL + `?page=${page}`,
        config
    )
      .then(response => response.json())
      .then(responseData => {
            // console.log('responseData:', responseData.data);
            expenses.value = responseData.data;
            pagination.value = {
                links: responseData.links || null,
                from: responseData.from || null,
                from: responseData.from || null,
                first_page_url: responseData.first_page_url || null,
                last_page_url: responseData.last_page_url || null,
                next_page_url: responseData.next_page_url || null,
                prev_page_url: responseData.prev_page_url || null,
                per_page: responseData.per_page || null,
                to: responseData.to || null,
                total: responseData.total || null,
            };
      })
      .catch(error => {
          console.error('Erro ao buscar despesas:', error);
      });
}

onMounted(() => {
    updateExpenseList();
});

const formatDate = (date, preset = 'pt-BR') => {
    date = new Date(date);
    return date.toLocaleString(preset);
}

let expenseToShow = ref();
let expenseToEdit = ref();
let expenseToDelete = ref();

const deleteExpense = () => {
    let expense = expenseToDelete.value;
    if (!expense || !expense.id) {
        console.log('expense', expense);
        return;
    }

    let token = localStorage.getItem('token');
    fetch(getUrl(`expenses/${expense.id}`), {
        method: 'DELETE',
        headers: {
            Accept: 'application/json',
            Authorization: `Bearer ${token}`
        }
    })
    .then(response => {
        response.ok
            ? toast.success('Deleted successfuly!')
            : toast.error('Fail on delete record!');

        if (response.ok) {
            expenses.value = expenses.value?.filter(item => item?.id != expense.id);
        }

        response.json();
    })
    .then(data => console.log(data))
    .catch(error => {
        toast.error('Error on delete record');
      });

    expenseToDelete.value = null
}

const updateExpense = () => {
    let expense = expenseToEdit.value;
    if (!expense || !expense.id) {
        console.log('expense', expense);
        return;
    }

    let token = localStorage.getItem('token');

    fetch(getUrl(`expenses/${expense.id}`), {
        method: 'PUT',
        body: JSON.stringify(expense),
        headers: {
            Accept: 'application/json',
            Authorization: `Bearer ${token}`,
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        response.ok
            ? toast.success('Updated successfuly!')
            : toast.error('Fail on update record!');

        response.json();
    })
    .then(data => console.log(data))
    .catch(error => {
        toast.error('Error on delete record');
      });

      expenseToEdit.value = null
}

const navigateToPage = (link) => {
    if (!link || !link?.url) {
        return;
    }

    let url = link?.url;

    let page = (new URL(url)).searchParams.get('page');

    if (!page) {
        console.log('3');
        return;
    }

    router.push({ path: 'expenses', query: { page: page } });
    updateExpenseList(page);
}
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
                                @click="expenseToDelete = expense"
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
        <tfoot>
            <tr>
                <td
                    colspan="100%"
                    v-if="pagination?.links ? 1 : 0"
                >
                    <nav
                        aria-label="custom-pag-footer-nav"
                    >
                        <ul class="pagination">
                            <template
                                v-for="(link, linkIndex) in pagination.links"
                                    :key="linkIndex"
                            >
                                <li
                                    class="page-item"
                                    :class="{
                                        active: link?.active,
                                    }"
                                >
                                    <button
                                        type="button"
                                        class="page-link"
                                        v-if="link?.url"
                                        @click="navigateToPage(link)"
                                        v-html="link?.label"
                                    ></button>

                                    <span
                                        class="page-link disabled"
                                        v-else
                                        v-html="link?.label"
                                    ></span>
                                </li>
                            </template>
                        </ul>
                    </nav>
                </td>
            </tr>
        </tfoot>
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
                @click="expenseToEdit = expenseToShow"
            >
                Edit
            </button>

            <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="expenseToShow = null"
            >
                Close
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
                @click="updateExpense"
            >
                Save
            </button>
        </template>
    </Modal>

    <Modal
        v-if="expenseToDelete && expenseToDelete.id"
        open="1"
    >
    <template #heading>
        <span class="text-danger">Expense delete</span>
    </template>
        <p>Tem certeza que deseja excluir o item <strong>#{{ expenseToDelete.id }}</strong>?</p>
        <p>Essa ação não poderá ser desfeita.</p>

        <template #modal_footer>
            <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
                @click="expenseToDelete = null"
            >
                Cancelar
            </button>


            <button
                type="button"
                class="btn btn-danger"
                @click="deleteExpense"
            >
                Sim! Quero deletar
            </button>
        </template>
    </Modal>
</template>
