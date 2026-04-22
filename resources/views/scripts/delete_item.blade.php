{{-- Obtenir le nom complet --}}
    @php
        $componentName = $this->getName(); // Ex: "liste-fournisseur"
        $componentClass = get_class($this); // Ex: "App\Http\Livewire\ListeFournisseur"
    @endphp
<script>
    const currentComponent = @json($comp ?? $componentName);
    const currentMessage = @json($msg_confirm ?? 'Voulez-vous vraiment supprimer ?');
    
    function confirmDelete(id) {
        if (confirm(currentMessage)) {
            try {
                Livewire.emitTo(currentComponent, 'delete', id);
            } catch (error) {
                console.error('Erreur Livewire:', error);
                alert('Erreur lors de la suppression');
            }
        }
    }
</script>