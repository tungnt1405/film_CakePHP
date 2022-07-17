# WEB XEM PHIM ĐƯỢC XÂY DỰNG DỰA TRÊN FRAMEWORK CAKEPHP

## Các bước cài đặt chương trình
0. Chuẩn bị xampp và composer
1. pull code từ nhánh master
2. Checkout sang nhánh develop để pull code chính về
3. Sau khi đã lấy code từ nhánh develop về thì chạy lệnh 
``` composer update```
hoặc
``` composer install ``` (version php >= 8.0.2 mới dùng)
4. Vào thư mục config để tạo file app_local.php từ app_local.example.php
5. Sau khi tạo file app_local.php thì nhập tên database và username, password của mysql
6. Sau khi nhập tên database thì chạy lệnh
```
bin/cake migrations migrate
```
để lấy thông tin các bảng
7. Chạy lệnh
``` bin/cake server ```
để chạy chương trình
