<?php

namespace App\Helpers;

class MachineHelper
{
    public static function machineId()
    {
        $output = shell_exec(
            'reg query HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Cryptography /v MachineGuid'
        );

        if (preg_match('/MachineGuid\s+REG_SZ\s+(.+)/', $output, $m)) {
            return trim($m[1]);
        }

        return null;
    }
}
