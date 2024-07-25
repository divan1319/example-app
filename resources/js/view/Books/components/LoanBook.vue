<template>
    <div class="card flex justify-center">
        <Dialog
            v-model:visible="localVisible"
            modal
            header="Prestar Libro"
            :style="{ width: '50vw' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="card flex flex-col">
                <h2 class="text-3xl text-center font-semibold text-gray-300">
                    {{ props.book.name }}
                </h2>
                <FloatLabel class="mt-5 mb-5">
                    <Select
                        v-model="state.user_id"
                        inputId="dd-author"
                        :options="users"
                        optionLabel="name"
                        optionValue="id"
                        class="w-full"
                    />
                    <label for="dd-author">Seleccione un usuario</label>
                </FloatLabel>
                <Button
                    label="Prestar"
                    @click.prevent="onSubmit(props.book.id)"
                />
                <h2 v-if="errors.status" class="text-red-600">
                    {{ errors.message }}
                </h2>
            </div>
        </Dialog>
    </div>
    <Toast></Toast>
</template>

<script setup>
import Dialog from "primevue/dialog";
import { onMounted, reactive, ref, toRaw, watchEffect } from "vue";
import { useUserStore } from "../../../store/users";
import FloatLabel from "primevue/floatlabel";
import Select from "primevue/select";
import Button from "primevue/button";
import { useBookStore } from "../../../store/books";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";

const emits = defineEmits(["update:visible"]);
const props = defineProps({
    book: {
        type: Object,
    },
    visible: {
        type: Boolean,
    },
});

const localVisible = ref(props.visible);
const users = ref([]);
const store = useUserStore();
const bookStore = useBookStore();
const toast = useToast();

const state = reactive({
    user_id: null,
});
const errors = reactive({
    status: false,
    message: "",
});

const onSubmit = async (id) => {
    let data = {
        user_id: state.user_id,
    };
    await bookStore
        .loanBook(id, data)
        .then(() => {
            state.user_id = null;
            emits("update:visible");
        })
        .catch(() => bookStore.hasErrors(true));

    if (!bookStore.errors.status) {
        toast.add({
            severity: "success",
            summary: "Libro Prestado",
            life: 3000,
        });
    }
};

const showMessage = () => {
    toast.add({
        severity: "error",
        summary: bookStore.errors.message,
        life: 3000,
    });
};

onMounted(() => {
    store.getUsers();
});

watchEffect(() => {
    if (store.users.length > 0) {
        users.value = store.users;
    }
});

watchEffect(() => {
    if (bookStore.errors.status) {
        showMessage();
    }
});

watchEffect(() => {
    localVisible.value = props.visible;
});
</script>
