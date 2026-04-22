<?php

namespace App\Livewire;

use Livewire\Component;


class TicketValidation extends Component
{
    public $tickets = [
        [
            'firstname' => '',
            'lastname' => '',
            'email' => '',
        ],
    ];

    public function rules()
    {
        $rules = [];

        foreach ($this->tickets as $index => $ticket) {
            $rules["tickets.{$index}.firstname"] = 'required|string';
            $rules["tickets.{$index}.lastname"] = 'required|string';
            $rules["tickets.{$index}.email"] = 'required|email';
        }

        return $rules;
    }
    public function messages(): array
    {
        return[
            'tickets.*.firstname.required' => 'firstname :position est requis',
            'tickets.*.lastname.required' => 'firstname :position est requis',
            'tickets.*.email.required' => 'email :position est requis',
            'tickets.*.email.email' => 'email :position non valide',
        ];

    }
    public function store()
    {
        $this->validate();
        dd('je suis');
    }
    public function addTicket()
    {
        $this->tickets[] = [
            'firstname' => '',
            'lastname' => '',
            'email' => '',
        ];
    }
    public function removeTicket($index)
    {
        unset($this->tickets[$index]);
        $this->tickets = array_values($this->tickets);
    }
    public function render()
    {
        return view('livewire.ticket-validation');
    }
}
