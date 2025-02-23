## Mô tả

+ Đây là dự án cá nhân phục vụ cho sở thích nghe nhạc của bản thân, dự án này đang trong quá trình development và chưa thể production nên chưa có một cái nhìn tổng quan về chức năng cũng như giao diện.

## Tổng quan

+ Dự án phát triển theo hướng `MPA (Multi-Page Application)` và kết hợp với kĩ thuật `AJAX`.
+ Về mặt giao diện và tính năng được thiết kế dựa trên các trang web có sẵn như `Spotify` và `ZingMP3`.
+ Cấu trúc thư mục và cách tổ chức code theo hướng `Modules` để đảm bảo kiến trúc rõ ràng dễ bảo trì.

## Công nghệ sử dụng

+ Backend: Laravel, Laravel-Mix, MongoDB, Redis, Nginx.
+ Frontend: HTML, CSS, Sass, Jquery.

## Modules

+ adm
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
    - Đăng nhập trên một thiết bị, với Google
    - Đăng ký
    - Quên mật khẩu
    - Gửi email
    - Theo dõi trạng thái hoạt động của người dùng

## Dự kiến trong tương lai

+ Phát triển theo hướng SPA (Single Page Application)
+ Frontend: VueJS, TailwindCSS
