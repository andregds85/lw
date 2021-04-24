<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produto;

class Produtos extends Component
{
   public $produtos, $nome, $descricao, $produtos_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->produtos = Produto::all();
        return view('livewire.produtos');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->nome = '';
        $this->produtos = '';
        $this->produtos_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
            $this->produtos_id ? 'Blog Updated Successfully.' : 'Blog Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $produtos = Produto::findOrFail($id);
        $this->produtos_id = $id;
        $this->nome = $produtos->nome;
        $this->descricao = $produtos->descricao;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Produto::find($id)->delete();
        session()->flash('message', 'Blog Deleted Successfully.');
    }
}
