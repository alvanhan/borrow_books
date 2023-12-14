<template>
    <div>
        <div class="row text-center my-5">
            <h3>Welcome to simple library, choose to borrow!</h3>
        </div>
        <h1></h1>
        <div class="container">
            <div class="row">
                <div v-if="alert.type" class="alert" :class="`alert-${alert.type} alert-dismissible fade show`" role="alert">
                    {{ alert.message }}
                    <button type="button" class="btn-close" @click="hideAlert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="card-deck">
            <div v-for="book in books" :key="book.id">
                <div class="card">
                    <img :src="book.image" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <div v-if="book.stock > 0">
                            <h5 class="card-title">{{ book.title }}</h5>
                            <p class="card-text">{{ book.author }}</p>
                            <p class="card-text">Stock: {{ book.stock }}</p>
                            <button v-on:click="borrowBook(book.id)" class="btn btn-primary">Borrow</button>
                        </div>
                        <div v-else>
                            <h5 class="card-title">{{ book.title }}</h5>
                            <p class="card-text">{{ book.author }}</p>
                            <p class="card-text">Out of Stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: [],
            alert: { type: '', message: '' },
        };
    },
    async mounted() {
        await this.fetchBooks();
    },
    methods: {
        async borrowBook(bookId) {
            try {
                const authToken = localStorage.getItem('authToken');
                const response = await axios.post('http://127.0.0.1:8000/api/borrow', { book_id: bookId }, {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                });
                await this.fetchBooks();
                this.showAlert('success', response.data.data);
            } catch (error) {
                console.error('Error borrowing book:', error);

                this.showAlert('danger', error.response.data.data);
            }
        },
        async fetchBooks() {
            try {
                const authToken = localStorage.getItem('authToken');
                const response = await axios.get('http://127.0.0.1:8000/api/books', {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                });
                this.books = response.data.data;
            } catch (error) {
                console.error('Error fetching book data:', error);
            }
        },
        showAlert(type, message) {
            this.alert = { type, message };

            setTimeout(() => {
                this.alert = { type: '', message: '' };
            },2500);
        },
    },
};
</script>
  
<style scoped>
.card-deck {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.card {
    width: 15rem;
    height: auto;
    margin-bottom: 1rem;
}
</style>
  