<?php

namespace App\Http\Controllers\cadastro;

use Request;

use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Models
use App\models\UsuarioModel;

class CadastroController extends Controller
{
    public function novaSenha()
    {
        // action login
        $actionLogin = 'novaSenhaPost';

    	// array de valores para encaminhar à view
    	$aDadosNovaSenha = [];
    	$aDadosNovaSenha['email'] = Request::session()->get('dadosNovaSenha')['email'];
    	$aDadosNovaSenha['senha_nova'] = Request::session()->get('dadosNovaSenha')['senha_nova'];


        // setando null para dados de nova senha caso usuario não execute ação neste momento
    	Session::set('dadosNovaSenha', null);
        Session::save();

    	// dd($aDadosNovaSenha);
        return view('cadastro/nova_senha', ['aDadosNovaSenha' => $aDadosNovaSenha, 'actionLogin' => $actionLogin]);
    }

    // exexuta cadastro da nova senha
    public function postNovaSenha()
    {
        // dd(Request::all());
        // estancia da tabela usuario
        $oUsuarioModel = new UsuarioModel;

        // verifica se senha e confirmação são iguais e insere nova senha na tabela
        if (Request::all()['senha_nova'] == Request::all()['confirma_senha']) 
        {
            $bInsertSenha = $oUsuarioModel->insertSenhaUsuario(Request::all()['email'], Request::all()['senha_nova']);
        }

        return redirect('/');
    }
}
