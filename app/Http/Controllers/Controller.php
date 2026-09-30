<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    private const PER_PAGE_PADRAO = 15;

    private const PER_PAGE_MAXIMO = 100;

    /**
     * Itens por página vindos de ?per_page=, limitados entre 1 e o máximo.
     */
    protected function perPage(Request $request): int
    {
        $perPage = $request->integer('per_page', self::PER_PAGE_PADRAO);

        return max(1, min($perPage, self::PER_PAGE_MAXIMO));
    }
}
