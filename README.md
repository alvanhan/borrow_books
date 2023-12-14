

## Project Setup


#

### REST API (Backend) LARAVEL  V.10 PHP min.8.1

cara install :

masuk folder backend dan run :

```sh
composer install
```
generate key nya

```sh
php artisan key:generate
```
pastikan .env telah di configurasi untuk database local nya 

install auth untuk passport , karena api saya mengintegrasikanya dengan passport
```sh
php artisan passport:install
```

run migration dan seeder untuk table , (database MYSQL)
```sh
php artisan migrate --seed
```

run local api nya dan pastikan dengan url : http://127.0.0.1:8000
```sh
php artisan serve
```
#

Setelah itu jika sudah berjalan set up bagian frontend nya :

#

### Frontend Di buat dengan  VUEJS 3 

cara install :

masuk ke folder frontend dan run :

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

setelah itu akan running di port : http://localhost:5173/ dan kunjungi website nya.



### Preview project :


### Fitur & Sitem:
#
    Informasi tech :
    Login register (authentication) menggunakan passport karena lebih aman dan token di simpan di database, tidak seperti JWT.

    Informasi singkat aplikasi :
    Simple Liblary yaitu adanya member sebagi user yang dimana user bisa meminjam buka yang tersedia bedarsarkan list dan stock yang tersedia.

    fitu utama peminjaman buku per user, limit peminjaman , pengembalian buku , dan penghapusan list data buku yang telah di pinjam.
#


### Schema :
#
    Informasi alur.
    3 relasi table yaitu USER atau member , BORROW atau peminjaman , dan BOOKS yang dimana user dapat meminjam banyak buku yang berbeda beda dengan maks 1 perjudul serta user dapat mengembalikan buku yang di pinjam setelah itu buku akan meng update otomatis jika buku di pinjam dan di kembalikan.

    Informasi Relasi table.
    USER belongsto BORROW dAN BORROW hasmany to BOOKS
#
