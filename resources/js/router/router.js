import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("../shared/DashBoard.vue"),
        },
        {
            path: "/all-books",
            name: "all-books",
            component: () => import("../view/Books/AllBooks.vue"),
        },
        {
            path: "/loaned-books",
            name: "loaned-books",
            component: () => import("../view/Books/LoanedBooks.vue"),
        },
    ],
});

export default router;
