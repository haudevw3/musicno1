## Giới thiệu

Đây là dự án cá nhân nhằm phục vụ sở thích nghe nhạc của bản thân.
Dự án này là bản tiền nhiệm được xây dựng dựa trên [Laravel framework](https://laravel.com/docs).

Bản gốc [MusicNo1](https://github.com/haudevw3/musicno1) được xây dựng dựa trên [PHP](https://www.php.net/docs.php)
và cùng với một [Foundation framework](https://github.com/haudevw3/foundation) do chính bản thân tự viết dựa trên Laravel.
Trong quá trình xây dựng vẫn còn rất nhiều thiếu sót nên bản gốc này chưa thể hoàn thành.

## Tổng quan

- Dự án phát triển theo hướng Multi-Page Application (MPA) sử dụng Server-Side Rendering (SSR).
- Giao diện được thiết kế dựa trên các trang nghe nhạc trực tuyến như [Zing MP3](https://zingmp3.vn) và [Spotify](https://open.spotify.com).
- Các tính năng phát triển theo hướng Modules và kết hợp với các Design Patterns như Service, Repository để đảm bảo kiến trúc rõ ràng dễ bảo trì.

## Công nghệ sử dụng

- Frontend: HTML, CSS, SCSS, Jquery.
- Backend: PHP (Laravel), MongoDB, Redis, Nginx.

## Modules

- adm (Quản lý các hành động như thêm, sửa, xóa,... của các modules album, artist, categories, user).
- album
- artist
- categories
- filemanager
- page
- track
- tracker
- user

## Các chức năng đã làm được

#basic: Chức năng cơ bản (thêm, sửa, xóa).

- album: `#basic`.
- artist: `#basic`.
- categories: `#basic`.
- filemanager: `#basic`.
- track: `#basic`.
- tracker: `#basic`.
