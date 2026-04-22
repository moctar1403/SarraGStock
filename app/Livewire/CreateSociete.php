<?php

namespace App\Livewire;

use App\Models\Societe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

//use Illuminate\Support\Facades\Storage;

class CreateSociete extends Component
{
    use WithFileUploads;

    public $soc_nom;
    public $soc_adresse;
    public $soc_code_postal;
    public $soc_tel;
    public $soc_email;
    public $soc_nif;
    public $soc_rc;
    public $soc_logo;
    public $soc_observations = '';

    public function store()
    {
        //Validation 
        $this->validate([
            'soc_nom' => 'required|string|max:200',
            'soc_adresse' => 'required|string|max:200',
            'soc_tel' => 'required|string|max:200',
            'soc_email' => 'nullable|email|max:200',
            'soc_nif' => 'nullable|string|max:200',
            'soc_rc' => 'nullable|string|max:200',
            'soc_logo' => 'nullable|image|max:200|mimes:jpg,jpeg,png,webp|max:1024|dimensions:min_width=30,max_width=200,min_height=30,max_height=200',
            'soc_observations' => 'nullable|string|max:200',
        ]);
        $logoPath = null;
        if ($this->soc_logo !=null) {
            // dd($this->soc_logo);
            // Générer un nom unique pour le fichier
            $filename = Str::uuid() . '.' . $this->soc_logo->extension();
        
            // Chemin complet du dossier de destination
            $destinationPath = public_path('uploads/societes');
            
            // Créer le dossier s'il n'existe pas
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            // Chemin complet du fichier
            $fullPath = $destinationPath . '/' . $filename;
            
            // Enregistrer le fichier en utilisant la méthode storeAs() de Livewire
            // D'abord le stocker temporairement
            $tempPath = $this->soc_logo->storeAs('temp', $filename, 'public');
            // Puis le copier vers la destination finale
            if ($tempPath) {
                $tempFullPath = storage_path('app/public/' . $tempPath);
                if (File::exists($tempFullPath)) {
                    File::copy($tempFullPath, $fullPath);
                    // Nettoyer le fichier temporaire
                    File::delete($tempFullPath);
                }
            }
            
            // Chemin relatif pour la base de données
            $logoPath = 'uploads/societes/' . $filename;
        }

        try {
            $societe = new Societe();
            $societe->soc_nom = $this->soc_nom;
            $societe->soc_adresse = $this->soc_adresse;
            $societe->soc_tel = $this->soc_tel;
            $societe->soc_email = $this->soc_email ?? '';
            $societe->soc_code_postal = $this->soc_code_postal ?? '';
            $societe->soc_nif = $this->soc_nif ?? '';
            $societe->soc_rc = $this->soc_rc ?? '';
            $societe->soc_logo = $logoPath ?? '';
            $societe->soc_observations = $this->soc_observations ?? '';
            $societe->soc_saisi_par = Auth::id();

            $societe->save();

            trace(
                "enregistrement de la societe id {$societe->id} {$societe->soc_nom}",
                Societe::class
            );

            $this->reset();

            return redirect()
                ->route('configs.societe')
                ->with('success', __('Informations ajoutées avec succès'));

        } catch (\Exception $e) {
            // Afficher l'erreur pour le débogage
            return redirect()
                ->route('configs.societe')
                ->with('danger', 'Un problème est rencontré: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-societe');
    }
}