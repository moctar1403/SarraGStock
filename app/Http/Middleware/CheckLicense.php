<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\License;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MachineHelper;
class CheckLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $machineHash = MachineHelper::machineId();
        // Normal: vérifier si licence active
        $license = License::where('activated', 1)
            ->where('machine_hash', $machineHash)
            ->first();
        if (!$license) {
            return redirect()->route('activation.form')
            ->with('error', 'Veuillez activer votre licence.');
        }
    return $next($request);
    }
    

}
