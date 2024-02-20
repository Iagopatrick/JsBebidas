<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Marca;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $produto;
    private $marcas;

    public function __construct(Produto $produto, Marca $marca){
        $this->marcas = $marca;
        $this->produto = $produto;
    }

    public function index()
    {
        return response()->json($this->produto->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        $data = $request->all();
        if($data['nome'])
        $produto = $this->produto->create($data);

        return response()->json($produto);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produto = $this->produto->find($id);
        return response()->json($produto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, $id)
    {
        $produto = $this->produto->find($id);
        if($produto == NULL){
            return response()->json(['msg' => 'Erro, esse produto não existe e não pode ser atualizado.']);
        }
        
        $produto->update($request->all());
        return response()->json($produto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);
        if($produto == NULL){
            return response()->json(['erro' => 'Produto não encontrado']);
        }
        $produto->delete();
        return response()->json(['msg' => 'Produto apagado']);
    }
}
