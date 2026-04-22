<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer une licence
        $plain = $this->generateLicenseKey();
        $hashed = Hash::make($plain); 
        $license = new License();
        $license->license_key =  $hashed;
        $license->activated = 0;
        $license->save();
        echo "Clé lisible : $plain\n";
        echo "Clé hashée : $hashed\n";
    }
    protected function generateLicenseKey() {
        $segments = [];
        for ($i = 0; $i < 3; $i++) {
            $segments[] = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        }
        return implode('-', $segments); // Exemple: AB3F-1C2D-9E4F
    }
}
