<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Request;

use Redirect;

// Models
use App\models\UsuarioModel;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    
    public function handle($request, Closure $next, $guard = null)
    {
        // pegando url pós 'public'
        $sPathInfo = Request::getPathInfo();

        // estancia da tabela usuario
        $oUsuarioModel = new UsuarioModel;

        // boolean de permissão para acessar sistema
        $bAccess = false;

        /**
         * Verificando url solicitada para fazer as validações necessárias.
         * Se não for solicitação de login ('/') ou login cms ('cms/login')
         * verifica se já tem sessão e se não verifia se é uma tentativa de login
         * ou encaminha para login adequado
         */
        // if ($sPathInfo === '/cms/home_cms') 
        if (!str_contains($sPathInfo, '/') || !str_contains($sPathInfo, 'cms/login')) 
        {
            // Primeiro verifica se o usuário já possui sessão
            if ( !is_null(Request::session()->get('usuario')) ) 
            {
                // capturando os dados de usuario de sessão
                $aDadosUsuario = Request::session()->get('usuario');

                // verificando se a requisição foi para cms
                if ($this->checkToRedirectLogin($sPathInfo) == 'cms/login' && $this->getPermissaoCmsSistema($aDadosUsuario['sistema'], $sPathInfo) == true) 
                {
                    // retornando para a controller desejada com sessão já setada
                    return $next($request);
                }
                else if ($this->checkToRedirectLogin($sPathInfo) == '/' && $this->getPermissaoCmsSistema($aDadosUsuario['sistema'], $sPathInfo) == true) 
                {
                    // retornando para a controller desejada com sessão já setada
                    return $next($request);
                }
                else
                {
                    // verifica para qual login redirecionar
                    if ($this->checkToRedirectLogin($sPathInfo) == 'cms/login') 
                    {
                        $loginTitle = 'CMS';
                        $actionLogin = 'cms/home';
                        $alertMessage = 'Você não tem permissão para acessar esta área que tentou';
                        $alertType = 'danger';
                        return Redirect::route('cmsLogin', ['alertMessage' => $alertMessage
                                                         , 'alertType' => $alertType
                                                         , 'loginTitle' => $loginTitle
                                                         , 'actionLogin' => $actionLogin]);
                    }
                    else
                    {
                        $loginTitle = 'sistema';
                        $actionLogin = 'sistema/home';
                        $alertMessage = 'Você não tem permissão para acessar esta área que tentou';
                        $alertType = 'danger';
                        return Redirect::route('login', ['alertMessage' => $alertMessage
                                                      , 'alertType' => $alertType
                                                      , 'loginTitle' => $loginTitle
                                                      , 'actionLogin' => $actionLogin]);
                    }
                }
            }
            else if (str_contains($sPathInfo, '/cadastro/nova_senha')) 
            {
                // Verificando se esta correta a solicitação de cadastro de nova senha
                if (
                    !empty($request->session()->get('dadosNovaSenha')['email']) &&
                    !empty($request->session()->get('dadosNovaSenha')['senha_nova']) &&
                    !isset($request->all()['confirma_senha'])
                   ) 
                {
                    // se for redirecionamento de cadastro de nova senha
                    return $next($request);
                }
                else if (
                    isset($request->all()['email']) &&
                    isset($request->all()['senha_nova']) &&
                    isset($request->all()['confirma_senha']) &&
                    !empty($request->all()['email']) &&
                    !empty($request->all()['senha_nova']) &&
                    !empty($request->all()['confirma_senha'])
                   )
                {

                    // se a senha não foi confirmada corretamente
                    return $next($request);
                }
                else
                {
                    // se faltar dados redireciona para o login inicial
                    return Redirect::route('login');
                }
                    
            }
            else
            {
                // se não esta tentando se logar
                if (empty($request->all()))
                {
                    // verificando qual url o usuário tentor entrar sem se logar
                    $sToRedirect = $this->checkToRedirectLogin($sPathInfo);

                    // Redirecionando para o login coerente
                    return redirect($sToRedirect);
                }

                // se não tiver sessão setada faz a busca com os dados do formulário
                $aUsuarioModel = $oUsuarioModel->getDadosPermissao($request->lg_username, $request->lg_password);

                // verificando se o retorno da consulta é null para redirecionar ao login
                if ($aUsuarioModel === null) 
                {
                    // verifica para qual login redirecionar
                    if ($this->checkToRedirectLogin($sPathInfo) == 'cms/login') 
                    {
                        $loginTitle = 'CMS';
                        $actionLogin = 'cms/home';
                        $alertMessage = 'senha ou login errado.';
                        $alertType = 'danger';
                        return Redirect::route('cmsLogin', ['alertMessage' => $alertMessage
                                                         , 'alertType' => $alertType
                                                         , 'loginTitle' => $loginTitle
                                                         , 'actionLogin' => $actionLogin]);
                    }
                    else
                    {
                        $loginTitle = 'sistema';
                        $actionLogin = 'sistema/home';
                        $alertMessage = 'senha ou login errado.';
                        $alertType = 'danger';
                        return Redirect::route('login', ['alertMessage' => $alertMessage
                                                      , 'alertType' => $alertType
                                                      , 'loginTitle' => $loginTitle
                                                      , 'actionLogin' => $actionLogin]);
                    }
                }
                else if ($aUsuarioModel === 'senha') 
                {
                    // array com valores necessários para cadastrar nova senha
                    $adadosNovaSenha = [];
                    $adadosNovaSenha['email'] = $request->all()['lg_username'];
                    $adadosNovaSenha['senha_nova'] = $request->all()['lg_password'];
                    
                    // Setando variavel de sessão com dados para cadastrar nova senha
                    Request::session()->set('dadosNovaSenha', $adadosNovaSenha);
                    Request::session()->save();

                    // redireciona para cadastro de nova senha
                    return redirect('/cadastro/nova_senha');
                }
                else
                {
                    // verifica se tem permissão para acessar o cms
                    $bAccess = $this->getPermissaoCmsSistema($aUsuarioModel['sistema'], $sPathInfo);
                }
            } 
        }
        

        // Se tiver permissão para acessar o cms redireciona pra ele setando a sessão
        if ($bAccess === true) 
        {
            // setando a sessão com a variável usuário contendo dados da query de usuário e acessos
            Request::session()->set('usuario', $aUsuarioModel);
            Request::session()->save();

            // retornando para a controller desejada com sessão já setada
            return $next($request);
        }
        else 
        {
            // verifica para qual login redirecionar
            if ($this->checkToRedirectLogin($sPathInfo) == 'cms/login') 
            {
                $loginTitle = 'CMS';
                $actionLogin = 'cms/home';
                $alertMessage = 'você não tem permissão para esta área do sistema.';
                $alertType = 'danger';
                return Redirect::route('cmsLogin', ['alertMessage' => $alertMessage
                                                 , 'alertType' => $alertType
                                                 , 'loginTitle' => $loginTitle
                                                 , 'actionLogin' => $actionLogin]);
            }
            else
            {
                $loginTitle = 'sistema';
                $actionLogin = 'sistema/home';
                $alertMessage = 'você não tem permissão para esta área do sistema.';
                $alertType = 'danger';
                return Redirect::route('login', ['alertMessage' => $alertMessage
                                              , 'alertType' => $alertType
                                              , 'loginTitle' => $loginTitle
                                              , 'actionLogin' => $actionLogin]);
            }
        }
    }

    // verifica se tem permissão pra acessar o sistema que esta desejando acessar
    public function getPermissaoCmsSistema($array, $url)
    {
        //  variavel de retorno
        $bAccess = false;

        // array de sistemas de acesso
        $aSistemaAcesso = [];
         /*
        * percorrendo array de sistemas cadastrados neste usuário e verificando se tem
        * o CMS liberado array(chave:1 - sitema cms => valor:1 - valor maior que 0 indica liberado)
        */
        foreach ($array as $chave => $sistemas) 
        {
            foreach ($sistemas as $key => $value) 
            {
                if ($key == 1) 
                {
                    if ($value > 0) 
                    {
                        array_push($aSistemaAcesso, 'access_cms');
                    }
                }

                if ($key >= 10) 
                {
                    if ($value > 0) 
                    {
                        array_push($aSistemaAcesso, 'access_sistema');
                    }
                }
            }
        }

        if ($this->checkToRedirectLogin($url) == '/' && in_array('access_sistema', $aSistemaAcesso)) 
        {
            $bAccess = true;
        }
        else if ($this->checkToRedirectLogin($url) == 'cms/login' && in_array('access_cms', $aSistemaAcesso)) 
        {
            $bAccess = true;
        }

        return $bAccess;
    }


    // verifica para onde redirecionar e/ou para qual sistema esta requisitando acesso
    public function checkToRedirectLogin($baseUrl)
    {
        // variavel de retorno
        $sToRedirect = '/';

        if (str_contains($baseUrl, 'sistema')) 
        {
            $sToRedirect = '/';
        }
        else if(str_contains($baseUrl, 'cms'))
        {
            $sToRedirect = 'cms/login';
        }

        return $sToRedirect;
    }
}
