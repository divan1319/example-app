<script setup>
import { usePrimeVue } from "primevue/config";
import Menubar from "primevue/menubar";
import { ref } from "vue";
import { RouterView } from "vue-router";
const items = ref([
    {
        label: "Inicio",
        icon: "pi pi-home",
        routeName: "home",
    },
    {
        label: "Libros",
        icon: "pi pi-book",
        routeName: "all-books",
    },
    {
        label: "Libros Prestado",
        icon: "pi pi-list-check",
        routeName: "loaned-books",
    },
]);
const primeVue = usePrimeVue();
primeVue.config.ripple = true;
</script>
<template>
    <div class="card">
        <Menubar :model="items">
            <template #item="{ item, props }">
                <router-link
                    v-if="item.routeName"
                    v-slot="{ href, navigate }"
                    :to="{ name: item.routeName }"
                    custom
                >
                    <a
                        v-ripple
                        :href="href"
                        v-bind="props.action"
                        @click="navigate"
                    >
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                </router-link>
            </template>
        </Menubar>
    </div>
    <RouterView />
</template>
