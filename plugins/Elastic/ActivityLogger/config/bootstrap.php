<?php

/**
 *
 * Copyright 2016 ELASTIC Consultants Inc.
 *
 */
use Cake\Database\Type;

if (!Type::getMap('json_data')) {
    Type::map('json_data', '\Elastic\ActivityLogger\Database\Type\JsonDataType');
}