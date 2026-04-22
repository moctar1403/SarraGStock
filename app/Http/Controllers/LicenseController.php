<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\MachineHelper;

class LicenseController extends Controller
{
    public function form()
    {
        $machineHash = MachineHelper::machineId();

        // Licence déjà activée sur CE PC
        $license = License::where('activated', 1)
            ->where('machine_hash', $machineHash)
            ->first();

        if ($license) {
            return redirect()->route('dashboard')
                ->with('info', 'La licence est déjà activée sur ce PC.');
        }

        return view('activation');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string|regex:/^[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}$/',
        ]);

        $machineHash = MachineHelper::machineId();

        // On charge toutes les licences
        $licenses = License::all();

        foreach ($licenses as $license) {

            // 🔐 Vérification du hash de licence
            if (Hash::check($request->license_key, $license->license_key)) {

                // ❌ Licence déjà utilisée sur un autre PC
                if ($license->activated && $license->machine_hash !== $machineHash) {
                    return back()->withErrors([
                        'license_key' => 'Cette licence est déjà utilisée sur un autre ordinateur.',
                    ]);
                }

                // ✅ Première activation OU même PC
                $license->update([
                    'activated'     => 1,
                    'activated_at'  => now(),
                    'machine_hash'  => $machineHash,
                ]);

                return redirect('/dashboard')
                    ->with('success', 'Licence activée avec succès.');
            }
        }

        return back()->withErrors([
            'license_key' => 'Code invalide.',
        ]);
    }
}
