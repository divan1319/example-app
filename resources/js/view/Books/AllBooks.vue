<template>
    <div class="card mt-10 mx-5">
        <DataTable
            :value="books"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
        >
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column field="isbn" header="ISBN" style="width: 25%"></Column>
            <Column field="name" header="Nombre" style="width: 25%"></Column>
            <Column
                field="availability"
                header="Disponibilidad"
                style="width: 25%"
            ></Column>
            <Column
                field="location.name"
                header="Ubicación"
                style="width: 25%"
            ></Column>
            <Column
                field="author.author"
                header="Autor"
                style="width: 50%"
            ></Column>
            <Column
                field="created_at"
                header="Creado"
                style="width: 25%"
            ></Column>
            <Column header="Acciones" style="width: 25%">
                <template #body="slotProps">
                    <div class="flex lg:flex-row flex-col lg:gap-x-2 gap-y-2">
                        <Button
                            v-if="slotProps.data.status == 1"
                            @click="confirmDisable(slotProps.data.id)"
                            label="Deshabilitar Libro"
                            severity="danger"
                            outlined
                        ></Button>
                        <Button
                            v-if="slotProps.data.status == 0"
                            @click="confirmAllow(slotProps.data.id)"
                            label="Habilitar Libro"
                            severity="help"
                            outlined
                        ></Button>
                        <Button
                            v-if="slotProps.data.status == 1"
                            label="Prestar Libro"
                            severity="info"
                            outlined
                            @click="showModalLoan(slotProps.data)"
                        />
                        <Button
                            label="Actualizar Libro"
                            severity="contrast"
                            outlined
                            @click="showModalEdit(slotProps.data)"
                        />
                    </div>
                </template>
            </Column>
            <Column header="Estado" style="width: 25%">
                <template #body="slotProps">
                    <Tag>{{
                        slotProps.data.status == 1
                            ? "Disponible"
                            : "No Disponible"
                    }}</Tag>
                </template>
            </Column>
        </DataTable>
        <Button label="Agregar Libro" class="mt-10" @click="showModal" />
    </div>
    <Toast />
    <ConfirmDialog></ConfirmDialog>

    <NewBook v-model:visible="newBookModal" />
    <EditBook v-model:visible="editBookModal" :data="editData" />
    <LoanBook v-model:visible="loanBookModal" :book="loanBook" />
</template>

<script setup>
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import { useBookStore } from "../../store/books";
import { onMounted, ref, watchEffect } from "vue";
import NewBook from "./components/NewBook.vue";
import Button from "primevue/button";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import Tag from "primevue/tag";
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import EditBook from "./components/EditBook.vue";
import LoanBook from "./components/LoanBook.vue";

const confirm = useConfirm();
const toast = useToast();

const store = useBookStore();
const books = ref([]);
const editData = ref({});
const loanBook = ref({});

const newBookModal = ref(false);
const editBookModal = ref(false);
const loanBookModal = ref(false);

const showModal = () => {
    newBookModal.value = !newBookModal.value;
};

const showModalEdit = (data) => {
    editBookModal.value = !editBookModal.value;
    editData.value = data;
};

const showModalLoan = (data) => {
    loanBookModal.value = !loanBookModal.value;
    loanBook.value = data;
};

const confirmDisable = (id) => {
    confirm.require({
        message: "Deseas deshabilitar este Libro?",
        header: "Deshabilitar Libro",
        icon: "pi pi-info-circle",
        rejectLabel: "Cancel",
        rejectProps: {
            label: "Cancelar",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Deshabilitar",
            severity: "danger",
        },
        accept: async () => {
            await disableBook(id);
            toast.add({
                severity: "success",
                summary: "Libro Deshabilitado",
                life: 3000,
            });
        },
        reject: () => {
            toast.add({
                severity: "error",
                summary: "Has cancelado la deshabilitación del libro",
                life: 3000,
            });
        },
    });
};

const confirmAllow = (id) => {
    confirm.require({
        message: "Deseas habilitar este Libro?",
        header: "Habilitar Libro",
        icon: "pi pi-info-circle",
        rejectLabel: "Cancel",
        rejectProps: {
            label: "Cancelar",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Habilitar",
            severity: "danger",
        },
        accept: async () => {
            await allowBook(id);
            toast.add({
                severity: "success",
                summary: "Libro Habilitado",
                life: 3000,
            });
        },
        reject: () => {
            toast.add({
                severity: "error",
                summary: "Has cancelado la habilitación del libro",
                life: 3000,
            });
        },
    });
};

const disableBook = async (id) => {
    await store.disableBook(id);
};
const allowBook = async (id) => {
    await store.allowBook(id);
};
onMounted(() => {
    store.fetchDataAllBooks();
});

watchEffect(() => {
    if (store.books.length > 0) {
        books.value = store.books;
    }
});
</script>
