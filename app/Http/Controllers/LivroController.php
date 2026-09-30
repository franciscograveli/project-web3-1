<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLivroRequest;
use App\Http\Requests\UpdateLivroRequest;
use App\Http\Resources\LivroResource;
use App\Models\Livro;
use App\Services\LivroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LivroController extends Controller
{
    public function __construct(
        private LivroService $livroService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        return LivroResource::collection($this->livroService->list($this->perPage($request)));
    }

    public function store(StoreLivroRequest $request): LivroResource
    {
        return new LivroResource(
            $this->livroService->create($request->validated())
        );
    }

    public function show(Livro $livro): LivroResource
    {
        return new LivroResource($this->livroService->show($livro));
    }

    public function update(UpdateLivroRequest $request, Livro $livro): LivroResource
    {
        return new LivroResource(
            $this->livroService->update($request->validated(), $livro)
        );
    }

    public function destroy(Livro $livro): JsonResponse
    {
        $this->livroService->delete($livro);

        return response()->json([
            'message' => 'Livro deletado com sucesso',
        ]);
    }
}
