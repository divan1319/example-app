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
                    <InputText v-model="formState.name" id="" class="w-full" />
                    <label for="">Nombre Libro</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText v-model="formState.isbn" id="" class="w-full" />
                    <label for="">ISBN</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText
                        v-model="formState.availability"
                        id=""
                        class="w-full"
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
                        class="w-full"
                    />
                    <label for="dd-location">Seleccione una ubicacion</label>
                </FloatLabel>
                <FloatLabel>
                    <Select
                        v-model="formState.author_id"
                        inputId="dd-author"
                        :options="authors"
                        optionLabel="author"
                        optionValue="id"
                        class="w-full"
                    />
                    <label for="dd-author">Seleccione un autor</label>
                </FloatLabel>

                <Button label="Actualizar" @click="onSubmit(props.data.id)" />
            </div>
        </Dialog>
    </div>
</template>

<script setup>
import Dialog from "primevue/dialog";
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import { onMounted, reactive, ref, watchEffect } from "vue";
import { useBookStore } from "../../../store/books";
import Button from "primevue/button";

const emits = defineEmits(["update:visible"]);

const props = defineProps({
    data: {
        type: Object,
    },
    visible: {
        type: Boolean,
    },
});

const store = useBookStore();
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

const onSubmit = async (id) => {
    await store.updateBook(id, formState).then(() => {
        cleanForm();
        emits("update:visible");
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

watchEffect(() => {
    if (props.data) {
        formState.book_id = props.data.book_id;
        formState.author_id = props.data.author_id;
        formState.availability = props.data.availability;
        formState.isbn = props.data.isbn;
        formState.location_id = props.data.location_id;
        formState.name = props.data.name;
    }
});
</script>
