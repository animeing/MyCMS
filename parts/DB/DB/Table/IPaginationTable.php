<?php

namespace db\table;

interface IPaginationTable{
    const TABLE_NAME = 'PAGINATION';
    const URI = 'URI';
    const PAGE_TITLE = 'PAGE_TITLE';
    const DRAFT_DAY = 'DRAFT_DAY';
    const DESCRIPTION = 'DESCRIPTION';
    /**
     * Argment param
     */
    const PAGE_DATA = 'PAGE_DATA';

    const PRIMARY_KEY = 'URI';
}