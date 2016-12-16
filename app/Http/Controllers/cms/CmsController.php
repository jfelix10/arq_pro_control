<?php

namespace App\Http\Controllers\cms;

use Request;

use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Models
use App\models\SistemaModel;
use App\models\SistemaPermissaoModel;
use App\models\UsuarioModel;

class CmsController extends Controller
{
	public function login()
    {
        // action do login
        $actionLogin = 'cms/home';
        // titulo do login
        $loginTitle = 'CMS';

        $alertMessage = '';

        $alertType = '';

        // Capturando valores vindo da controller cms caso exista este redirecionamento
        if(!empty(Request::all()))
        {
            // action do form
            $actionLogin = Request::all()['actionLogin'];
            // titulo do login
            $loginTitle = Request::all()['loginTitle'];

            // action do form
            $alertMessage = Request::all()['alertMessage'] ? Request::all()['alertMessage'] : '';
            // titulo do login
            $alertType = Request::all()['alertType'] ? Request::all()['alertType'] : '';
        }

        return redirect()->action('LoginController@loginHome', ['actionLogin' => $actionLogin
                                                             , 'loginTitle' => $loginTitle
                                                             , 'alertMessage' => $alertMessage
                                                             , 'alertType' => $alertType]);
    }

    public function home()
    {
        // estancia de objeto da tabela sistema
        $oSistemaModel = new SistemaModel;

        // recupera o array de sistemas e ids
        $aSistemas = $oSistemaModel->getSistemas();

        // array de sistemas tendo id como chave e nome como valor
        $aSiemasChaveValor = [];

        foreach ($aSistemas as $key => $value) 
        {
            $aSiemasChaveValor[$value['id_sistema']] = $value['nome_sistema'];
        }

        // para retornar à view
        $actionLogin = 'postAddUsuario';

        $alertMessage = '';
        $alertType = '';

        if(isset(Request::all()['alertMessage']))
        {
            // mensagem
            $alertMessage = Request::all()['alertMessage'] ? Request::all()['alertMessage'] : '';
            // tipo do alert
            $alertType = Request::all()['alertType'] ? Request::all()['alertType'] : '';
        }


        return view('cms/add_usuario', ['actionLogin' => $actionLogin
                                     , 'aSiemasChaveValor' => $aSiemasChaveValor
                                     , 'alertMessage' => $alertMessage
                                     , 'alertType' => $alertType
                                     ]);
    }

    public function postAddUsuario()
    {
        // array de valores para inserir novo usuário
        $aDadosUsuario = [];
        $aDadosUsuario['nome_usuario'] = Request::all()['nome_usuario'];
        $aDadosUsuario['email_usuario'] = Request::all()['email_usuario'];

        // armazenando apenas o array de sistemas
        $aSistemasAttr = Request::all()['arr_sistemas'];

        // estancia de objeto da tabela sistema
        $oUsuarioModel = new UsuarioModel;

        // recupera o ultimo id inserido
        $iUltimoId = $oUsuarioModel->insertUsuario($aDadosUsuario);

        // estancia de objeto da tabela sistema
        $oSistemaPermissaoModel = new SistemaPermissaoModel;

        // insere as permissões no novo usuário inserido pelo seu id resgatado
        $bRetornoInsert = $oSistemaPermissaoModel->insertPermissoesSistemas($iUltimoId, $aSistemasAttr);

        // estancia de objeto da tabela sistema
        $oSistemaModel = new SistemaModel;

        // recupera o array de sistemas e ids
        $aSistemas = $oSistemaModel->getSistemas();

        // array de sistemas tendo id como chave e nome como valor
        $aSiemasChaveValor = [];

        foreach ($aSistemas as $key => $value) 
        {
            $aSiemasChaveValor[$value['id_sistema']] = $value['nome_sistema'];
        }

        // para retornar à view
        $actionLogin = 'postAddUsuario';

        $alertMessage = 'Usuário inserido com sucesso!';
        $alertType = 'success';
        
        return view('cms/add_usuario', ['actionLogin' => $actionLogin
                                     , 'alertMessage' => $alertMessage
                                     , 'alertType' => $alertType
                                     , 'aSiemasChaveValor' => $aSiemasChaveValor]);
    }

    public function postComboUsuario()
    {
        // estancia de objeto da tabela sistema
        $oUsuarioModel = new UsuarioModel;

        // recuperando os usuários
        $aUsuarios = $oUsuarioModel->getUsuarios();

        // array de retorno com array correto
        $aUsuariosIdNome = [];

        foreach ($aUsuarios as $chave => $usuarios) 
        {
            $aUsuariosIdNome[$usuarios['id_usuario']] = $usuarios['nome_usuario'];
        }

        return $aUsuariosIdNome;
    }

    public function postAlterUsuario()
    {
        // estancia de objeto da tabela sistema
        $oUsuarioModel = new UsuarioModel;

        // entrando em rotina de alteração de dados
        if (isset(Request::all()['actMudarResetar']) && Request::all()['actMudarResetar'] == 'alter') 
        {
            
            // estancia de objeto da tabela sistema
            $oSistemaPermissaoModel = new SistemaPermissaoModel;

            // altera as permissões no novo usuário inserido pelo seu id resgatado
            $oSistemaPermissaoModel->updatePermissoesSistemas(Request::all()['iUsuarioAlter'], Request::all()['arr_sistemas']);

            // altera os dados do usuario
            $oUsuarioModel->updateUsuario(Request::all());

            // mensagem de sucesso
            $alertMessage = 'usuário alterado com sucesso!';
            $alertType = 'success';

            return Redirect::route('cmsHome', ['alertMessage' => $alertMessage, 'alertType' => $alertType]);
        }
        else if (isset(Request::all()['actMudarResetar']) && Request::all()['actMudarResetar'] == 'resetSenha') 
        {
            // echo "aquiyy"; die;
            // altera os dados do usuario
            $oUsuarioModel->updateUsuario(Request::all());
            
            // mensagem de sucesso
            $alertMessage = 'senha deletada com sucesso!';
            $alertType = 'success';

            return Redirect::route('cmsHome', ['alertMessage' => $alertMessage, 'alertType' => $alertType]);
        }

        // estancia de objeto da tabela sistema
        $oSistemaModel = new SistemaModel;

        // recupera o array de sistemas e ids
        $aSistemas = $oSistemaModel->getSistemas();

        // array de sistemas tendo id como chave e nome como valor
        $aSiemasChaveValor = [];

        foreach ($aSistemas as $key => $value) 
        {
            $aSiemasChaveValor[$value['id_sistema']] = $value['nome_sistema'];
        }

        // recupera o ultimo id inserido
        $aDadosUsuario = $oUsuarioModel->getDadosPermissaoId(Request::all()['val']);

        // array para popular dados dos usuários por ajax
        $aFillDadosUsuario = [];
        $aFillDadosUsuario['usuario'] = $aDadosUsuario[0]["nome_usuario"];
        $aFillDadosUsuario['email'] = $aDadosUsuario[0]["email"];
        $aFillDadosUsuario['status_usuario'] = $aDadosUsuario[0]["status_usuario"];
        $aFillDadosUsuario['sistema'] = [];
        
        // formando array com sistemas nas chaves e nivel de permissão nos valores
        foreach ($aDadosUsuario as $key => $value) 
        {
            $aFillDadosUsuario['sistema'][$value['id_sistema']] = $value['nivel_permissao'];
        }

        // array que recupera checkboxes no estado do usuário atual
        $aUsuarioSistemasPermissao = [];

        // compondo array de checkboxes com intens existentes e autorizados já checados
        foreach ($aSiemasChaveValor as $key => $value) 
        {
            if (isset($aFillDadosUsuario['sistema'][$key]) && $aFillDadosUsuario['sistema'][$key] > 0) 
            {
                $aUsuarioSistemasPermissao[$key] = $value. "||check";
            }
            else
            {
                $aUsuarioSistemasPermissao[$key] = $value. "||no-check";
            }
        }
        
        // populando array de sistemas com conteudo tratado para success do ajax
        $aFillDadosUsuario['sistema'] = $aUsuarioSistemasPermissao;

        return json_encode($aFillDadosUsuario);
    }
}
