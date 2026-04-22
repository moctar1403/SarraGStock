<?php

namespace App\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait WithDelete
{
    public $deleteId = null;
    protected function confirmMessage(): string
    {
        return __('Voulez-vous vraiment supprimer ?');
    }
    
    /** Modèle concerné */
    // protected string $model;

    /** Relations bloquantes */
    // protected array $checkRelations = [];

    public function askDelete($id)
    { 
        $this->deleteId = $id;
        $this->dispatch(
            'open-delete-modal',
            message: $this->confirmMessage()
        );
    }

    public function delete()
    {
        
    }
}
