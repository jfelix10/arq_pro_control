@extends('layouts.masterpage')

@extends('layouts.common_panels')

@section('form')

<style>
  .glyphicon
  {
    color: coral; 
  }

  i:hover, .glyphicon:hover
  {
    cursor: pointer;
  }

  .subcoll
  {
     border: solid 1px #D3D3D3; 
     border-radius: 3px;
     background-color: #F8FFF6;
     padding: 2px 4px 2px 4px;
  }

  th, tr
  {
    white-space: nowrap !important;
  }

  tr:hover
  {
    cursor: pointer;
  }
</style>


<!-- MENSAGENS DE MODAL PARA ALERTAS IMPORTANTES DE AÇÃO -->
<div class="modal fade" role="dialog" id="modalAlert">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ATENÇÃO! aviso importante...</h4>
      </div>

      <div class="modal-body" id="modalAlertBody"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">fechar</button>
      </div>
    </div>

  </div>
</div>

  {{ Form::open(['route' => 'postHomesistema', 'method' => 'POST' ,'class' => 'form form-horizontal text-left form-transparent', 'id' => 'formNp']) }}
    <div class="panel-body">
    <div id="receptHidden"></div>

    <input type="hidden" name="actForm" id="actForm" value="">
      
      <legend>
        <div class="form-group form-inline" id="containerComboProjetos">
          <div class="col-sm-6 col-md-6">
            <b>visão geral dos projetos</b>
          </div>

          <div class="col-sm-6 col-md-6 text-right">
            <span class="glyphicon glyphicon glyphicon-filter" data-tooltip="tooltip" data-placement="left" title="escolher filtros" data-toggle="collapse" data-target="#close-open" style="float: right"></span>
          </div>
        </div>
      </legend>

      <!-- <div id="close-open" class="collapse in">  ||||||||||||||COMEÇA ABERTO ||||||||||||||--> 
      <div id="close-open" class="collapse"> 
        <div class="form-group">
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'bandeira:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-bandeira" style="background-color: #F8FFF6">
            selecione bandeira(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-bandeira" id="bt-op-bandeira" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-bandeira">
              @foreach($aBandeiras as $flag => $drogaria)
                @if(!empty($flag))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('bandeira[]', $flag, isset($aRequestRet['bandeira']) 
                      && is_array($aRequestRet['bandeira']) 
                      && in_array($flag, $aRequestRet['bandeira']) ? true : false) }}
                      {{ $drogaria }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'apelido:') !!}
            {{ Form::text('apelido', $aRequestRet['apelido'], ['class' => 'form-control input-sm', 'id' => 'apelido', 'placeholder' => 'apelido do projeto']) }}
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'filial:') !!}
            {{ Form::text('nome', $aRequestRet['nome'], ['class' => 'form-control input-sm', 'id' => 'nome', 'placeholder' => 'nome do projeto']) }}
          </div>
          
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'código loja:') !!}
            {{ Form::text('codigo_loja', $aRequestRet['codigo_loja'], ['class' => 'form-control input-sm', 'id' => 'codigo_loja', 'placeholder' => 'código do projeto']) }}
          </div>
          

        </div>

        <div class="form-group">
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'estado:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-estados" style="background-color: #F8FFF6">
            selecione estado(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-estados" id="bt-op-estados" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-estados">
              @foreach($aEstadosChaveValor as $uf => $estado)
                @if(!empty($uf))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('uf_projeto[]', $uf, isset($aRequestRet['uf_projeto']) 
                      && is_array($aRequestRet['uf_projeto']) 
                      && in_array($uf, $aRequestRet['uf_projeto']) ? true : false) }}
                      {{ $estado }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'município:') !!}
            {{ Form::text('municipio', $aRequestRet['municipio'], ['class' => 'form-control input-sm', 'id' => 'municipio', 'placeholder' => 'município do projeto']) }}
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'categoria:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-categoria" style="background-color: #F8FFF6">
            selecione categoria(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-categoria" id="bt-op-categoria" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-categoria">
              @foreach($aCategorias as $cat => $categoria)
                @if(!empty($cat))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('categoria[]', $cat, isset($aRequestRet['categoria']) 
                      && is_array($aRequestRet['categoria']) 
                      && in_array($cat, $aRequestRet['categoria']) ? true : false) }}
                      {{ $categoria }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'perfil arquitetônico:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-perfis" style="background-color: #F8FFF6">
            selecione perfil(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-perfis" id="bt-op-perfis" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-perfis">
              @foreach($aPerfis as $perf => $perfis)
                @if(!empty($perf))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('arquit[]', $perf, isset($aRequestRet['arquit']) 
                      && is_array($aRequestRet['arquit']) 
                      && in_array($perf, $aRequestRet['arquit']) ? true : false) }}
                      {{ $perfis }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

        </div>

        <div class="form-group">
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'ativo ou inativo:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-atvin" style="background-color: #F8FFF6">
            selecione ativo/inativo
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-atvin" id="bt-op-atvin" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-atvin">
              @foreach($aAtivoInativo as $atint => $ativinat)
                <div class="checkbox">
                  <label>
                    {{ Form::checkbox('ativo_inativo[]', $atint, isset($aRequestRet['ativo_inativo']) 
                    && is_array($aRequestRet['ativo_inativo']) 
                    && in_array($atint, $aRequestRet['ativo_inativo']) ? true : false) }}
                    {{ $ativinat }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'data da inauguração... De:') !!}
            {{ Form::date('dt_inaug_ini', $aRequestRet['dt_inaug_ini'], ['class' => 'form-control input-sm', 'id' => 'dt_inaug_ini']) }}
            
          </div>

          <div class="col-sm-3 col-md-3">
            <label for=""> Até: </label>
            {{ Form::date('dt_inaug_fim', $aRequestRet['dt_inaug_fim'], ['class' => 'form-control input-sm', 'id' => 'dt_inaug_fim']) }}
          </div>

          <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'etapa do projeto ') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-etproj" style="background-color: #F8FFF6">
            selecione etapa(s) projeto(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-etproj" id="bt-op-etproj" style="float: right">
            </span>
            </i> 
            <div class="collapse subcoll" id="cl-op-etproj">
              <label>
                <div class="col-sm-3 col-md-3 vertical-center">
                  <small>
                    <i>EP: </i>
                  </small>
                </div>
                <div class="col-sm-9 col-md-9">
                  {{ Form::number('n_rev_ep', $aRequestRet['n_rev_ep'], ['class'=> 'form-control input-sm', 'id' => 'n_rev_ep', 'min' => '0']) }}
                </div>
              </label>

              <label>
                <div class="col-sm-3 col-md-3 vertical-center">
                  <small>
                    <i>EV: </i>
                  </small>
                </div>
                <div class="col-sm-9 col-md-9">
                  {{ Form::number('n_rev_ev', $aRequestRet['n_rev_ev'], ['class'=> 'form-control input-sm', 'id' => 'n_rev_ev', 'min' => '0']) }}
                </div>
              </label>

              <label>
                <div class="col-sm-3 col-md-3 vertical-center">
                  <small>
                    <i>PL: </i>
                  </small>
                </div>
                <div class="col-sm-9 col-md-9">
                  {{ Form::number('n_rev_pl', $aRequestRet['n_rev_pl'], ['class'=> 'form-control input-sm', 'id' => 'n_rev_pl', 'min' => '0']) }}
                </div>
              </label>

              <label>
                <div class="col-sm-3 col-md-3 vertical-center">
                  <small>
                    <i>EXEC: </i>
                  </small>
                </div>
                <div class="col-sm-9 col-md-9">
                  {{ Form::number('n_rev_exec', $aRequestRet['n_rev_exec'], ['class'=> 'form-control input-sm', 'id' => 'n_rev_exec', 'min' => '0']) }}
                </div>
              </label>

            </div>
          </div>

        </div>

        <div class="form-group">
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'tipo de obra:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-tpobra" style="background-color: #F8FFF6">
            selecione tipo(s) de obra(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-tpobra" id="bt-op-tpobra" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-tpobra">
              @foreach($aTipoObra as $tpobra => $tipoobra)
                @if(!empty($tpobra))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('tipo_obra[]', $tpobra, isset($aRequestRet['tipo_obra']) 
                      && is_array($aRequestRet['tipo_obra']) 
                      && in_array($tpobra, $aRequestRet['tipo_obra']) ? true : false) }}
                      {{ $tipoobra }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'aplicação:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-aplicacao" style="background-color: #F8FFF6">
            selecione aplicação(ões)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-aplicacao" id="bt-op-aplicacao" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-aplicacao">
              @foreach($aAplicacao as $aplic => $sAplicacao)
                @if(!empty($tpobra))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('aplicacao[]', $aplic, isset($aRequestRet['aplicacao']) 
                      && is_array($aRequestRet['aplicacao']) 
                      && in_array($aplic, $aRequestRet['aplicacao']) ? true : false) }}
                      {{ $sAplicacao }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'parceiro sub-locação:') !!}
            <i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-subloc" style="background-color: #F8FFF6">
            selecione afirmativa(s)
            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-subloc" id="bt-op-subloc" style="float: right">
            </span>
            </i>
            <div class="collapse subcoll" id="cl-op-subloc">
              @foreach($aSubLocacao as $subloc => $sublocacao)
                @if(!empty($subloc))
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('parceiro_locacao[]', $subloc, isset($aRequestRet['parceiro_locacao']) 
                      && is_array($aRequestRet['parceiro_locacao']) 
                      && in_array($subloc, $aRequestRet['parceiro_locacao']) ? true : false) }}
                      {{ $sublocacao }}
                    </label>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'celula:') !!}
            <select name="celula" id="celula" class="form-control">
              <option value="">selecione uma célula</option>
              <option value="JC">JC</option>
              <option value="SK">SK</option>
              <option value="SF">SF</option>
              <option value="CF">CF</option>
              <option value="ENG">ENG</option>
              <option value="Outros">Outros</option>
              <option value="A definir">A definir</option>
            </select>
          </div>
        </div>
      </div>

      <hr />
      <button type="submit" class="btn btn-success" id='btnSubmitForm'>filtrar</button>
      <button type="submit" class="btn btn-warning" id='btnExcel'>exportar pagina</button>
      <button type="submit" class="btn btn-info" id='btnExcelFull'>exportar tudo</button>
      <button class="btn pull-right" type="reset" id="btnReset">limpar filtros</button>
  {{ Form::close() }}

@stop

@section('grid')
<div class="container-fluid">
<div class="table-responsive">
<table class="table table-condensed table-striped table-bordered table-hover input-sm" style='background-color: coral'>
  <thead style='background-color: #3B2818; color: #fff'>
    <!-- <th>ID</th> -->
    <th>CÓDIGO DA LOJA</th>
    <th>BANDEIRA</th>
    <th>ESTADO</th>
    <th>CIDADE</th>
    <th>NOME</th>
    <th>APELIDO</th>
    <th>CATEGORIA</th>
    <th>PERFIL ARQUITETÔNICO</th>
    <th>ATIVO OU INATIVO</th>
    <th>DATA DA INAUGURAÇÃO</th>
    <th>ET. PROJ. EV</th>
    <th>ET. PROJ. EP</th>
    <th>ET. PROJ. PL</th>
    <th>ET. PROJ. EXEC</th>
    <th>DATA ÚLTIMA ETAPA</th>
    <th>REVISÃO PERSPECTIVA</th>
    <th>DATA REVISÃO PERSPECTIVA</th>
    <th>TIPO DE OBRA</th>
    <th>APLICAÇÃO</th>
    <th>PARCEIRO LOCAÇÃO</th>
    <th>CÉLULA RESPONSÁVEL</th>
    <th>NÚMEROS DE VAGAS</th>
    <th>ESTOQUE</th>
    <th style="background-color: #00042A">ÁREA DE VENDAS M²</th>
    <th style="background-color: #00042A">ÁREA CONSTRUÍDA VENDAS M²</th>
    <th style="background-color: #00042A">ÁREA CONSTRUÍDA APOIO TÉRREO M²</th>
    <th style="background-color: #00042A">ÁREA CONSTRUÍDA APOIO MEZANINO M²</th>
    <th style="background-color: #00042A">ÁREA ESTACIONAMENTO COBERTO M²</th>
    <th style="background-color: #00042A">ÁREA CONSTRUÍDA APOIO TOTAL M²</th>
    <th style="background-color: #00042A">ÁREA CONSTR./REFORMA RAIA DROGASIL M²</th>
    <th style="background-color: #1E331A">ÁREA NÃO UTILIZADA PAV. TÉRREO</th>
    <th style="background-color: #1E331A">ÁREA NÃO UTILIZADA PAV. SUPERIOR</th>
    <th style="background-color: #1E331A">ÁREA CONSTRUÍDA TOTAL M²</th>
    <th style="background-color: #382314">ÁREA ESTACI. DESCOBERTO M²</th>
    <th style="background-color: #382314">ÁREA AJARDINADA M²</th>
    <th style="background-color: #382314">ÁREA DESCOB. SEM PISO M²</th>
    <th style="background-color: #382314">ÁREA EXTERNA TOTAL M²</th>
    <th style="background-color: #4C262A">ÁREA DE OCUPAÇÃO PAVIMENTO TÉRREO M²</th>
    <th style="background-color: #4C262A">SOMA ÁREAS EXTERNAS E PAV TÉRREO</th>
    <th style="background-color: #4C262A">ÁREA TERRENO - M²</th>
    <th>OBSERVAÇÕES</th>
  </thead>
  @foreach($aLojas as $lojas)
  
  <tr data-id="{{ $lojas['id'] }}">
    @foreach($lojas->toArray() as $colunas => $dados)
      @if($colunas != 'id')
        @if($colunas == 'ar_cst_venda' || $colunas == 'ar_cst_apoio_terreo' || $colunas == 'ar_cst_apoio_meza' || $colunas == 'ar_estac_coberto' || $colunas == 'ar_cst_apoio_prds' || $colunas == 'sum_ar_cst_apoio')
          <td style="background-color: #CDDAFA">{{ $dados }}</td>
        @elseif($colunas == 'ar_cst_nutl_pavtr_prds'|| $colunas == 'ar_cst_nutl_pavsup_prds' || $colunas == 'ar_cst_total_prds')
          <td style="background-color: #ACE594">{{ $dados }}</td>
        @elseif($colunas == 'ar_stcio_arpav_armano' || $colunas == 'ar_total_perm_jard' || $colunas == 'ar_total_perm_pedris' || $colunas == 'sum_ar_descb_ext')
          <td style="background-color: #E08A50">{{ $dados }}</td>
        @elseif($colunas == 'ar_ocup_pvt' || $colunas == 'sum_ar_ext_pvt' || $colunas == 'ar_trn_mq')
          <td style="background-color: #D16773">{{ $dados }}</td>
        @elseif($colunas == 'dt_inauguracao' || $colunas == 'dt_ultima_etapa' || $colunas == 'dt_rev_perspectiva')
          @if(!empty($dados) && !is_null($dados))
            <td>{{ Carbon\Carbon::parse($dados)->format('d/m/Y') }}</td>
          @else
            <td> </td>
          @endif
        @elseif($colunas == 'ativo_inativo')
          @if($dados === 1)
            <td>ativo</td>
          @elseif($dados === 0)
            <td>inativo</td>
          @else
            <td> </td>
          @endif
        @else
          <td>{{ $dados }}</td>
        @endif
      @endif
    @endforeach
  </tr>
  @endforeach
</table>
</div>
</div>
<center>{{ $aLojas->appends(['aRequestRet' => $aRequestRet])->render() }}</centar>
@stop


@section('script')
<script type="text/javascript">
  $(document).ready(function()
  {

    // mudando seta ao abrir e fechar etapas do projeto
      $('.glyphicon-chevron-down').click(function()
      {
        if ($(this).prop('class') == 'glyphicon glyphicon-chevron-down' || $(this).prop('class') == 'glyphicon glyphicon-chevron-down collapsed') 
        {
          $(this).prop('class', 'glyphicon glyphicon-chevron-up');
        }
        else
        {
          $(this).prop('class', 'glyphicon glyphicon-chevron-down');
        }
      });


    $('#btnSubmitForm').click(function(e){
      e.preventDefault();
      $('#actForm').val('filter');
      $('#formNp').submit();
      $('#actForm').val(null);
    });
    
    $('#btnExcel').click(function(e){
      e.preventDefault();
      $('#actForm').val('export');
      $('#formNp').submit();
      $('#actForm').val(null);
    });

    $('#btnExcelFull').click(function(e){
      e.preventDefault();
      $('#actForm').val('exptFull');
      $('#formNp').submit();
      $('#actForm').val(null);
    });

    // atribuindo vazio aos campos
    $('#btnReset').click(function(e)
    {
      e.preventDefault();

      // contador para validar submit do form
      var contador = 0;

      $('#formNp').each(function(idx, val)
      {
         
        $('input[type=text]').val('');

        $('input[type=checkbox]').prop('checked', false);

        $('input[type=date]').val('');

        $('input[type=number]').val('');

      });
    });

    // $(document).ready(function(){
      $('[data-tooltip="tooltip"]').tooltip(); 
    // });


    // modal para abrir projeto em A4
    $("tr, #changeProjeto").click(function()
    {
      var id = $(this).data('id');
      $.ajax
      ({
        type: "POST",
        url: "{{ route('visualizacaoProjetoPost') }}",
        data: {'id' : id},
        dataType: 'HTML',
        success: function(h) 
        {
          $("#modalAlert").html(h);
          $("#modalAlert").modal('show');
        },
        error: function()
        {
          alert('error! contact support...');
        }
      });
    });
    
  });
</script>
@stop
