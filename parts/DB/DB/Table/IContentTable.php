<?php

namespace db\table;

interface IContentTable{
    const TABLE_NAME = 'GENRE';

    const CONTENT_NAME = 'CONTENT_NAME';
    //投稿日
    const CONTENT_URI = 'CONTENT_URI';
    const CONTENT_DAY = 'CONTENT_DAY';
    const CONTENT_UPDATE_DAY = 'CONTENT_UPDATE_DAY';
    const CONTENT_UP_USER_NAME = 'CONTENT_UP_USER';
    const CONTENT_UPDATE_USER_NAME = 'CONTENT_UPDATE_USER_NAME';
    const CONTENT_GENRE_ARRAY = 'CONTENT_GENRE_ARRAY';
}

