<?php

namespace content;

interface IContent{
    function getHttpHeader();
    function getHttpHead();
    function getContent();
}