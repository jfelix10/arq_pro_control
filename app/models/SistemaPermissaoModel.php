<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\models\SistemaModel;

class SistemaPermissaoModel extends Model
{
    // Desabilitando updated_at
	public $timestamps = false;
	
    // Set table name on Database
	protected $table = 'sistema_permissao';

	public function insertPermissoesSistemas($iIdUsuario, $aSistemasCheck)
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

        // Variavel de retorno
		$bRetorno = false;

		// laço que verifica se existe ou nao o sistema checado e o insere na tabela com id do usuario
		foreach ($aSiemasChaveValor as $key => $value) 
        {
        	// variavel com nome do sistema
			$sSistema = '';
			switch ($key) 
			{
				case 1:
					$sSistema = 'cms';
				break;

				case 2:
					$sSistema = 'financeiro';
				break;

				case 10:
					$sSistema = 'novo projeto';
				break;

				case 11:
					$sSistema = 'áreas projeto';
				break;

				case 12:
					$sSistema = 'etapas projeto';
				break;
				
				default:
					$sSistema = 'verificar id deste sistema';
				break;
			}

            if (isset($aSistemasCheck[$key]) && $aSistemasCheck[$key] == 'on') 
            {
                // inserindo permissão para sistemas para cada sistema que o usuário foi marcado
				$this->insert(['id_sistema'=> $key
							  , 'nome_sistema'=> $sSistema
							  , 'id_usuario'=> $iIdUsuario
							  , 'nivel_permissao'=> 1
							  ]);

				// retorna true se inseriu corretamente
				$bRetorno = true;
            }
            else
            {
                // inserindo permissão para sistemas para cada sistema que o usuário foi marcado
				$this->insert(['id_sistema'=> $key
							  , 'nome_sistema'=> $sSistema
							  , 'id_usuario'=> $iIdUsuario
							  , 'nivel_permissao'=> 0
							  ]);

				// retorna true se inseriu corretamente
				$bRetorno = true;
            }

			// retorna true se inseriu corretamente
			$bRetorno = true;
        }
		
		return $bRetorno;
	}

	public function updatePermissoesSistemas($iIdUsuario, $aSistemasCheck)
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

        // Variavel de retorno
		$bRetorno = false;

		// laço que verifica se existe ou nao o sistema checado e o insere na tabela com id do usuario
		foreach ($aSiemasChaveValor as $key => $value) 
        {
            if (isset($aSistemasCheck[$key]) && $aSistemasCheck[$key] == 'on') 
            {
                // inserindo permissão para sistemas para cada sistema que o usuário foi marcado
				$this->where('id_sistema', $key)
					 ->where('id_usuario', $iIdUsuario)
					 ->update(['nivel_permissao'=> 1]);

				// retorna true se inseriu corretamente
				$bRetorno = true;
            }
            else
            {
                // inserindo permissão para sistemas para cada sistema que o usuário foi marcado
				$this->where('id_sistema', $key)
					 ->where('id_usuario', $iIdUsuario)
					 ->update(['nivel_permissao'=> 0]);
				// retorna true se inseriu corretamente
				$bRetorno = true;

            }

			// retorna true se inseriu corretamente
			$bRetorno = true;
        }
		
		return $bRetorno;
	}
}
