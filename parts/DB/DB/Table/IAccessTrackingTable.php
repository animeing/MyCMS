<?php

namespace db\table;

interface IAccessTrackingTable{
    /**
     * @param string
     */
    const TABLE_NAME = 'ACCESS_TRACKING';
    const DATA_ISLAND = 'DATA_ISLAND';
    const IP_ADDRESS = 'IP_ADDRESS';
    const ACCESS_URL = 'ACCESS_URL';
    const ACCESS_REQUEST_HEADER = 'ACCESS_REQUEST_HEADER';
    const ACCESS_RESPONSE_HEADER = 'ACCESS_RESPONSE_HEADER';
    const TIME_STAMP = 'TIME_STAMP';

    const PRIMARY_KEY = 'DATA_ISLAND';
}
