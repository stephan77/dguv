<?php

use Illuminate\Support\Facades\DB;

function setting($key, $default = null)
{
    return DB::table('settings')
        ->where('key', $key)
        ->value('value') ?? $default;
}