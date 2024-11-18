<?php

namespace Modules\User;

class Constant
{
    const ADMIN_ROLE = 1;

    const MEMBER_ROLE = 2;

    const DEFAULT_EXP = 180;

    const ACCESS_TOKEN_EXP = 180;

    const REFRESH_TOKEN_EXP = 1800;

    const TOKEN_EXPIRATION_TIME = 300;

    const TIME_OF_ONE_DAY = 86400;
    
    const LIMITED_SEND_EMAIL = 3;

    const LIMITED_SEND_EMAIL_FORGET_PASSWORD = 1;
}