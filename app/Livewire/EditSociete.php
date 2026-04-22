<?php

namespace App\Livewire;

use App\Models\Societe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EditSociete extends Component
{
    use WithFileUploads;
    
    public $societe;
    public $soc_nom;
    public $soc_adresse;
    public $soc_code_postal;
    public $soc_tel;
    public $soc_email;
    public $soc_nif;
    public $soc_rc;
    public $soc_logo;
    public $soc_new_logo;
    public $old_logo;
    public $soc_observations = "";
    
    public function store()
    {
        // Validation
        $this->validate([
            'soc_nom' => 'string|required',
            'soc_adresse' => 'string|required',
            'soc_tel' => 'string|required',
            'soc_email' => 'email|nullable',
            'soc_nif' => 'string|nullable',
            'soc_rc' => 'string|nullable',
            'soc_new_logo' => 'nullable|sometimes|image|max:1024|mimes:jpg,jpeg,png,webp|dimensions:min_width=30,max_width=200,min_height=30,max_height=200',
            'soc_observations' => 'string|nullable',
        ]);

        $logoPath = $this->old_logo;

        // Gestion du nouveau logo
        if ($this->soc_new_logo) {
            // Générer un nom unique pour le fichier
            $filename = Str::uuid() . '.' . $this->soc_new_logo->extension();
            
            // Chemin complet du dossier de destination
            $destinationPath = public_path('uploads/societes');
            
            // Créer le dossier s'il n'existe pas
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            // Chemin complet du fichier
            $fullPath = $destinationPath . '/' . $filename;
            
            // Enregistrer le fichier en utilisant la méthode storeAs() de Livewire
            $tempPath = $this->soc_new_logo->storeAs('temp', $filename, 'public');
            
            // Copier vers la destination finale
            if ($tempPath) {
                $tempFullPath = storage_path('app/public/' . $tempPath);
                if (File::exists($tempFullPath)) {
                    File::copy($tempFullPath, $fullPath);
                    
                    // Nettoyer le fichier temporaire
                    File::delete($tempFullPath);
                    
                    // Supprimer l'ancien logo s'il existe
                    if ($this->old_logo && File::exists(public_path($this->old_logo))) {
                        File::delete(public_path($this->old_logo));
                    }
                    
                    // Chemin relatif pour la base de données
                    $logoPath = 'uploads/societes/' . $filename;
                }
            }
        }

        try {
            $this->societe->update([
                'soc_nom' => $this->soc_nom,
                'soc_adresse' => $this->soc_adresse,
                'soc_tel' => $this->soc_tel,
                'soc_email' => $this->soc_email ?? '',
                'soc_code_postal' => $this->soc_code_postal ?? '',
                'soc_nif' => $this->soc_nif ?? '',
                'soc_rc' => $this->soc_rc ?? '',
                'soc_logo' => $logoPath ?? '',
                'soc_observations' => $this->soc_observations ?? '',
                'soc_saisi_par' => Auth::id(),
            ]);

            trace(
                "Modification de la société id {$this->societe->id} {$this->societe->soc_nom}",
                Societe::class
            );

            return redirect()
                ->route('configs.societe')
                ->with('success', __('Informations modifiées avec succès'));

        } catch (\Exception $e) {
            return redirect()
                ->route('configs.societe')
                ->with('danger', 'Un problème est rencontré: ' . $e->getMessage());
        }
    }
    
    public function mount()
    {
        $this->soc_nom = $this->societe->soc_nom;
        $this->soc_adresse = $this->societe->soc_adresse;
        $this->soc_tel = $this->societe->soc_tel;
        $this->soc_email = $this->societe->soc_email;
        $this->soc_code_postal = $this->societe->soc_code_postal;
        $this->soc_nif = $this->societe->soc_nif;
        $this->soc_rc = $this->societe->soc_rc;
        $this->soc_observations = $this->societe->soc_observations;
        $this->old_logo = $this->societe->soc_logo;
    }

    public function render()
    {
        return view('livewire.edit-societe');
    }
}