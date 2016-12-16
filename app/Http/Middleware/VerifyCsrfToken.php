<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // rotas que não serão verificadas para token
    	 '/cms/cms_combo_usuario'
        ,'/cms/cms_alter_usuario'
        ,'/sistema/projeto/update'
        ,'/sistema/projeto/check_project'
        ,'/sistema/projeto/etapas'
        ,'/sistema/projeto/areas'
        ,'/sistema/projeto/visualizacao'
    ];
}
