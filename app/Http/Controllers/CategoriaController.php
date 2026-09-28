<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use App\Services\CategoriaService;
class CategoriaController extends Controller
{
    public function __construct(
        private CategoriaService $categoriaService
    ) {}


    public function index()
    {
        return $this->categoriaService->list();
    }

    public function store(StoreCategoriaRequest $request)
    {
        return $this->categoriaService->create(
            $request->validated()
        );
    }

    public function show(Categoria $categoria)
    {
        return $categoria;
    }

    public function update(
        UpdateCategoriaRequest $request,
        Categoria $categoria
    ) {
        return $this->categoriaService->update(
            $request->validated(),
            $categoria
        );
    }

    public function destroy(Categoria $categoria)
    {
        $this->categoriaService->delete($categoria);

        return response()->json([
            'message' => 'Categoria deletada com sucesso'
        ]);
    }
}
