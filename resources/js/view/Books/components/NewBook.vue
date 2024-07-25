<template>
    <div class="card flex justify-center">
        <Dialog
            v-model:visible="localVisible"
            modal
            header="Agregar Libro"
            :style="{ width: '50vw' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="card flex flex-col rounded-md gap-y-8">
                <FloatLabel class="mt-6">
                    <InputText v-model="formState.name" id="" class="w-full" required />
                    <label for="">Nombre Libro</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText v-model="formState.isbn" id="" class="w-full" required />
                    <label for="">ISBN</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText
                        v-model="formState.availability"
                        id=""
                        class="w-full" required
                    />
                    <label for="">Disponibilidad</label>
                </FloatLabel>
                <FloatLabel>
                    <Select
                        v-model="formState.location_id"
                        inputId="dd-location"
                        :options="locations"
                        optionLabel="name"
                        optionValue="id"
                        class="w-full" required
                    />
                    <label for="dd-location">Seleccione una ubicacion</label>
                </FloatLabel>
                <FloatLabel>
                    <Select
                        v-model="formState.author_id"
                        :options="authors"
                        optionLabel="author"
                        optionValue="id"
                        class="w-full" required
                    />
                    <label>Seleccione un autor</label>
                </FloatLabel>

                <Button label="Agregar" @click="onSubmit" />
            </div>
        </Dialog>
    </div>
    <Toast />
</template>

<script setup>
import Dialog from "primevue/dialog";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import { onMounted, reactive, ref, watchEffect } from "vue";
import { useBookStore } from "../../../store/books";
import Button from "primevue/button";
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";

const emits = defineEmits(["update:visible"]);
const props = defineProps({
    visible: {
        type: Boolean,
    },
});

const store = useBookStore();
const toast = useToast();

const authors = ref([]);
const locations = ref([]);

const localVisible = ref(props.visible);

const formState = reactive({
    name: "",
    isbn: "",
    availability: 0,
    location_id: null,
    author_id: null,
});

const onSubmit = async () => {
    await store.saveBook(formState).then(() => {
        cleanForm();
        emits("update:visible");
        toast.add({
            severity: "success",
            summary: "Libro Guardado",
            life: 3000,
        });
    });
};

const cleanForm = () => {
    formState.author_id = null;
    formState.availability = 0;
    formState.isbn = "";
    formState.location_id = null;
    formState.name = "";
};

onMounted(() => {
    store.getLocations();
    store.getAuthors();
});

watchEffect(() => {
    localVisible.value = props.visible;
});

watchEffect(() => {
    if (store.locations.length > 0 && store.authors.length > 0) {
        locations.value = store.locations;
        authors.value = store.authors;
    }
});
</script>
