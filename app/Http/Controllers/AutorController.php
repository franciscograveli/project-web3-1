<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAutorRequest;
use App\Http\Requests\UpdateAutorRequest;
use App\Http\Resources\AutorResource;
use App\Models\Autor;
use App\Services\AutorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AutorController extends Controller
{
    public function __construct(
        private AutorService $autorService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        return AutorResource::collection($this->autorService->list($this->perPage($request)));
    }

    public function store(StoreAutorRequest $request): AutorResource
    {
        return new AutorResource(
            $this->autorService->create($request->validated())
        );
    }

    public function show(Autor $autor): AutorResource
    {
        return new AutorResource($this->autorService->show($autor));
    }

    public function update(UpdateAutorRequest $request, Autor $autor): AutorResource
    {
        return new AutorResource(
            $this->autorService->update($request->validated(), $autor)
        );
    }

    public function destroy(Autor $autor): JsonResponse
    {
        $this->autorService->delete($autor);

        return response()->json([
            'message' => 'Autor deletado com sucesso',
        ]);
    }
}
