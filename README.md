## Giới thiệu
+ Đây là dự án cá nhân nhằm phục vụ sở thích nghe nhạc của bản thân. Dự án này là bản tiền nhiệm được xây dựng dựa trên [Laravel framework](https://laravel.com/docs).
+ Bản gốc [MusicNo1](https://github.com/haudevw3/musicno1) được xây dựng dựa trên [PHP](https://www.php.net/docs.php) và cùng với một [Foundation framework](https://github.com/haudevw3/foundation) do chính bản thân tự viết dựa trên Laravel. Trong quá trình xây dựng vẫn còn rất nhiều thiếu sót nên bản gốc này chưa thể hoàn thành.

## Tổng quan
+ Dự án phát triển theo hai hướng MPA (Multi-Page Application) và SPA (Single-Page Application) sử dụng SSR (Server-Side Rendering).
+ Về mặt giao diện và tính năng được thiết kế dựa trên các trang web có sẵn như Spotify và ZingMP3.
+ Cấu trúc thư mục và cách tổ chức code theo hướng modules để đảm bảo kiến trúc rõ ràng dễ bảo trì.

## Công nghệ sử dụng
+ Backend: PHP/Laravel, MongoDB, Redis, Nginx.
+ Frontend: HTML, CSS/SCSS, Javascript/Jquery.

## Modules
+ adm (Quản lý các hành động như thêm, sửa, xóa,... của các modules khác)
+ album
+ artist
+ categories
+ filemanager
+ page
+ track
+ tracker
+ user

## Các chức năng đã làm được
+ album: `CRUD`
+ artist: `CRUD`
+ categories: `CRUD`
+ filemanager: `CRUD`
+ track: `CRUD`
+ tracker: `CRUD`
+ user:
    - `CRUD`
    - đăng nhập trên một thiết bị, với Google
    - đăng ký
    - quên mật khẩu
    - gửi email
    - theo dõi trạng thái hoạt động

## Dự kiến trong tương lai
+ Frontend: ReactJS.

