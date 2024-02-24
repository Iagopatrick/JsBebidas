<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $marcas;

    public function __construct(Marca $marca){
        $this->marcas = $marca;
    }

    public function index()
    {
        return $this->marcas->all();
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
    public function store(StoreMarcaRequest $request)
    {
        
        $imagem = $request->file('logo');
        $imagem_urn = $imagem->store('imagens/marcas', 'public');

        $marca = Marca::create([
            'nome' => $request->nome,
            'logo' => $imagem_urn
        ]);
        return $marca;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marcas->find($id);
        return response()->json($marca);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, $id)
    {
        $marca = $this->marcas->find($id);
        
        if($request->file('logo')){
            Storage::disk('public')->delete($marca->logo);

        }
        $imagem = $request->file('logo');
        $imagem_urn = $imagem->store('imagens/marcas', 'public');
        $marca->fill($request->all());
        $marca->logo = $imagem_urn;

        $marca->save();

        return response()->json($marca);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
        $marca = $this->marcas->find($id);
        if($marca == NULL){
            return response()->json(['msg'=> 'Erro, essa marca não existe!']);
        }
        
        Storage::disk('public')->delete($marca->logo);
        $marca->delete();
        return ['msg' => 'A marca foi removida com suscesso!'];
    }
}
