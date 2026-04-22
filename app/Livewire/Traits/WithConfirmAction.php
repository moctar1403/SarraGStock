<?php

namespace App\Livewire\Traits;

trait WithConfirmAction
{
    public $actionConfirmed = false;
    
    protected function confirmActionMessage(): string
    {
        return __('Voulez-vous vraiment effectuer cette action ?');
    }
    
    public function askConfirmAction()
    { 
        $this->actionConfirmed = false;
        $this->dispatch(
            'open-action-modal',
            message: $this->confirmActionMessage()
        );
    }
    
    public function confirmStore()
    {
        $this->actionConfirmed = true;
        // Cette méthode sera surchargée dans le component
    }
}