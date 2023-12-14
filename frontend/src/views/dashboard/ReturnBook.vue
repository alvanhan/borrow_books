<template>
    <div>
        <div class="row text-center my-5">
            <h3>List Your Book</h3>
        </div>
        <h1></h1>
        <div class="container">
            <div class="row">
                <div v-if="alert.type" class="alert" :class="`alert-${alert.type} alert-dismissible fade show`"
                    role="alert">
                    {{ alert.message }}
                    <button type="button" class="btn-close" @click="hideAlert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="card-deck">
            <div v-for="borrowedBook in borrowedBooks" :key="borrowedBook.id" class="card">
                <img :src="borrowedBook.books.image" class="card-img-top" alt="Book Cover">
                <div class="card-body">
                    <h5 class="card-title">{{ borrowedBook.books.title }}</h5>
                    <p class="card-text">Borrowed Date: {{ borrowedBook.borrows_date }}</p>
                    <p class="card-text">Return Date: {{ borrowedBook.return_date || 'Not Returned' }}</p>
                    <button v-if="!borrowedBook.return_date" @click="returnBook(borrowedBook.id)"
                        class="btn btn-primary me-3">Return Book</button>
                    <button v-if="borrowedBook.return_date" @click="deleteBorrowedBook(borrowedBook.id)" class="btn btn-danger">Delete</button>
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
            borrowedBooks: [],
            alert: { type: '', message: '' },
        };
    },
    async mounted() {
        await this.fetchBorrowedBooks();
    },
    methods: {
        async fetchBorrowedBooks() {
            try {
                const authToken = localStorage.getItem('authToken');
                const response = await axios.get('http://127.0.0.1:8000/api/borrow', {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                });
                this.borrowedBooks = response.data.data;
            } catch (error) {
                console.error('Error fetching borrowed books:', error);
            }
        },
        async returnBook(borrowId) {
            try {
                const authToken = localStorage.getItem('authToken');
                await axios.put(`http://127.0.0.1:8000/api/borrow/${borrowId}`, null, {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                });
                await this.fetchBorrowedBooks();
                this.showAlert('success', 'Book returned successfully.');
            } catch (error) {
                console.error('Error returning book:', error);
                this.showAlert('danger', 'Failed to return the book.');
            }
        },
        async deleteBorrowedBook(borrowId) {
            try {
                const authToken = localStorage.getItem('authToken');
                await axios.delete(`http://127.0.0.1:8000/api/borrow/${borrowId}`, {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                });
                await this.fetchBorrowedBooks();
                this.showAlert('success', 'Borrowed book deleted successfully.');
            } catch (error) {
                console.error('Error deleting borrowed book:', error);
                this.showAlert('danger', 'Failed to delete the borrowed book.');
            }
        },
        showAlert(type, message) {
            this.alert = { type, message };
            setTimeout(() => {
                this.alert = { type: '', message: '' };
            }, 5000);
        },
        hideAlert() {
            this.alert = { type: '', message: '' };
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
  