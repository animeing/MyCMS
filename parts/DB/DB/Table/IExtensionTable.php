<?php

namespace db\table;

interface IExtensionTable{
    const TABLE_NAME = 'EXTENSION';
    const EXTENSION_NAME = 'EXTENSION_NAME';
    const EXTENSION_DESCRIPTION = 'DESCRIPTION';
    const IS_USE = 'IS_USE';
    const INSTALL_DAY = 'INSTALL_DAY';
    const CHANGE_DAY = 'CHANGE_DAY';
    const CALL_ALLOW_CONTENT = 'CALL_ALLOW_CONTENT';
    
    const PRIMARY_KEY = 'EXTENSION_NAME';
}