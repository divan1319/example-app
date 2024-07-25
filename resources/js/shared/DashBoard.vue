<template>
    <div class="flex md:flex-row flex-col gap-x-10 mt-4 lg:mx-96 md:mx-52">
        <Card style="width: 25rem; overflow: hidden">
            <template #header>
                <img
                    alt="user header"
                    src="https://www.comunidadbaratz.com/wp-content/uploads/Sabes-cuales-son-los-libros-mas-vendidos-de-2017-a-traves-de-Internet-en-Espana.jpg"
                />
            </template>
            <template #title>Libros Registrados</template>

            <template #content>
                <p class="m-0 text-9xl text-center text-blue-500">
                    {{ total.books }}
                </p>
            </template>
        </Card>
        <Card style="width: 25rem; overflow: hidden" class="">
            <template #header>
                <img
                    alt="user header"
                    src="https://www.comunidadbaratz.com/wp-content/uploads/2023/04/Libros-mas-prestados-2022-bibliotecas-publicas-Espana.jpg"
                />
            </template>
            <template #title>Libros Prestados Actualmente</template>

            <template #content>
                <p class="m-0 text-9xl text-center text-blue-500">
                    {{ total.loanedBooks }}
                </p>
            </template>
        </Card>
    </div>
</template>

<script setup>
import Card from "primevue/card";
import { useBookStore } from "../store/books";
import { onMounted, reactive, watchEffect } from "vue";

const store = useBookStore();

const total = reactive({
    books: 0,
    loanedBooks: 0,
});

onMounted(() => {
    store.getTotalBooks();
});

watchEffect(() => {
    total.books = store.total.books;
    total.loanedBooks = store.total.loanedBooks;
});
</script>
