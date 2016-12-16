<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

use DB;

class UsuarioModel extends Model
{
    // Desabilitando updated_at
	public $timestamps = false;
	
    // Set table name on Database
	protected $table = 'usuario';

	// listagem com os dados dos usuários
	public function getUsuarios()
	{
		// variavel de retorno
		$aRetorno = [];
		$aRetorno = $this->get()->toArray();
		
		return $aRetorno;
	}

	// pega os dados de permissão para compor a session do usuário
	public function getDadosPermissao($email, $senha)
	{
		// Variavel de retorno
		$retorno = null;

		// Variavel que armzena result set
		$oResultSet = '';

		$oResultSet = $this->leftJoin('sistema_permissao', 'usuario.id_usuario' , '=', 'sistema_permissao.id_usuario')
						   ->where('email', $email)
						   ->where('senha', $senha)
						   ->get()->toArray();

		if (empty($oResultSet)) 
		{
			$retorno = null;

			$oResultSet = $this->leftJoin('sistema_permissao', 'usuario.id_usuario' , '=', 'sistema_permissao.id_usuario')
						   	   ->where('email', $email)
						   	   ->whereNull('senha')
						   	   ->get()->toArray();

			if (empty($oResultSet)) 
			{
				$retorno = null;
			}
			elseif ($oResultSet[0]['status_usuario'] <= 0) 
			{
				$retorno = null;
			}
			else
			{
				$retorno = 'senha';
			}
		}
		elseif ($oResultSet[0]['status_usuario'] <= 0) 
		{
			$retorno = null;
		}
		else
		{
			// array para popular session
			$aFillSession = [];
			$aFillSession['id_usuario'] = $oResultSet[0]["id_usuario"];
		    $aFillSession['usuario'] = $oResultSet[0]["nome_usuario"];
		    $aFillSession['email'] = $oResultSet[0]["email"];
		    $aFillSession['sistema'] = [];

		    // formando array com sistemas nas chaves e nivel de permissão nos valores
		    foreach ($oResultSet as $key => $value) 
		    {
		    	array_push($aFillSession['sistema'], array($value['id_sistema'] => $value['nivel_permissao']));
		    }
			
			$retorno = $aFillSession;
		}

        return $retorno;
	}

	// inserindo usuário novo sem senha.
	public function insertUsuario($aDadosUsuario)
	{
		// Variavel que retorna ultimo Id inserido
		$iId;
		
		$iId = $this
		->insertGetId(['nome_usuario'=> $aDadosUsuario['nome_usuario'], 'email'=> $aDadosUsuario['email_usuario']]);

        return $iId;
	}

	// inserindo nova senha ou resetando.
	public function insertSenhaUsuario($email, $senha)
	{
		$this
		->where('email', $email)
        ->update(['senha' => $senha]);

        return true;
	}

	// traz os dados do usuário buscando pelo id
	public function getDadosPermissaoId($id_usuario)
	{
		// Variavel de retorno
		$retorno = null;

		// Variavel que armzena result set
		$oResultSet = '';

		$oResultSet = $this->leftJoin('sistema_permissao', 'usuario.id_usuario' , '=', 'sistema_permissao.id_usuario')
						   ->where('usuario.id_usuario', $id_usuario)
						   ->get()->toArray();

		
		
		$retorno = $oResultSet;

        return $retorno;
	}

	// update no usuário
	public function updateUsuario($aDadosUsuario)
	{
		// Variavel de retorno
		$retorno = null;
		// echo "modell";
		// dd($aDadosUsuario);
		if (isset($aDadosUsuario['actMudarResetar']) && $aDadosUsuario['actMudarResetar'] == 'resetSenha' ) 
		{
			$this->where('id_usuario', $aDadosUsuario['iUsuarioAlter'])
				 ->update(['senha' => null]);

			// DB::update('UPDATE usuario SET senha = NULL WHERE id_usuario = ?', array($aDadosUsuario['iUsuarioAlter']));
		}
		else
		{
			$this
			->where('id_usuario', $aDadosUsuario['iUsuarioAlter'])
	        ->update([
	        	'nome_usuario' => $aDadosUsuario['nome_usuario']
	        	, 'email' => $aDadosUsuario['email_usuario']
	        	, 'status_usuario' => $aDadosUsuario['iUsuarioStatus']
	        	]);
		}

		$retorno = true;

        return $retorno;
	}

}
