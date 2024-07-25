<template>
    <div class="m-2">
        <DataTable
            :value="loans"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
        >
            <Column field="id" header="ID" style="width: 25%"></Column>
            <Column
                field="book.name"
                header="Libro"
                style="width: 25%"
            ></Column>
            <Column
                field="user.name"
                header="Usuario"
                style="width: 25%"
            ></Column>
            <Column
                field="loan_at"
                header="Prestado el"
                style="width: 25%"
            ></Column>
            <Column
                field="returned_at"
                header="Devuelto el"
                style="width: 25%"
            ></Column>
            <Column header="Acciones" style="width: 25%">
                <template #body="slotProps">
                    <div class="flex lg:flex-row flex-col lg:gap-x-2 gap-y-2">
                        <Button
                            v-if="slotProps.data.status == 1"
                            @click="
                                confirmDisable(
                                    slotProps.data.book.id,
                                    slotProps.data.user
                                )
                            "
                            label="Devolución de Libro"
                            severity="help"
                            outlined
                        ></Button>
                    </div>
                </template>
            </Column>
            <Column header="Estado" style="width: 25%">
                <template #body="slotProps">
                    <Tag>{{
                        slotProps.data.status == 1 ? "Prestado" : "Devuelto"
                    }}</Tag>
                </template>
            </Column>
        </DataTable>
    </div>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
import { onMounted, reactive, ref, watchEffect } from "vue";
import { useBookStore } from "../../store/books";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Tag from "primevue/tag";
import Button from "primevue/button";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";

const store = useBookStore();
const confirm = useConfirm();

const toast = useToast();

const loans = ref([]);

const confirmDisable = (id, user) => {
    confirm.require({
        message: "Deseas devolver este Libro?",
        header: "Devolución de Libro",
        icon: "pi pi-info-circle",
        rejectLabel: "Cancel",
        rejectProps: {
            label: "Cancelar",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Devolver",
            severity: "danger",
        },
        accept: async () => {
            let data = {
                user_id: user.id,
            };
            await store.returnBook(id, data);
            toast.add({
                severity: "success",
                summary: "Libro Devuelto",
                life: 3000,
            });
        },
        reject: () => {
            toast.add({
                severity: "error",
                summary: "No se ha devuelto el libro",
                life: 3000,
            });
        },
    });
};

onMounted(() => {
    store.getLoanedBooks();
});

watchEffect(() => {
    if (store.booksLoaned.length > 0) {
        loans.value = store.booksLoaned;
    }
});
</script>
