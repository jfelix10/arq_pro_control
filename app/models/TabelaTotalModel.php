<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class TabelaTotalModel extends Model
{
    // Desabilitando updated_at
	public $timestamps = false;
	
    // Set table name on Database
	protected $table = 'tabela_total';

	protected $dateFormat = 'd/m/Y';


	public function getGridLojas($aRequestGross)
	{
		// Variavel de retorno
		$retorno;

		// tratando array request
		$aRequest = isset($aRequestGross["aRequestRet"]) ? $aRequestGross["aRequestRet"] : $aRequestGross;
		
		// iniciando objeto para que possa se compor com os IF's
		$retorno = $this->select();

		if(isset($aRequest["bandeira"]) && is_array($aRequest["bandeira"]))
		{
			$retorno->whereIn('bandeira', $aRequest["bandeira"]);
		}

		if(!empty($aRequest["apelido"]))
		{
			$retorno->where('apelido', 'like', '%' . $aRequest["apelido"] . '%');
		}

		if(!empty($aRequest["nome"]))
		{
			$retorno->where('nome', 'like', '%' . $aRequest["nome"] . '%');
		}

		if(!empty($aRequest["codigo_loja"]))
		{
			if (strpos($aRequest["codigo_loja"], ',')) 
			{
				$aCodLojas = explode(',', $aRequest["codigo_loja"]);
				$retorno->whereIn('codigo_loja', $aCodLojas);
			}
			else
			{
				$retorno->where('codigo_loja', $aRequest["codigo_loja"]);
			}
		}

		if(isset($aRequest["uf_projeto"]) && is_array($aRequest["uf_projeto"]))
		{
			$retorno->whereIn('uf_projeto', $aRequest["uf_projeto"]);
		}

		if(!empty($aRequest["municipio"]))
		{
			$retorno->where('municipio', 'like', '%' . $aRequest["municipio"] . '%');
		}

		if(isset($aRequest["categoria"]) && is_array($aRequest["categoria"]))
		{
			$retorno->whereIn('categoria', $aRequest["categoria"]);
		}

		if(isset($aRequest["arquit"]) && is_array($aRequest["arquit"]))
		{
			$retorno->whereIn('arquit', $aRequest["arquit"]);
		}

		if(isset($aRequest["ativo_inativo"]) && is_array($aRequest["ativo_inativo"]))
		{
			$retorno->whereIn('ativo_inativo', $aRequest["ativo_inativo"]);
		}

		if(!empty($aRequest["dt_inaug_ini"]) && !empty($aRequest["dt_inaug_fim"]))
		{
			$retorno->whereBetween('dt_inauguracao', array($aRequest["dt_inaug_ini"], $aRequest["dt_inaug_fim"]));
		}

		if (!empty($aRequest["dt_inaug_ini"]) && empty($aRequest["dt_inaug_fim"])) 
		{
			$retorno->where('dt_inauguracao', $aRequest["dt_inaug_ini"]);
		}

		if (empty($aRequest["dt_inaug_ini"]) && !empty($aRequest["dt_inaug_fim"])) 
		{
			$retorno->where('dt_inauguracao', $aRequest["dt_inaug_fim"]);
		}

		if(!empty($aRequest["n_rev_ep"]))
		{
			$retorno->where('n_rev_ep', '>=' ,$aRequest["n_rev_ep"]);
		}

		if(!empty($aRequest["n_rev_ev"]))
		{
			$retorno->where('n_rev_ev', '>=' ,$aRequest["n_rev_ev"]);
		}

		if(!empty($aRequest["n_rev_pl"]))
		{
			$retorno->where('n_rev_pl', '>=' ,$aRequest["n_rev_pl"]);
		}

		if(!empty($aRequest["n_rev_exec"]))
		{
			$retorno->where('n_rev_exec', '>=' ,$aRequest["n_rev_exec"]);
		}

		if(!empty($aRequest["etapa"]))
		{
			$retorno->where('etapa', $aRequest["etapa"]);
		}

		if(isset($aRequest["tipo_obra"]) && is_array($aRequest["tipo_obra"]))
		{
			$retorno->whereIn('tipo_obra', $aRequest["tipo_obra"]);
		}

		if(!empty($aRequest["aplicacao"]))
		if(isset($aRequest["aplicacao"]) && is_array($aRequest["aplicacao"]))
		{
			$retorno->whereIn('aplicacao', $aRequest["aplicacao"]);
		}

		if(!empty($aRequest["parceiro_locacao"]))
		{
			$retorno->where('parceiro_locacao', $aRequest["parceiro_locacao"]);
		}

		if(!empty($aRequest["celula"]))
		{
			$retorno->where('celula', 'like', '%' . $aRequest["celula"] . '%');
		}


        return $retorno->orderBy('id', 'desc')->paginate(15);
	}

	public function getGridFullExpt($aRequestGross)
	{
		// Variavel de retorno
		$retorno;

		// tratando array request
		$aRequest = isset($aRequestGross["aRequestRet"]) ? $aRequestGross["aRequestRet"] : $aRequestGross;
		
		// iniciando objeto para que possa se compor com os IF's
		$retorno = $this->select();

		if(!empty($aRequest["id"]))
		{
			$retorno->where('id', $aRequest["id"]);
		}

		if(isset($aRequest["bandeira"]) && is_array($aRequest["bandeira"]))
		{
			$retorno->whereIn('bandeira', $aRequest["bandeira"]);
		}

		if(!empty($aRequest["apelido"]))
		{
			$retorno->where('apelido', 'like', '%' . $aRequest["apelido"] . '%');
		}

		if(!empty($aRequest["nome"]))
		{
			$retorno->where('nome', 'like', '%' . $aRequest["nome"] . '%');
		}

		if(!empty($aRequest["codigo_loja"]))
		{
			if (strpos($aRequest["codigo_loja"], ',')) 
			{
				$aCodLojas = explode(',', $aRequest["codigo_loja"]);
				$retorno->whereIn('codigo_loja', $aCodLojas);
			}
			else
			{
				$retorno->where('codigo_loja', $aRequest["codigo_loja"]);
			}
		}

		if(isset($aRequest["uf_projeto"]) && is_array($aRequest["uf_projeto"]))
		{
			$retorno->whereIn('uf_projeto', $aRequest["uf_projeto"]);
		}

		if(!empty($aRequest["municipio"]))
		{
			$retorno->where('municipio', 'like', '%' . $aRequest["municipio"] . '%');
		}

		if(isset($aRequest["categoria"]) && is_array($aRequest["categoria"]))
		{
			$retorno->whereIn('categoria', $aRequest["categoria"]);
		}

		if(isset($aRequest["arquit"]) && is_array($aRequest["arquit"]))
		{
			$retorno->whereIn('arquit', $aRequest["arquit"]);
		}

		if(isset($aRequest["ativo_inativo"]) && is_array($aRequest["ativo_inativo"]))
		{
			$retorno->whereIn('ativo_inativo', $aRequest["ativo_inativo"]);
		}

		if(!empty($aRequest["dt_inaug_ini"]) && !empty($aRequest["dt_inaug_fim"]))
		{
			$retorno->whereBetween('dt_inauguracao', array($aRequest["dt_inaug_ini"], $aRequest["dt_inaug_fim"]));
		}

		if (!empty($aRequest["dt_inaug_ini"]) && empty($aRequest["dt_inaug_fim"])) 
		{
			$retorno->where('dt_inauguracao', $aRequest["dt_inaug_ini"]);
		}

		if (empty($aRequest["dt_inaug_ini"]) && !empty($aRequest["dt_inaug_fim"])) 
		{
			$retorno->where('dt_inauguracao', $aRequest["dt_inaug_fim"]);
		}

		if(!empty($aRequest["n_rev_ep"]))
		{
			$retorno->where('n_rev_ep', '>=' ,$aRequest["n_rev_ep"]);
		}

		if(!empty($aRequest["n_rev_ev"]))
		{
			$retorno->where('n_rev_ev', '>=' ,$aRequest["n_rev_ev"]);
		}

		if(!empty($aRequest["n_rev_pl"]))
		{
			$retorno->where('n_rev_pl', '>=' ,$aRequest["n_rev_pl"]);
		}

		if(!empty($aRequest["n_rev_exec"]))
		{
			$retorno->where('n_rev_exec', '>=' ,$aRequest["n_rev_exec"]);
		}

		if(!empty($aRequest["etapa"]))
		{
			$retorno->where('etapa', $aRequest["etapa"]);
		}

		if(isset($aRequest["tipo_obra"]) && is_array($aRequest["tipo_obra"]))
		{
			$retorno->whereIn('tipo_obra', $aRequest["tipo_obra"]);
		}

		if(!empty($aRequest["aplicacao"]))
		if(isset($aRequest["aplicacao"]) && is_array($aRequest["aplicacao"]))
		{
			$retorno->whereIn('aplicacao', $aRequest["aplicacao"]);
		}

		if(!empty($aRequest["parceiro_locacao"]))
		{
			$retorno->where('parceiro_locacao', $aRequest["parceiro_locacao"]);
		}

		if(!empty($aRequest["celula"]))
		{
			$retorno->where('celula', 'like', '%' . $aRequest["celula"] . '%');
		}

        return $retorno->get();
	}

	public function novaLoja($aRequest)
	{
		// variável de retorno
		$bInsert = null;

		$this->apelido = !empty($aRequest["apelido_projeto"]) ? $aRequest["apelido_projeto"] : null;
		$this->nome = !empty($aRequest["nome_projeto"]) ? $aRequest["nome_projeto"] : null;
		$this->codigo_loja = !empty($aRequest["codigo_projeto_manual"]) ? $aRequest["codigo_projeto_manual"] : null;
		$this->bandeira = !empty($aRequest["bandeira"]) ? $aRequest["bandeira"] : null;
		$this->uf_projeto = !empty($aRequest["estado_projeto"]) ? $aRequest["estado_projeto"] : null;
		$this->municipio = !empty($aRequest["municipio_projeto"]) ? $aRequest["municipio_projeto"] : null;
		$this->arquit = !empty($aRequest["perfil_arq"]) ? $aRequest["perfil_arq"] : null;
		$this->categoria = !empty($aRequest["categorias_projeto"]) ? $aRequest["categorias_projeto"] : null;
		$this->dt_inauguracao = !empty($aRequest["data_inaugurcao"]) ? $aRequest["data_inaugurcao"] : null;
		$this->ativo_inativo = ($aRequest["ativo_inativo"] == 0) || ($aRequest["ativo_inativo"] == 1)? $aRequest["ativo_inativo"] : null;
		try
		{
			$this->save();
			$bInsert = true;
		}
		catch(Exception $e)
		{
			$bInsert = null;
			throw $e->message();
		}

		return $bInsert;
	}

	public function updateProjeto($aRequest)
	{
		// variável de retorno
		$bInsert = null;

		// try do update
		try
		{
			$this
			->where('id', $aRequest['projetos'])
			->update(['apelido' => !empty($aRequest["apelido_projeto"]) ? $aRequest["apelido_projeto"] : null
					, 'nome' => !empty($aRequest["nome_projeto"]) ? $aRequest["nome_projeto"] : null
					, 'codigo_loja' => !empty($aRequest["codigo_projeto_manual"]) ? $aRequest["codigo_projeto_manual"] : null
					, 'bandeira' => !empty($aRequest["bandeira"]) ? $aRequest["bandeira"] : null
					, 'uf_projeto' => !empty($aRequest["estado_projeto"]) ? $aRequest["estado_projeto"] : null
					, 'municipio' => !empty($aRequest["municipio_projeto"]) ? $aRequest["municipio_projeto"] : null
					, 'arquit' => !empty($aRequest["perfil_arq"]) ? $aRequest["perfil_arq"] : null
					, 'categoria' => !empty($aRequest["categorias_projeto"]) ? $aRequest["categorias_projeto"] : null
					, 'dt_inauguracao' => !empty($aRequest["data_inaugurcao"]) ? $aRequest["data_inaugurcao"] : null
					, 'ativo_inativo' => ($aRequest["ativo_inativo"] == 0) || ($aRequest["ativo_inativo"] == 1)? $aRequest["ativo_inativo"] : null]);

			$bInsert = true;
		}
		catch(Exception $e)
		{
			$bInsert = null;
			throw $e->message();
		}

		return $bInsert;
	}

	// array de projetos para telas de tratamento de etapas e infos do projeto
	public function projetos()
	{
		// Variavel que recebe array da consulta
		$aResultSet;

		// array de retorno
		$aRetono = [];
	
		$oData = $this->select('id', 'uf_projeto', 'municipio','apelido', 'nome')->where('ativo_inativo', 1);

		$aResultSet = $oData->get()->toArray();
		
		// icrementando o array de retorno
		$aRetono[0] = 'escolha um projeto';
		foreach ($aResultSet as $key => $value) 
        {
            $aRetono[$value['id']] = $value['uf_projeto'].' | '.$value['municipio'].' | '.$value['apelido'].' | '.$value['nome'];
        }


        return $aRetono;
	}

	// Todos os projetos ativos, inativos e sem status
	public function projetosTodos()
	{
		// Variavel que recebe array da consulta
		$aResultSet;

		// array de retorno
		$aRetono = [];
	
		$oData = $this->select('id', 'uf_projeto', 'municipio','apelido', 'nome');

		$aResultSet = $oData->get()->toArray();
		
		// icrementando o array de retorno
		$aRetono[0] = 'escolha um projeto';
		foreach ($aResultSet as $key => $value) 
        {
            $aRetono[$value['id']] = $value['uf_projeto'].' | '.$value['municipio'].' | '.$value['apelido'].' | '.$value['nome'];
        }


        return $aRetono;
	}

	public function projetosDados($id)
	{
		// Variavel de retorno
		$retorno;

		$oData = $this->where('id', $id);

		$retorno = $oData->get()->toArray();

        return $retorno;
	}

	public function medidasLoja($aRequest)
	{
		// variável de retorno
		$bUpdated = null;

		try
		{
			$this->where('id', $aRequest['projetos'])
				 ->update([
				 		'estoque' => !empty($aRequest["estoque"]) ? (float) str_replace(',', '.', $aRequest["estoque"]) : null
				 		, 'ar_vendas' => !empty($aRequest["ar_vendas"]) ? (float) str_replace(',', '.', $aRequest["ar_vendas"]) : null
				 		, 'aplicacao' => !empty($aRequest["aplicacao"]) ? $aRequest["aplicacao"] : null
				 		, 'num_vagas' => $aRequest["num_vagas"] === "" ? null : $aRequest["num_vagas"]
				 		,'ar_cst_venda' => !empty($aRequest["ar_cst_venda"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_venda"]) : null
						, 'ar_cst_apoio_terreo' => !empty($aRequest["ar_cst_apoio_terreo"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_apoio_terreo"]) : null
						, 'ar_cst_apoio_meza' => !empty($aRequest["ar_cst_apoio_meza"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_apoio_meza"]) : null
						, 'ar_estac_coberto' => !empty($aRequest["ar_estac_coberto"]) ? (float) str_replace(',', '.', $aRequest["ar_estac_coberto"]) : null
						, 'ar_cst_apoio_prds' => !empty($aRequest["ar_cst_apoio_prds"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_apoio_prds"]) : null
						, 'sum_ar_cst_apoio' => !empty($aRequest["sum_ar_cst_apoio"]) ? (float) str_replace(',', '.', $aRequest["sum_ar_cst_apoio"]) : null
						, 'ar_cst_nutl_pavtr_prds' => !empty($aRequest["ar_cst_nutl_pavtr_prds"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_nutl_pavtr_prds"]) : null
						, 'ar_cst_nutl_pavsup_prds' => !empty($aRequest["ar_cst_nutl_pavsup_prds"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_nutl_pavsup_prds"]) : null
						, 'ar_cst_total_prds' => !empty($aRequest["ar_cst_total_prds"]) ? (float) str_replace(',', '.', $aRequest["ar_cst_total_prds"]) : null
						, 'ar_stcio_arpav_armano' => !empty($aRequest["ar_stcio_arpav_armano"]) ? (float) str_replace(',', '.', $aRequest["ar_stcio_arpav_armano"]) : null
						, 'ar_total_perm_jard' => !empty($aRequest["ar_total_perm_jard"]) ? (float) str_replace(',', '.', $aRequest["ar_total_perm_jard"]) : null
						, 'ar_total_perm_pedris' => !empty($aRequest["ar_total_perm_pedris"]) ? (float) str_replace(',', '.', $aRequest["ar_total_perm_pedris"]) : null
						, 'sum_ar_descb_ext' => !empty($aRequest["sum_ar_descb_ext"]) ? (float) str_replace(',', '.', $aRequest["sum_ar_descb_ext"]) : null
						, 'ar_ocup_pvt' => !empty($aRequest["ar_ocup_pvt"]) ? (float) str_replace(',', '.', $aRequest["ar_ocup_pvt"]) : null
						, 'sum_ar_ext_pvt' => !empty($aRequest["sum_ar_ext_pvt"]) ? (float) str_replace(',', '.', $aRequest["sum_ar_ext_pvt"]) : null
						, 'ar_trn_mq' => !empty($aRequest["ar_trn_mq"]) ? (float) str_replace(',', '.', $aRequest["ar_trn_mq"]) : null
						]);

			$bUpdated = true;
		}

		catch(Exception $e)
		{
			$bUpdated = null;
			throw $e->message();
		}

		return $bUpdated;
	}

	public function etapasLoja($aRequest)
	{
		// variável de retorno
		$bUpdated = null;

		// dd($aRequest);

		try
		{

			$this->where('id', $aRequest['projetos'])
				 ->update(['n_rev_ep' => $aRequest["hdnn_rev_ep"] === "" ? null : $aRequest["hdnn_rev_ep"]
						, 'n_rev_ev' => $aRequest["hdnn_rev_ev"] === "" ? null : $aRequest["hdnn_rev_ev"]
						, 'n_rev_pl' => $aRequest["hdnn_rev_pl"] === "" ? null : $aRequest["hdnn_rev_pl"]
						, 'n_rev_exec' => $aRequest["hdnn_rev_exec"] === "" ? null : $aRequest["hdnn_rev_exec"]
						, 'dt_ultima_etapa' => !empty($aRequest["dt_ultima_etapa"]) ? $aRequest["dt_ultima_etapa"] : null
						, 'rev_perspectiva' => $aRequest["n_rev_perspectiva"] === "" ? null : $aRequest["n_rev_perspectiva"]
						, 'dt_rev_perspectiva' => !empty($aRequest["dt_rev_perspectiva"]) ? $aRequest["dt_rev_perspectiva"] : null
						, 'tipo_obra' => !empty($aRequest["tipo_obra"]) ? $aRequest["tipo_obra"] : null
						, 'parceiro_locacao' => !empty($aRequest["sub_locacao"]) ? $aRequest["sub_locacao"] : null
						, 'celula' => !empty($aRequest["celula"]) ? $aRequest["celula"] : null
						, 'observacao' => !empty($aRequest["observacoes"]) ? $aRequest["observacoes"] : null]);
			$bUpdated = true;
		}
		catch(Exception $e)
		{
			$bUpdated = null;
			throw $e->message();
		}

		return $bUpdated;
	}

	// function para verificar se existe projeto onde o parâmetro enviado
	public function selectProjetosWhere($sCampoWhere, $sValorWhere, $sBandeira)
	{
		// array de retorno
		$iRetono;

		$sCampoPesquisa;

		switch ($sCampoWhere) 
		{
			case 'apelido_projeto':
				$sCampoPesquisa = 'apelido';
				break;
			case 'nome_projeto':
				$sCampoPesquisa = 'nome';
				break;
			case 'codigo_projeto_manual':
				$sCampoPesquisa = 'codigo_loja';
				break;
		}
		
		if ($sCampoPesquisa == 'codigo_loja') 
		{
			$iRetono = $this->where($sCampoPesquisa, $sValorWhere)
							->where('bandeira', $sBandeira)->count();
		}
		else
		{
			$iRetono = $this->where($sCampoPesquisa, $sValorWhere)->count();
		}
		
        return $iRetono;
	}
}
