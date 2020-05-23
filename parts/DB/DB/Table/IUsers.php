<?php

namespace db\table;

interface IUsers {
    
    const TABLE_NAME = 'USERS';
    const ID = 'ID';
    const USER_NAME = 'USER_NAME';
    const USER_PASS = 'USER_PASS';
    const MAIL_ADDRESS = 'MAIL_ADDRESS';
    const AUTO_LOGIN_CHECK = 'AUTO_LOGIN_CHECK';
    const LAST_LOGIN = 'LAST_LOGIN';
    const LOGIN_TIME = 'LOGIN_TIME';
    const LANGUAGE = 'LANGUAGE';

    const PRIMARY_KEY = 'USER_NAME';
}