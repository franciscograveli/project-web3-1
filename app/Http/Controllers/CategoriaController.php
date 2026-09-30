<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriaController extends Controller
{
    public function __construct(
        private CategoriaService $categoriaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        return CategoriaResource::collection($this->categoriaService->list($this->perPage($request)));
    }

    public function store(StoreCategoriaRequest $request): CategoriaResource
    {
        return new CategoriaResource(
            $this->categoriaService->create($request->validated())
        );
    }

    public function show(Categoria $categoria): CategoriaResource
    {
        return new CategoriaResource($this->categoriaService->show($categoria));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): CategoriaResource
    {
        return new CategoriaResource(
            $this->categoriaService->update($request->validated(), $categoria)
        );
    }

    public function destroy(Categoria $categoria): JsonResponse
    {
        $this->categoriaService->delete($categoria);

        return response()->json([
            'message' => 'Categoria deletada com sucesso',
        ]);
    }
}
