<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produto;

class Produtos extends Component
{
   public $produtos, $nome, $descricao, $produtos_id;
    public $isOpen = 0;

 
    public function render()
    {
        $this->produtos = Produto::all();
        return view('livewire.produtos');
    }

 
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

  
    public function openModal()
    {
        $this->isOpen = true;
    }

 
    public function closeModal()
    {
        $this->isOpen = false;
    }

  
    private function resetInputFields(){
        $this->nome = '';
        $this->produtos = '';
        $this->produtos_id = '';
    }

  
    public function store()
    {
        $this->validate([
            'nome' => 'required',
            'descricao' => 'required',
        ]);

        Produto::updateOrCreate(['id' => $this->produtos_id], [
            'nome' => $this->nome,
            'descricao' => $this->descricao
        ]);

        session()->flash('message',
            $this->produtos_id ? 'Produto Atualizado com Sucesso.' : 'Produto Criado com Sucessso.');

        $this->closeModal();
        $this->resetInputFields();
    }
 


    public function edit($id)
    {
        $produtos = Produto::findOrFail($id);
        $this->produtos_id = $id;
        $this->nome = $produtos->nome;
        $this->descricao = $produtos->descricao;

        $this->openModal();
    }

    public function show($id)
    {
        $produtos = Produto::findOrFail($id);
        $this->produtos_id = $id;
        $this->nome = $produtos->nome;
        $this->descricao = $produtos->descricao;

        $this->openModal();
    }




    public function delete($id)
    {
        Produto::find($id)->delete();
        session()->flash('message', 'Produto Apagado com Sucesso.');
    }
}
