import { defineStore } from "pinia";
import { api } from "../services/api";
import { computed, reactive, ref } from "vue";

export const useBookStore = defineStore("books", () => {
    const books = ref([]);
    const booksLoaned = ref([]);
    const authors = ref([]);
    const locations = ref([]);
    const total = reactive({
        books: 0,
        loanedBooks: 0,
    });
    const errors = reactive({
        status: false,
        message: "",
    });

    const fetchDataAllBooks = async () => {
        await api
            .get("/books")
            .then((res) => {
                console.log(res);
                books.value = res.data.data;
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const getAuthors = async () => {
        await api
            .get("/authors")
            .then((res) => {
                console.log(res);
                authors.value = res.data.data;
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const getLocations = async () => {
        await api
            .get("/location")
            .then((res) => {
                console.log(res);
                locations.value = res.data.data;
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const saveBook = async (data) => {
        await api
            .post("/books/create", data)
            .then((res) => {
                console.log(res.data);
                fetchDataAllBooks();
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const disableBook = async (id) => {
        await api
            .put(`/books/${id}/disable`)
            .then((res) => {
                console.log(res.data);
                fetchDataAllBooks();
                return res.data.message;
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const allowBook = async (id) => {
        await api
            .put(`/books/${id}/allow`)
            .then((res) => {
                console.log(res.data);
                fetchDataAllBooks();
                return res.data.message;
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const updateBook = async (id, data) => {
        await api
            .put(`/books/${id}/update`, data)
            .then((res) => {
                console.log(res.data);
                fetchDataAllBooks();
            })
            .catch((error) => {
                console.log(error);
                hasErrors(true, error.response.data.message);
            });
    };

    const loanBook = async (id, data) => {
        await api
            .post(`/books/loans/${id}/create`, data)
            .then((res) => {
                console.log(res.data);
                fetchDataAllBooks();
                hasErrors(false, "");
            })
            .catch((error) => {
                //console.log(error.response.data.message)
                hasErrors(true, error.response.data.message);
            });
    };

    const getLoanedBooks = async () => {
        await api
            .get("/books/loaned")
            .then((res) => {
                hasErrors(false, "");
                booksLoaned.value = res.data.data;
            })
            .catch((error) => {
                //console.log(error.response.data.message)
                hasErrors(true, error.response.data.message);
            });
    };

    const returnBook = async (id, data) => {
        await api
            .put(`/books/loans/${id}/update`, data)
            .then((res) => {
                getLoanedBooks();
                console.log(res);
                hasErrors(false, "");
            })
            .catch((error) => {
                console.log(error.response);
                hasErrors(true, error.response.data.message);
            });
    };

    const getTotalBooks = async () => {
        await api
            .get("/books/total_books")
            .then((res) => {
                console.log(res.data);
                total.books = res.data.total_libro;
                total.loanedBooks = res.data.total_prestados;
                hasErrors(false, "");
            })
            .catch((error) => {
                console.log(error.response);
                hasErrors(true, error.response.data.message);
            });
    };

    const hasErrors = (status, message) => {
        errors.status = status;
        errors.message = message ?? errors.message;
    };

    return {
        ///states
        books,
        authors,
        locations,
        errors,
        booksLoaned,
        total,
        //actions
        fetchDataAllBooks,
        getAuthors,
        getLocations,
        saveBook,
        disableBook,
        updateBook,
        loanBook,
        hasErrors,
        getLoanedBooks,
        returnBook,
        allowBook,
        getTotalBooks,
    };
});
