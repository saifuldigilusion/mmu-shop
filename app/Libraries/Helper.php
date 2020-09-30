<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Helper {
    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value ) {
            $v = trim( $value, "'" );
            //Log::debug($v);
            #$enum = array_add($enum, $v, $v);
            $enum[] = $v;
        }
        return $enum;
    }
}
