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
        
        // Afficher à l'écran
        echo "Clé lisible : $plain\n";
        echo "Clé hashée : $hashed\n";
        
        // Écrire dans un fichier (chemin absolu)
        $licenceDir = 'C:\\SarraGstock\\licence\\';
        if (!file_exists($licenceDir)) {
            mkdir($licenceDir, 0777, true);
        }
        
        $licenceFile = $licenceDir . 'license_key_' . date('Y-m-d-H-i-s') . '.txt';
        $content = "========================================\n";
        $content .= "LICENCE GÉNÉRÉE LE : " . date('d/m/Y H:i:s') . "\n";
        $content .= "========================================\n\n";
        $content .= "CLÉ DE LICENCE (à fournir à l'utilisateur) :\n";
        $content .= "$plain\n\n";
        $content .= "CLÉ HASHÉE (stockée en base de données) :\n";
        $content .= "$hashed\n\n";
        $content .= "========================================\n";
        
        file_put_contents($licenceFile, $content);
        echo "Fichier de licence créé : $licenceFile\n";
    }
    
    protected function generateLicenseKey() {
        $segments = [];
        for ($i = 0; $i < 3; $i++) {
            $segments[] = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        }
        return implode('-', $segments); // Exemple: AB3F-1C2D-9E4F
    }
}