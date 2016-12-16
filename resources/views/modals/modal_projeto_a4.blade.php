<!-- estilo da fonte -->
<style>
  .modal-dialog
  {
    /*font-style: italic;*/
    font-style: oblique;
    font-size: 16px;
  }

  .modal-dialog label
  {
    font-style: normal;
    font-size: 13px;
    letter-spacing: -1px;
  }
</style>

<!-- MODAL LOJA A4 -->
<div class="modal-dialog" style="width: auto;">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">dados da loja: " {{$aDadosLoja['frente']['apelido']}} "</h4>
    </div>
    <div class="modal-body" style="overflow-y: auto;">
      <div class="form-group">
        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'bandeira: '), $aDadosLoja['frente']['bandeira'] !!}
        </div>

        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'apelido do projeto: '), $aDadosLoja['frente']['apelido'] !!}
        </div>

        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'nome do projeto: '), $aDadosLoja['frente']['nome'] !!}
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12">
          <hr style="margin: 0px 0px 2px 0px; border-width: 0.5px; border-color: #D3D3D3; min-width: 100%;" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'código da loja: '), $aDadosLoja['frente']['codigo_loja'] !!}
        </div>

        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'estado: '), $aDadosLoja['frente']['uf_projeto'] !!}
        </div>

        <div class="col-sm-4 col-md-4">
          {!! Form::label('', 'município: '), $aDadosLoja['frente']['municipio'] !!}
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12">
          <hr style="margin: 0px 0px 2px 0px; border-width: 0.5px; border-color: #D3D3D3; min-width: 100%;" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'categoria: '), $aDadosLoja['frente']['categoria'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'perfil arquitetônico: '), $aDadosLoja['frente']['arquit'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'data da inauguração: '), $aDadosLoja['frente']['dt_inauguracao'] == null ? 'sem data prevista' : Carbon\Carbon::parse($aDadosLoja['frente']['dt_inauguracao'])->format('d/m/Y') !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'ativo ou inativo: '), $aDadosLoja['frente']['ativo_inativo'] == 1 ? 'ativo' : inativo !!}
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12">
          <hr style="border-style: dotted ; border-width: 1px; margin: 14px 0px 14px 0px; padding: 0px 0px 0px 0px; min-width: 100%;" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'etapa do projeto: ') !!} 
          {!! $aDadosLoja['frente']['n_rev_ev'] == null ? null : ' ev: '.$aDadosLoja['frente']['n_rev_ev'] !!} 
          {!! $aDadosLoja['frente']['n_rev_ep'] == null ? null : ' | ep: '.$aDadosLoja['frente']['n_rev_ep'] !!} 
          {!! $aDadosLoja['frente']['n_rev_pl'] == null ? null : ' | pl: '.$aDadosLoja['frente']['n_rev_pl'] !!} 
          {!! $aDadosLoja['frente']['n_rev_exec'] == null ? null : ' | exec: '.$aDadosLoja['frente']['n_rev_exec'] !!} 
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'data envio da ultima etapa: '), $aDadosLoja['frente']['dt_ultima_etapa'] == null ? 'sem data de ultima etapa' : Carbon\Carbon::parse($aDadosLoja['frente']['dt_ultima_etapa'])->format('d/m/Y') !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'revisão perspectiva: '), $aDadosLoja['frente']['rev_perspectiva'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'data revisão perspectiva: '), $aDadosLoja['frente']['dt_rev_perspectiva'] == null ? 'sem data de revisão da perspectiva' : Carbon\Carbon::parse($aDadosLoja['frente']['dt_rev_perspectiva'])->format('d/m/Y') !!}
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12">
          <hr style="margin: 0px 0px 2px 0px; border-width: 0.5px; border-color: #D3D3D3; min-width: 100%;" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'tipo de obra: '), $aDadosLoja['frente']['tipo_obra'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'parceiro sub-locação: '), $aDadosLoja['frente']['parceiro_locacao'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'célula: '), $aDadosLoja['frente']['celula'] !!}
        </div>

        <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'observações: '), $aDadosLoja['frente']['observacao'] !!}
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12">
          <hr style="border-style: dotted ; border-width: 1px; margin: 14px 0px 14px 0px; padding: 0px 0px 0px 0px; min-width: 100%;" />
        </div>
      </div>

      <div class="row" style="margin: 5px 0px 5px 0px; padding:  5px 0px 5px 0px;">
        <div class="form-group">
          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'aplicação: '), $aDadosLoja['frente']['aplicacao'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'número de vagas: '), $aDadosLoja['frente']['num_vagas'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'estoque: '), $aDadosLoja['frente']['estoque'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
            {!! Form::label('', 'área de vendas: '), $aDadosLoja['frente']['ar_vendas'] !!}
          </div>
        </div>
      </div>

      <div class="row" style="background-color: #87CEFA; margin: 5px 0px 5px 0px; padding:  5px 0px 5px 0px;">
        <div class="form-group">
          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída vendas m²: '), $aDadosLoja['frente']['ar_cst_venda'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída apoio térreo m²: '), $aDadosLoja['frente']['ar_cst_apoio_terreo'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída apoio mezanino m²: '), $aDadosLoja['frente']['ar_cst_apoio_meza'] !!}
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área estacionamento coberto m²: '), $aDadosLoja['frente']['ar_estac_coberto'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída apoio total m²: '), $aDadosLoja['frente']['ar_cst_apoio_prds'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área constr./reforma raia drogasil m²: '), $aDadosLoja['frente']['sum_ar_cst_apoio'] !!}
          </div>
        </div>
      </div>

      <div class="row" style="background-color: #8FBC8F; margin: 5px 0px 5px 0px; padding:  5px 0px 5px 0px;">
        <div class="form-group">
          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída vendas m²: '), $aDadosLoja['frente']['ar_cst_nutl_pavtr_prds'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída apoio térreo m²: '), $aDadosLoja['frente']['ar_cst_nutl_pavsup_prds'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área construída apoio mezanino m²: '), $aDadosLoja['frente']['ar_cst_total_prds'] !!}
          </div>
        </div>
      </div>

      <div class="row" style="background-color: #FFE4C4; margin: 5px 0px 5px 0px; padding:  5px 0px 5px 0px;">
        <div class="form-group">
          <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'área estaci. descoberto m²: '), $aDadosLoja['frente']['ar_stcio_arpav_armano'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'área ajardinada m²: '), $aDadosLoja['frente']['ar_total_perm_jard'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'área descob. sem piso m²: '), $aDadosLoja['frente']['ar_total_perm_pedris'] !!}
          </div>

          <div class="col-sm-3 col-md-3">
          {!! Form::label('', 'área externa total m²: '), $aDadosLoja['frente']['sum_ar_descb_ext'] !!}
          </div>
        </div>
      </div>

      <div class="row" style="background-color: #FF7F50; margin: 5px 0px 5px 0px; padding:  5px 0px 5px 0px;">
        <div class="form-group">
          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área de ocupação pavimento térreo m²: '), $aDadosLoja['frente']['ar_ocup_pvt'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'soma áreas externas e pav térreo m²: '), $aDadosLoja['frente']['sum_ar_ext_pvt'] !!}
          </div>

          <div class="col-sm-4 col-md-4">
            {!! Form::label('', 'área terreno - m²: '), $aDadosLoja['frente']['ar_trn_mq'] !!}
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="changeTrackingEtapas" >tracking de etapas</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
    </div>
  </div>
</div>
</div>

<script>
$(document).ready(function()
{

  // modal para abrir tracking de etapas do projeto
    $("#changeTrackingEtapas").click(function()
    {
      // var id = $(this).data('id');
      $.ajax
      ({
        type: "POST",
        url: "{{ route('trackingEtapasPost') }}",
        // data: {'id' : id},
        dataType: 'HTML',
        success: function(h) 
        {
          $("#modalAlert").parent().html(h);
          $("#modalAlert").parent().modal('show');
        },
        error: function()
        {
          alert('error! contact support...');
        }
      });
    });
  
});
</script>
