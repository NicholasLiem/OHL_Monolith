# Seleksi Asisten Labpro - Monolith
## **Author**
Nicholas Liem - 13521135

## **How to Run The Program**
1. Clone this repository
```sh
https://github.com/NicholasLiem/OHL_Monolith.git
```
2. Change the current directory to `OHL_Monolith` folder
```sh
cd OHL_Monolith
```
3. Build and run the container <br>
Your app should be running at port :80 or just simply open localhost
```sh
docker-compose up --build
```
## **Design Patterns**
1. Model-View-Controller Pattern (Architectural) <br>
Framework Laravel menyediakan bentuk arsitektur yang mendukung MVC, controller yang dibuat mengikuti kebutuhan dari model. Misalnya ada controller untuk Login, Register, Logout, Catalog, dsb. Karena setiap "fitur" memiliki controllernya sendiri-sendiri, kode jadi lebih readable dan maintainable.

2. Stategy Pattern <br>
Penggunaan util function untuk repons message dalam bentuk format yang generik dan custom. Misalnya, dalam kelas ResponseUtils ada fungsi yang mengembalikan response dalam bentuk status bar dan juga ada yang dalam bentuk json. Selain itu juga dibedakan lagi, pesan sukses dan error yang memiliki format berbeda dan sebagainya.

3. Template Method Pattern <br>
Framework Laravel menyediakan blade sebagai salah satu provider kebutuhan frontendnya. Pada struktur kode blade, dapat disisipkan bagian-bagian sections misalnya untuk content maupun scripts yang bisa diisi oleh kode blade dari file lain. Kegunaannya adalah untuk mempertahankan struktur utama kode frontend pada subkelas yang memiliki isi-isi spesifik (catalog, dll).

## **Endpoints**
| Endpoint             | Method   | Description                                        |
|----------------------|----------|----------------------------------------------------|
| /auth/login          | GET      | Show login page                                    |
| /auth/login          | POST     | Login verification                                 |
| /auth/register       | GET      | Show register page                                 |
| /auth/register       | POST     | Register verification                              |
| /auth/logout         | POST     | Logout (Clearing Tokens)                           |
| /dashboard           | GET      | Show dashboard page                                |
| /catalog/{id}        | GET      | Show detailed information of barang with given id  |
| /catalog             | GET      | Show all registered barang                         |
| /order/{id}          | GET      | Show order detail                                  |
| /order/{id}/purchase | POST     | Order process of barang with given id              |
| /history             | GET      | Show list of transactions a user has made          |
| /self                | GET      | Show login status                                  |

## **Tech Stack**
Laravel, MySQL

## **SOLID**
1. Single Responsibility Principle <br>
Setiap kebutuhan yang berhubungan dengan use-case dibuatlah controller yang bersesuaian.
Dalam repo ini, terdapat Auth group controller yang terdiri dari Login, Logout, dan Register.
Untuk kebutuhan katalog, terdapat CatalogController. Untuk kebutuhan histori transaksi, terdapat TransactionController, dsb.
Masing-masing controller hanya mengatur kebutuhannya masing-masing dan tidak terdiri di luar kebutuhan use-casenya.

2. Open Closed Principle <br>
Open Closed Principle yang digunakan pada repo ini adalah dalam penggunaan fungsi util, yakni ResponseUtils yang menyesuaikan hasil keluaran dari suatu route / pemanggilan route. Tidak perlu mengubah data yang ingin dikirimkan tetapi menyesuaikannya dalam bentuk penambahan fungsi yang sesuai untuk kebutuhannya. Misalnya response error punya fungsinya sendiri yang berbeda dari reponse sukses.

3. Liskov Substitution Principle <br>
Tidak ada inheritence yang digunakan dalam repository ini.

4. Interface Segregation <br>
Setiap controller mengimplementasi method-method yang diperlukan untuk fungsionalitasnya. Tidak ada controller yang dipaksa untuk mengimplementasi method-method yang tidak diperlukan.

5. Dependency Injection <br>
Tidak ada penggunaan dependency injection dalam repository ini.

## **Bonus Report**
| Features                                                     | Yes      | No |
|--------------------------------------------------------------|----------|----|
| B02 - Deployment                                             | &check;  |    |
| B04 - Polling                                                | &check;  |    |
| B08 - SOLID                                                  | &check;  |    |
| B11 [01] - Fitur Tambahan (Search Functionality For Catalog) | &check;  |    |
| B11 [02] - Fitur Tambahan (Status Bar)                       | &check;  |    |

## **Extras**
- This is a link to the single service repository [click here!](https://github.com/NicholasLiem/OHL_SingleService)
- Amazon EC2 service is used for backend and frontend services and Amazon RDS for the MySQL server, deployment IPv4 Address (Backend and Frontend):
- Access to the database is currently managed by Amazon RDS hence you might not be able to connect it (connection is secured via proxy and other security methods).