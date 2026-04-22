<?php
namespace App\Livewire;
// use App\helpers;
use Livewire\Component;
use App\Models\Entrstock;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Traits\WithDelete;

class ListeFournisseur extends Component
{
    use WithPagination;
    public $search = '';
    use WithDelete {
        delete as protected traitDelete;
    }
    public function delete()
    {
        $fournisseur=Fournisseur::where('id','=',$this->deleteId)->first();
        //verification s'il y a une entree pour le fournisseur 
        $entree=Entrstock::where('ent_fournisseur',$fournisseur->id)->first();
        if($entree){
            return redirect()->route('fournisseurs.index')->with('danger', __("Fournisseur n'est pas supprimé,car il a une entrée en stock"));
        }
        else{
            $fournisseur->delete();
            //table trace
            $data="Suppresiion du fournisseur id ".$fournisseur->id." nom ".$fournisseur->four_nom. " ";
            $model="App\Models\Fournisseur";
            trace($data,$model);
            return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur supprimé'));
        }
    }
    public function render()
    {
        if (!empty($this->search)) {
            $fournisseurs = Fournisseur::where('four_nom', 'like', '%' . $this->search . '%')
                            ->orWhere('four_societe', 'like', '%' . $this->search . '%')
                            ->orWhere('four_civilite', 'like', '%' . $this->search . '%')
                            ->orWhere('four_tel', 'like', '%' . $this->search . '%')
                            ->orWhere('four_adresse', 'like', '%' . $this->search . '%')
                            ->orWhere('four_email', 'like', '%' . $this->search . '%')
                            ->orWhere('four_saisi_par', 'like', '%' . $this->search . '%')
                            ->orderByDesc('four_situation')
                            ->paginate(10);
        }
        else {
            $fournisseurs = Fournisseur::where('id','>',0)->orderByDesc('four_situation')->paginate(10);
        } 
        // if ($fournisseurs) {
        //     foreach ($fournisseurs as $key => $value) {
        //         // $value->visit()->withIp()->withSession()->withData(["Hello"=>"Bonjour"])->withUser();
        //         // $value->visit()->withIp()->withSession()->withUser();
        //     }
        // }

        return view('livewire.liste-fournisseur',compact('fournisseurs'));
    }
}
