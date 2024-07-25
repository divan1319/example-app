import { defineStore } from "pinia";
import { ref } from "vue";
import { api } from "../services/api";

export const useUserStore = defineStore("users", () => {
    const users = ref([]);

    const getUsers = async () => {
        await api
            .get("/users")
            .then((res) => {
                console.log(res.data);
                users.value = res.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    return {
        users,
        getUsers,
    };
});
