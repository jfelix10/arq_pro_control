<?php

namespace App\Http\Controllers\sistema;

use Request;

use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Classes helpers
use Excel;
use Helpers;
use Carbon\Carbon;

// Models
use App\models\TabelaTotalModel;
use App\models\EstadosModel;

class SistemaHomeController extends Controller
{
    // variáveis de mensagem setadas vazias
    public $alertMessage = '';
    public $alertType = '';

    // array de request to return
    public $aRequestRet = [
                             "bandeira" => ''
                            , "apelido" => ''
                            , "nome" => ''
                            , "codigo_loja" => ''
                            , "uf_projeto" => ''
                            , "municipio" => ''
                            , "categoria" => ''
                            , "arquit" => ''
                            , "ativo_inativo" => ''
                            , "dt_inaug_ini" => ''
                            , "dt_inaug_fim" => ''
                            , "n_rev_ep" => ''
                            , "n_rev_ev" => ''
                            , "n_rev_pl" => ''
                            , "n_rev_exec" => ''
                            , "tipo_obra" => ''
                            , "aplicacao" => ''
                            , "parceiro_locacao" => ''
                            , "celula" => ''
                        ];

    // array perfis
    public $aPerfis = [
                        '' => 'selecione um perfil'
                      , 'BAS' => 'BAS'
                      , 'ESP' => 'ESP'
                      , 'LUX' => 'LUX'
                      , 'STD' => 'STD'
                    ];

    // array categorias
    public $aCategorias = [
                        '' => 'selecione uma categoria'
                      , '3' => 3
                      , '4' => 4
                      , '6' => 6
                      , '7' => 7
                      , '8' => 8
                      , '9' => 9
                      , '4E' => '4E'
                    ];

    // array etapas
    public $aEtapas = [
                        '' => 'selecione uma etapa'
                      , '1' => 'EP'
                      , '2' => 'EV'
                      , '3' => 'PL'
                      , '4' => 'EXEC'
                    ];

    // array tip de obra
    public $aTipoObra = [
                        '' => 'selecione tipo de obra'
                      , 'CONSTRUÇÃO' => 'CONSTRUÇÃO'
                      , 'DMLC./CONS.' => 'DMLC./CONS.'
                      , 'REFORMA' => 'REFORMA'
                      , 'BTS' => 'BTS'
                    ];

    // array sub-locação
    public $aSubLocacao = [
                        '' => 'selecione uma afirmativa'
                      , 'SIM' => 'SIM'
                      , 'NÃO' => 'NÃO'
                    ];


    // array aplicações
    public $aAplicacao = [
                        '' => 'selecione uma aplicação'
                      , 'SIM' => 'SIM'
                      , 'NÃO' => 'NÃO'
                      , 'SALA FARMACÊUTICO' => 'SALA FARMACÊUTICO'
                      , 'SF 9M²' => 'SF 9M²'
                      , 'OUTROS' => 'OUTROS'
                    ];

    // array bandeiras
    public $aBandeiras = [
                        '' => 'selecione uma bandeira'
                      , 'RAIA' => 'RAIA'
                      , 'DROGASIL' => 'DROGASIL'
                      , 'FARMASIL' => 'FARMASIL'
                    ];

    // array bandeiras
    public $aAtivoInativo = [
                        '1' => 'ativo'
                      , '0' => 'inativo'
                    ];

    public $aCelula = [
                    'JC' => 'JC'
                    ,'SK' => 'SK'
                    ,'SF' => 'SF'
                    ,'CF' => 'CF'
                    ,'ENG' => 'ENG'
                    ,'Outros' => 'Outros'
                    ,'A definir' => 'A definir'
                ];

    public function home()
    {
        // array de inputs submetidos pelo form
        $aRequest = Request::all();

        // dd(empty($aRequest));

		// instancia do objeto de banco
		$mTabelaTotal = new TabelaTotalModel();

        // armazenando o request para retornar na pagina
        if (!empty($aRequest)) 
        {
            $this->aRequestRet = isset($aRequest["aRequestRet"]) ? $aRequest["aRequestRet"] : $aRequest;
        }

        // recuperando pesquisa de lojas
        $aLojas = $mTabelaTotal->getGridLojas($aRequest);

        // instancia do objeto de banco
        $mEstados = new EstadosModel();

        // array de estados
        $aEstados = $mEstados->getEstados();

        // helper para criar array
        $hDoArray = new Helpers();

        // array de estados recebendo a primeira posição com valor vazio
        $aEstadosChaveValor = [];
        $aEstadosChaveValor = $hDoArray->makeArrayKeyValeu($aEstados, 'sigla', 'descricao', 'selecione um estado');

        return view('sistema/home', ['aLojas' => $aLojas
                                    , 'aEstadosChaveValor' => $aEstadosChaveValor
                                    , 'aPerfis' => $this->aPerfis
                                    , 'aCategorias' => $this->aCategorias
                                    , 'aRequestRet' => $this->aRequestRet
                                    , 'aEtapas' => $this->aEtapas
                                    , 'aTipoObra' => $this->aTipoObra
                                    , 'aSubLocacao' => $this->aSubLocacao
                                    , 'aAplicacao' => $this->aAplicacao
                                    , 'aBandeiras' => $this->aBandeiras
                                    , 'aAtivoInativo' => $this->aAtivoInativo]);
    }

    public function postHome()
    {
        // array de inputs submetidos pelo form
        $aRequest = Request::all();

        // instancia do objeto de banco
        $mTabelaTotal = new TabelaTotalModel();

        // recuperando pesquisa de lojas para iniciar tela
        $aLojas = $mTabelaTotal->getGridLojas($aRequest);

        // instancia do objeto de banco
        $mEstados = new EstadosModel();

        // array de estados
        $aEstados = $mEstados->getEstados();

        // helper para criar array
        $hDoArray = new Helpers();

        // array de estados recebendo a primeira posição com valor vazio
        $aEstadosChaveValor = [];
        $aEstadosChaveValor = $hDoArray->makeArrayKeyValeu($aEstados, 'sigla', 'descricao', 'selecione um estado');

        // Verificando se foi solicitada a importação de um excel
        if (isset($aRequest['actForm']) && ($aRequest['actForm'] == 'export' || $aRequest['actForm'] == 'exptFull')) 
        {
            $this->aRequestRet = $aRequest;

            // definindo linhas da tabela para gerar excel
            if ($aRequest['actForm'] == 'export') 
            {
                $data = $mTabelaTotal->getGridLojas($aRequest)->toArray()['data'];
            }
            else if ($aRequest['actForm'] == 'exptFull') 
            {
                $data = $mTabelaTotal->getGridFullExpt($aRequest)->toArray();
            }

            // contador de linhas para poder trabalhar com estilos
            $contLinhas = (count($data)+1);

            Excel::create('expFiltro'.Carbon::now()->format('d-m-Y H:i:s'), function($excel) use($data, $contLinhas)
            {
                $excel->sheet('', function($sheet) use($data, $contLinhas) 
                {

                    $sheet
                    ->fromArray($data)
                    ->row(1, array(
                                   'ID', 'CÓDIGO DA LOJA', 'BANDEIRA', 'ESTADO', 'CIDADE', 'NOME', 'APELIDO', 'CATEGORIA', 'PERFIL ARQUITETÔNICO', 'ATIVO OU INATIVO', 'DATA DA INAUGURAÇÃO', 'ET. PROJ. EV', 'ET. PROJ. EP', 'ET. PROJ. PL', 'ET. PROJ. EXEC', 'DATA ÚLTIMA ETAPA', 'REVISÃO PERSPECTIVA', 'DATA REVISÃO PERSPECTIVA', 'TIPO DE OBRA', 'APLICAÇÃO', 'PARCEIRO LOCAÇÃO', 'CÉLULA RESPONSÁVEL', 'NÚMEROS DE VAGAS', 'ESTOQUE', 'ÁREA DE VENDAS M²', 'ÁREA CONSTRUÍDA VENDAS M²', 'ÁREA CONSTRUÍDA APOIO TÉRREO M²', 'ÁREA CONSTRUÍDA APOIO MEZANINO M²', 'ÁREA ESTACIONAMENTO COBERTO M²', 'ÁREA CONSTRUÍDA APOIO TOTAL M²', 'ÁREA CONSTR./REFORMA RAIA DROGASIL M²', 'ÁREA NÃO UTILIZADA PAV. TÉRREO', 'ÁREA NÃO UTILIZADA PAV. SUPERIOR', 'ÁREA CONSTRUÍDA TOTAL M²', 'ÁREA ESTACI. DESCOBERTO M²', 'ÁREA AJARDINADA M²', 'ÁREA DESCOB. SEM PISO M²', 'ÁREA EXTERNA TOTAL M²', 'ÁREA DE OCUPAÇÃO PAVIMENTO TÉRREO M²', 'SOMA ÁREAS EXTERNAS E PAV TÉRREO', 'ÁREA TERRENO - M²', 'OBSERVAÇÕES'
                    ))
                    ->cells('Y1:AD'.$contLinhas, function($cells)
                    {

                        $cells->setFontColor('#000')
                        ->setFont
                        (array(
                            'family'     => 'Calibri',
                            'size'       => '11'
                        ))
                        ->setBackground('#CDDAFA');

                    })
                    ->cells('AE1:AG'.$contLinhas, function($cells)
                    {

                        $cells->setFontColor('#000')
                        ->setFont
                        (array(
                            'family'     => 'Calibri',
                            'size'       => '11'
                        ))
                        ->setBackground('#ACE594');

                    })
                    ->cells('AH1:AK'.$contLinhas, function($cells)
                    {

                        $cells->setFontColor('#000')
                        ->setFont
                        (array(
                            'family'     => 'Calibri',
                            'size'       => '11'
                        ))
                        ->setBackground('#E08A50');

                    })
                    ->cells('AL1:AN'.$contLinhas, function($cells)
                    {

                        $cells->setFontColor('#000')
                        ->setFont
                        (array(
                            'family'     => 'Calibri',
                            'size'       => '11'
                        ))
                        ->setBackground('#D16773');

                    });

                });
            })->export('xls');
        }
        else if(isset($aRequest['actForm']) && $aRequest['actForm'] == 'filter')
        {
            $this->aRequestRet = $aRequest;

            // recuperando pesquisa de lojas
            $aLojas = $mTabelaTotal->getGridLojas($aRequest);
        }

        return view('sistema/home', ['aLojas' => $aLojas
                                    , 'aEstadosChaveValor' => $aEstadosChaveValor
                                    , 'aPerfis' => $this->aPerfis
                                    , 'aCategorias' => $this->aCategorias
                                    , 'aRequestRet' => $this->aRequestRet
                                    , 'aEtapas' => $this->aEtapas
                                    , 'aTipoObra' => $this->aTipoObra
                                    , 'aSubLocacao' => $this->aSubLocacao
                                    , 'aAplicacao' => $this->aAplicacao
                                    , 'aBandeiras' => $this->aBandeiras
                                    , 'aAtivoInativo' => $this->aAtivoInativo]);
    }

    public function novoProjeto()
    {
        // instancia do objeto de banco
        $mEstados = new EstadosModel();

        // array de estados
        $aEstados = $mEstados->getEstados();

        // helper para criar array
        $hDoArray = new Helpers();

        // array de estados recebendo a primeira posição com valor vazio
        $aEstadosChaveValor = [];
        $aEstadosChaveValor = $hDoArray->makeArrayKeyValeu($aEstados, 'sigla', 'descricao', 'selecione um estado');

        

        // valores radio padrão
        $aBoolAtivoInativo = [
                            '1' => "checked = 'checked'"
                          , '0' => false
                        ];

        // array de valores para preencher titulos dos botões
        $aBtns = [];
        $aBtns['insert'] = 'inserir novo projeto';
        $aBtns['update'] = 'alterar projeto';

        // array de inputs submetidos pelo form
        $aRequest = Request::all();

        $alertMessage = '';
        $alertType = '';

        if (isset($aRequest['alertMessage'])) 
        {
            $alertMessage = $aRequest['alertMessage'];
            $alertType = $aRequest['alertType'];
        }

        // instancia do objeto de banco
        $mTabelaTotal = new TabelaTotalModel();

        $aProjetos = $mTabelaTotal->projetosTodos();

        return view('sistema/novo_projeto', ['aBtns' => $aBtns
                                          , 'aEstadosChaveValor' => $aEstadosChaveValor
                                          , 'aPerfis' => $this->aPerfis
                                          , 'aCategorias' => $this->aCategorias
                                          , 'aBoolAtivoInativo' => $aBoolAtivoInativo
                                          , 'aBandeiras' => $this->aBandeiras
                                          , 'aProjetos' => $aProjetos
                                          , 'alertMessage' => $alertMessage
                                          , 'alertType' => $alertType
                                          ]);
    }

    public function postNovoProjeto()
    {
    	// array de inputs submetidos pelo form
    	$aRequest = Request::all();
        
        // retorno de sucesso ou insucesso de query
        $bInsert = null;

        // mensagem de retorno
        $alertMessage = '';
        $alertType = '';

    	if ($aRequest) 
    	{
    		// instancia do objeto de banco
			$mTabelaTotal = new TabelaTotalModel();
			$bInsert = $mTabelaTotal->novaLoja($aRequest);
    	}

        if (!is_null($bInsert)) 
        {
            $alertMessage = 'projeto inserido com sucesso!';
            $alertType = 'success';
        }

		return Redirect::route('novoprojeto', ['alertMessage' => $alertMessage, 'alertType' => $alertType]);
    }

    public function postUpdateProjeto()
    {
        // instancia do objeto de banco
        $mTabelaTotal = new TabelaTotalModel();

        // array de valores submetidos pelo ajax
        $aRequest = Request::all();

        // array de valores para retornar e preencher os campos
        $aDadosProjeto = [];

        if (!empty($aRequest) && !is_null($aRequest) && !isset($aRequest['actUpdate'])) 
        {
            $aDadosProjeto = $mTabelaTotal->projetosDados($aRequest['id']);

            // caso tenha retorno da query retorna pro ajax
            if (isset($aDadosProjeto[0])) 
            {
                return json_encode($aDadosProjeto[0]);
            }
        }
        
        if (isset($aRequest['actUpdate']) && $aRequest['actUpdate'] == 1) 
        {
            $bUpdateProjeto = $mTabelaTotal->updateProjeto($aRequest);

            $alertMessage = 'projeto alterado com sucesso!';
            $alertType = 'success';

            return Redirect::route('novoprojeto', ['alertMessage' => $alertMessage, 'alertType' => $alertType]);
        }

        // combo de projetos
        $aComboProjetos = $mTabelaTotal->projetos();

        return json_encode($aComboProjetos);
    }

    public function areasProjeto()
    {
    	// instancia do objeto de banco
		$mTabelaTotal = new TabelaTotalModel();

		$aProjetos = $mTabelaTotal->projetos();

		return view('sistema/areas_projeto', ['aProjetos' => $aProjetos
                                              , 'alertMessage' => $this->alertMessage
                                              , 'alertType' => $this->alertType]);
    }

    public function postAreasProjeto()
    {
    	// instancia do objeto de banco
		$mTabelaTotal = new TabelaTotalModel();
        
        // array de inputs submetidos pelo form
        $aRequest = Request::all();

        if (isset($aRequest) && isset($aRequest['bFillFields'])) 
        {
            $aDadosProjeto = $mTabelaTotal->projetosDados($aRequest['id']);

            // caso tenha retorno da query retorna pro ajax
            if (isset($aDadosProjeto[0])) 
            {
                return json_encode($aDadosProjeto[0]);
            }
            else
            {
                return json_encode('nenhum resultado para esta escolha');
            }
        }
        else if (isset($aRequest) && !isset($aRequest['bFillFields'])) 
        {
            // instancia do objeto de banco
            $mTabelaTotal = new TabelaTotalModel();
            $bUpdated = $mTabelaTotal->medidasLoja($aRequest);

            if (!is_null($bUpdated)) 
            {
                $this->alertMessage = 'medidas do projeto alteradas com sucesso!';
                $this->alertType = 'success';
            }
        }
		
        $aProjetos = $mTabelaTotal->projetos();

		return view('sistema/areas_projeto', ['aProjetos' => $aProjetos
                                              , 'alertMessage' => $this->alertMessage
                                              , 'alertType' => $this->alertType]);
    }

    public function etapasProjeto()
    {
    	// instancia do objeto de banco
		$mTabelaTotal = new TabelaTotalModel();
		$aProjetos = $mTabelaTotal->projetos();

        // array de inputs submetidos pelo form
        $aRequest = Request::all();

		return view('sistema/etapas_projeto', ['aProjetos' => $aProjetos
                                              , 'alertMessage' => $this->alertMessage
                                              , 'alertType' => $this->alertType]);
    }

    public function postEtapasProjeto()
    {
    	// instancia do objeto de banco
		$mTabelaTotal = new TabelaTotalModel();
		$aProjetos = $mTabelaTotal->projetos();
		
    	// array de inputs submetidos pelo form
    	$aRequest = Request::all();

        if (isset($aRequest) && isset($aRequest['bFillFields'])) 
        {
            $aDadosProjeto = $mTabelaTotal->projetosDados($aRequest['id']);

            // caso tenha retorno da query retorna pro ajax
            if (isset($aDadosProjeto[0])) 
            {
                return json_encode($aDadosProjeto[0]);
            }
            else
            {
                return json_encode('nenhum resultado para esta escolha');
            }
        }
        else if (isset($aRequest) && !isset($aRequest['bFillFields'])) 
        {
    		// instancia do objeto de banco
			$mTabelaTotal = new TabelaTotalModel();
			$bUpdated = $mTabelaTotal->etapasLoja($aRequest);
            
            if (!is_null($bUpdated)) 
            {
                $this->alertMessage = 'etapa do projeto alterada com sucesso!';
                $this->alertType = 'success';
            }
        }

        return view('sistema/etapas_projeto', ['aProjetos' => $aProjetos
                                              , 'alertMessage' => $this->alertMessage
                                              , 'alertType' => $this->alertType]);
    }

    public function postCheckProject()
    {
        // variavel de retorno
        $iSelect = 0;

        // array de inputs submetidos pelo form
        $aRequest = Request::all();
        
        // retorno de sucesso ou insucesso de query
        $bInsert = null;

        // mensagem de retorno
        $alertMessage = '';
        $alertType = '';

        if ($aRequest) 
        {
            // instancia do objeto de banco
            $mTabelaTotal = new TabelaTotalModel();
            $iSelect = $mTabelaTotal->selectProjetosWhere($aRequest['sCampoWhere'], $aRequest['sValorWhere'], $aRequest['sBandeira']);
        }

        return $iSelect;
    }

    public function postVisualizacaoProjeto()
    {
        // array de inputs submetidos pelo form
        $aRequest = Request::all();

        // arrai de valores para o conteúdo da modal
        $aDadosLoja = [];

        // instancia do objeto de banco
        $mTabelaTotal = new TabelaTotalModel();
        $aSelect = $mTabelaTotal->getGridFullExpt($aRequest)->toArray();
        // armazena exatamente o array de dados da loja
        $aDadosLoja['frente'] = $aSelect[0];
        
        // dd($aSelect[0]);

        return View("modals.modal_projeto_a4", compact('aDadosLoja'))->render();
    }
}
