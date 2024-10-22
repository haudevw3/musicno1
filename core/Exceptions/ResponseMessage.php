<?php

namespace Core\Exceptions;

class ResponseMessage
{
    const HTTP_FORBIDDEN = 'Bạn không có quyền truy cập tài nguyên này.';
    const HTTP_INTERNAL_SERVER_ERROR = 'Lỗi máy chủ nội bộ. Vui lòng thử lại sau.';
}