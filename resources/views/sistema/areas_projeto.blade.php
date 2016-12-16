@extends('layouts.masterpage')

@extends('layouts.common_panels')

@section('form')

<style media="all">
	label
	{
		font-size: 13px;
	}

	legend
	{
		margin-bottom: 0px;
		padding: 5px 15px 5px 15px;
	}

	.panel-body
	{
		padding: 15px 0px 15px 0px;
	}

	.chosen-rtl .chosen-drop { left: -9000px; }
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

	{{ Form::open(['route' => 'areasprojetoPost', 'method' => 'POST' ,'class' => 'form form-horizontal text-left form-transparent', 'id' => 'formNp']) }}
		<div class="panel-body">
		<div id="receptHidden"></div>

		<input type="hidden" id="hdnApelido" value="">
		<input type="hidden" id="hdnNomeProjeto" value="">
		<input type="hidden" id="hdnCodProjeto" value="">
			
			<legend style="padding: 0px 15px 0px 15px">
				<div class="form-group form-inline" id="containerComboProjetos">
					<div class="col-sm-4 col-md-4">
						<b>editar informações do projeto</b>
					</div>
					<div class="col-sm-8 col-md-8 text-right">
						<small>selecione um projeto: </small>
						{!! Form::select('projetos', $aProjetos, '', ['class' => 'form-control input-sm input-sm chosen-select obg', 'id' => 'projetos']) !!}
					</div>
				</div>
			</legend>

			<!-- BLOCO INFORMAÇÕES ESTÁTICAS INÍCIO -->
			<legend>
				<div class="form-group">
					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'aplicação:') !!}
						<select name="aplicacao" id="aplicacao" class="form-control input-sm">
							<option value="">selecione aplicação</option>
							<option value="SIM">SIM</option>
							<option value="NÃO">NÃO</option>
							<option value="SALA FARMECÊUTICO">SALA FARMECÊUTICO</option>
							<option value="SF 9M²">SF 9M²</option>
							<option value="OUTROS">OUTROS</option>
						</select>
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'número de vagas:') !!}
						{{ Form::number('num_vagas', '', ['class' => 'form-control input-sm', 'id' => 'num_vagas', 'placeholder' => 'numero de vagas', 'min' => '0']) }}
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'estoque:') !!}
						{{ Form::text('estoque', '', ['class' => 'form-control input-sm obgMask', 'id' => 'estoque', 'placeholder' => 'área estoque m²']) }}
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'área de vendas:') !!}
						{{ Form::text('ar_vendas', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_vendas', 'placeholder' => 'área de vendas m²']) }}
					</div>

				</div>
			</legend>
			<!-- BLOCO INFORMAÇÕES ESTÁTICAS FIM -->
			
			<!-- BLOCO AZUL INICIO -->
			<legend style="background-color: #87CEFA">
				<div class="form-group">
					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área construída vendas m²:') !!}
						{{ Form::text('ar_cst_venda', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_venda', 'placeholder' => 'área construída vendas m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área construída apoio térreo m²:') !!}
						{{ Form::text('ar_cst_apoio_terreo', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_apoio_terreo', 'placeholder' => 'área construída apoio térreo m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área construída apoio mezanino m²:') !!}
						{{ Form::text('ar_cst_apoio_meza', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_apoio_meza', 'placeholder' => 'área construída apoio mezanino m²']) }}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área estacionamento coberto m²:') !!}
						{{ Form::text('ar_estac_coberto', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_estac_coberto', 'placeholder' => 'área estacionamento coberto m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área construída apoio total m²:') !!}
						{{ Form::text('ar_cst_apoio_prds', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_apoio_prds', 'placeholder' => 'área construída apoio total m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área constr./reforma raia drogasil m²:') !!}
						{{ Form::text('sum_ar_cst_apoio', '', ['class' => 'form-control input-sm obgMask', 'id' => 'sum_ar_cst_apoio', 'placeholder' => 'área constr./reforma raia drogasil m²']) }}
					</div>
				</div>
			</legend>
			<!-- BLOCO AZUL FIM -->
			
			<!-- BLOCO VERDE INICIO -->
			<legend style="background-color: #8FBC8F">
				<div class="form-group">
					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área não utilizada pav. térreo m²:') !!}
						{{ Form::text('ar_cst_nutl_pavtr_prds', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_nutl_pavtr_prds', 'placeholder' => 'área não utilizada pav. térreo m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área não utilizada pav. superior m²:') !!}
						{{ Form::text('ar_cst_nutl_pavsup_prds', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_nutl_pavsup_prds', 'placeholder' => 'área não utilizada pav. superior m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área construída total m²:') !!}
						{{ Form::text('ar_cst_total_prds', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_cst_total_prds', 'placeholder' => 'área construída total m²']) }}
					</div>
				</div>
			</legend>
			<!-- BLOCO VERDE FIM -->

			<!-- BLOCO CORAL INICIO -->
			<legend style="background-color: #FFE4C4">
				<div class="form-group">
					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'área estaci. descoberto m²:') !!}
						{{ Form::text('ar_stcio_arpav_armano', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_stcio_arpav_armano', 'placeholder' => 'área estaci. descoberto m²']) }}
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'área ajardinada m²:') !!}
						{{ Form::text('ar_total_perm_jard', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_total_perm_jard', 'placeholder' => 'área ajardinada m²']) }}
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'área descob. sem piso m²:') !!}
						{{ Form::text('ar_total_perm_pedris', '', ['class' => 'form-control input-sm obgMask', 'id' => 'ar_total_perm_pedris', 'placeholder' => 'área descob. sem piso m²']) }}
					</div>

					<div class="col-sm-3 col-md-3">
						{!! Form::label('', 'área externa total m²:') !!}
						{{ Form::text('sum_ar_descb_ext', '', ['class' => 'form-control input-sm obgMask', 'id' => 'sum_ar_descb_ext', 'placeholder' => 'área externa total m²']) }}
					</div>
				</div>
			</legend>
			<!-- BLOCO CORAL FIM -->

			<!-- BLOCO ROSA INICIO -->
			<legend style="background-color: #FF7F50">
				<div class="form-group">
					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área de ocupação pavimento térreo m²:') !!}
						{{ Form::text('ar_ocup_pvt', '', ['class' => 'form-control obgMask', 'id' => 'ar_ocup_pvt', 'placeholder' => 'área de ocupação pavimento térreo m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'soma áreas externas e pav térreo m²:') !!}
						{{ Form::text('sum_ar_ext_pvt', '', ['class' => 'form-control obgMask', 'id' => 'sum_ar_ext_pvt', 'placeholder' => 'soma áreas externas e pav térreo m²']) }}
					</div>

					<div class="col-sm-4 col-md-4">
						{!! Form::label('', 'área terreno - m²:') !!}
						{{ Form::text('ar_trn_mq', '', ['class' => 'form-control obgMask', 'id' => 'ar_trn_mq', 'placeholder' => 'área terreno - m²']) }}
					</div>
				</div>
			</legend>
			<!-- BLOCO ROSA FIM -->

			<!-- <hr /> -->
			<div style="padding: 20px 15px 0px 15px">
				<button type="submit" class="btn btn-success" id='btnSubmitForm'>salvar áreas do projeto</button>
			</div>
		</div>
	{{ Form::close() }}

@stop

@section('script')
	<script>
		$(document).ready(function()
		{

			// iniciando com o botão travado até selecionar um projeto
			$('#btnSubmitForm').prop('disabled', true);

			// mascara de números para as medidas
			$('.obgMask').mask("####,00", {reverse: true});
			
			$(".chosen-search input[type=text]").prop('maxlength', '12');

			// campos que são preenchidos automaticamente travados
			$('#ar_cst_apoio_prds').prop('readonly', true);
			$('#sum_ar_cst_apoio').prop('readonly', true);
			$('#ar_cst_total_prds').prop('readonly', true);
			$('#sum_ar_descb_ext').prop('readonly', true);
			$('#ar_ocup_pvt').prop('readonly', true);
			$('#sum_ar_ext_pvt').prop('readonly', true);

			//-------------TRATAMENTO DOS PREENCHIMENTOS AUTOMÁTICOS INÍCIO---------------------------//
			$('#ar_cst_apoio_terreo, #ar_cst_apoio_meza').blur(function()
			{
				var ar_cst_apoio_terreo = $('#ar_cst_apoio_terreo').val() == '' ? 0 : $('#ar_cst_apoio_terreo').val().replace(',', '.');
				var ar_cst_apoio_meza = $('#ar_cst_apoio_meza').val() == '' ? 0 : $('#ar_cst_apoio_meza').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sum = (parseFloat(ar_cst_apoio_terreo) + parseFloat(ar_cst_apoio_meza));

				$('#ar_cst_apoio_prds').val(sum.toFixed(2).replace('.', ','));
			});

			$('#ar_cst_venda, #ar_estac_coberto, #ar_cst_apoio_terreo, #ar_cst_apoio_meza').blur(function()
			{
				var ar_cst_venda = $('#ar_cst_venda').val() == '' ? 0 : $('#ar_cst_venda').val().replace(',', '.');
				var ar_estac_coberto = $('#ar_estac_coberto').val() == '' ? 0 : $('#ar_estac_coberto').val().replace(',', '.');
				var ar_cst_apoio_prds = $('#ar_cst_apoio_prds').val() == '' ? 0 : $('#ar_cst_apoio_prds').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sumB = (parseFloat(ar_cst_venda) + parseFloat(ar_estac_coberto) + parseFloat(ar_cst_apoio_prds));

				$('#sum_ar_cst_apoio').val(sumB.toFixed(2).replace('.', ','));
			});

			$('#ar_cst_nutl_pavtr_prds, #ar_cst_nutl_pavsup_prds, #ar_cst_venda, #ar_estac_coberto, #ar_cst_apoio_terreo, #ar_cst_apoio_meza')
			.blur(function()
			{
				var ar_cst_nutl_pavtr_prds = $('#ar_cst_nutl_pavtr_prds').val() == '' ? 0 : $('#ar_cst_nutl_pavtr_prds').val().replace(',', '.');
				var ar_cst_nutl_pavsup_prds = $('#ar_cst_nutl_pavsup_prds').val() == '' ? 0 : $('#ar_cst_nutl_pavsup_prds').val().replace(',', '.');
				var sum_ar_cst_apoio = $('#sum_ar_cst_apoio').val() == '' ? 0 : $('#sum_ar_cst_apoio').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sumC = (parseFloat(ar_cst_nutl_pavtr_prds) + parseFloat(ar_cst_nutl_pavsup_prds) + parseFloat(sum_ar_cst_apoio));
				
				$('#ar_cst_total_prds').val(sumC.toFixed(2).replace('.', ','));

			});

			$('#ar_stcio_arpav_armano, #ar_total_perm_jard, #ar_total_perm_pedris').blur(function()
			{
				var ar_stcio_arpav_armano = $('#ar_stcio_arpav_armano').val() == '' ? 0 : $('#ar_stcio_arpav_armano').val().replace(',', '.');
				var ar_total_perm_jard = $('#ar_total_perm_jard').val() == '' ? 0 : $('#ar_total_perm_jard').val().replace(',', '.');
				var ar_total_perm_pedris = $('#ar_total_perm_pedris').val() == '' ? 0 : $('#ar_total_perm_pedris').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sumD = (parseFloat(ar_stcio_arpav_armano) + parseFloat(ar_total_perm_jard) + parseFloat(ar_total_perm_pedris));

				$('#sum_ar_descb_ext').val(sumD.toFixed(2).replace('.', ','));
			});


			$('#ar_cst_venda, #ar_cst_apoio_terreo, #ar_estac_coberto, #ar_cst_nutl_pavtr_prds').blur(function()
			{
				var ar_cst_venda = $('#ar_cst_venda').val() == '' ? 0 : $('#ar_cst_venda').val().replace(',', '.');
				var ar_cst_apoio_terreo = $('#ar_cst_apoio_terreo').val() == '' ? 0 : $('#ar_cst_apoio_terreo').val().replace(',', '.');
				var ar_estac_coberto = $('#ar_estac_coberto').val() == '' ? 0 : $('#ar_estac_coberto').val().replace(',', '.');
				var ar_cst_nutl_pavtr_prds = $('#ar_cst_nutl_pavtr_prds').val() == '' ? 0 : $('#ar_cst_nutl_pavtr_prds').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sumE = (parseFloat(ar_cst_venda) 
							+ parseFloat(ar_cst_apoio_terreo) 
							+ parseFloat(ar_estac_coberto) 
							+ parseFloat(ar_cst_nutl_pavtr_prds));

				$('#ar_ocup_pvt').val(sumE.toFixed(2).replace('.', ','));
			});

			$('#ar_stcio_arpav_armano, #ar_total_perm_jard, #ar_total_perm_pedris, #ar_cst_venda, #ar_cst_apoio_terreo, #ar_estac_coberto, #ar_cst_nutl_pavtr_prds').blur(function()
			{
				var ar_stcio_arpav_armano = $('#ar_stcio_arpav_armano').val() == '' ? 0 : $('#ar_stcio_arpav_armano').val().replace(',', '.');
				var ar_total_perm_jard = $('#ar_total_perm_jard').val() == '' ? 0 : $('#ar_total_perm_jard').val().replace(',', '.');
				var ar_total_perm_pedris = $('#ar_total_perm_pedris').val() == '' ? 0 : $('#ar_total_perm_pedris').val().replace(',', '.');

				var ar_cst_venda = $('#ar_cst_venda').val() == '' ? 0 : $('#ar_cst_venda').val().replace(',', '.');
				var ar_cst_apoio_terreo = $('#ar_cst_apoio_terreo').val() == '' ? 0 : $('#ar_cst_apoio_terreo').val().replace(',', '.');
				var ar_estac_coberto = $('#ar_estac_coberto').val() == '' ? 0 : $('#ar_estac_coberto').val().replace(',', '.');
				var ar_cst_nutl_pavtr_prds = $('#ar_cst_nutl_pavtr_prds').val() == '' ? 0 : $('#ar_cst_nutl_pavtr_prds').val().replace(',', '.');
				
				// soma para aplicar em ar_cst_apoio_prds
				var sumF = (parseFloat(ar_stcio_arpav_armano) 
							+ parseFloat(ar_total_perm_jard) 
							+ parseFloat(ar_total_perm_pedris)
							+ parseFloat(ar_cst_venda) 
							+ parseFloat(ar_cst_apoio_terreo) 
							+ parseFloat(ar_estac_coberto) 
							+ parseFloat(ar_cst_nutl_pavtr_prds));

				$('#sum_ar_ext_pvt').val(sumF.toFixed(2).replace('.', ','));
			});
			//-------------TRATAMENTO DOS PREENCHIMENTOS AUTOMÁTICOS FIM---------------------------//




			$('#projetos').change(function()
			{
				var id = $(this).val();
				var bFillFields = true;
				$.ajax({
			        type: "POST",
			        url: "{{ route('areasprojetoPost') }}",
			        data: {'id' : id, 'bFillFields' : bFillFields},
			        dataType: 'JSON',
			        success: function(j) 
			        {
			        	if (j == 'nenhum resultado para esta escolha') 
			        	{
			        		// trava o botão no caso de não ter selecionado um projeto
			        		$('#btnSubmitForm').prop('disabled', true);

							$(':input','#formNp')
							.not(':button, :submit, :reset, :hidden, :radio')
							.val('')
							.removeAttr('checked')
							.removeAttr('selected');
			        		return true;
			        	}
			        	else
			        	{
			        		// destravando o botão no caso de ter selecionado um projeto
			        		$('#btnSubmitForm').prop('disabled', false);

			        		// console.log(j.ar_cst_venda.toString().replace('.', ','));

							$('#estoque').val(j.estoque == null ? '' : j.estoque.toString().replace('.', ','));
							$('#ar_vendas').val(j.ar_vendas == null ? '' : j.ar_vendas.toString().replace('.', ','));
							$('#aplicacao').val(j.aplicacao);
							$('#num_vagas').val(j.num_vagas);
							$('#ar_cst_venda').val(j.ar_cst_venda == null ? '' : j.ar_cst_venda.toString().replace('.', ','));
							$('#ar_cst_apoio_terreo').val(j.ar_cst_apoio_terreo == null ? '' : j.ar_cst_apoio_terreo.toString().replace('.', ','));
							$('#ar_cst_apoio_meza').val(j.ar_cst_apoio_meza == null ? '' : j.ar_cst_apoio_meza.toString().replace('.', ','));
							$('#ar_estac_coberto').val(j.ar_estac_coberto == null ? '' : j.ar_estac_coberto.toString().replace('.', ','));
							$('#ar_cst_apoio_prds').val(j.ar_cst_apoio_prds == null ? '' : j.ar_cst_apoio_prds.toString().replace('.', ','));
							$('#sum_ar_cst_apoio').val(j.sum_ar_cst_apoio == null ? '' : j.sum_ar_cst_apoio.toString().replace('.', ','));
							$('#ar_cst_nutl_pavtr_prds').val(j.ar_cst_nutl_pavtr_prds == null ? '' : j.ar_cst_nutl_pavtr_prds.toString().replace('.', ','));
							$('#ar_cst_nutl_pavsup_prds').val(j.ar_cst_nutl_pavsup_prds == null ? '' : j.ar_cst_nutl_pavsup_prds.toString().replace('.', ','));
							$('#ar_cst_total_prds').val(j.ar_cst_total_prds == null ? '' : j.ar_cst_total_prds.toString().replace('.', ','));
							$('#ar_stcio_arpav_armano').val(j.ar_stcio_arpav_armano == null ? '' : j.ar_stcio_arpav_armano.toString().replace('.', ','));
							$('#ar_total_perm_jard').val(j.ar_total_perm_jard == null ? '' : j.ar_total_perm_jard.toString().replace('.', ','));
							$('#ar_total_perm_pedris').val(j.ar_total_perm_pedris == null ? '' : j.ar_total_perm_pedris.toString().replace('.', ','));
							$('#sum_ar_descb_ext').val(j.sum_ar_descb_ext == null ? '' : j.sum_ar_descb_ext.toString().replace('.', ','));
							$('#ar_ocup_pvt').val(j.ar_ocup_pvt == null ? '' : j.ar_ocup_pvt.toString().replace('.', ','));
							$('#sum_ar_ext_pvt').val(j.sum_ar_ext_pvt == null ? '' : j.sum_ar_ext_pvt.toString().replace('.', ','));
							$('#ar_trn_mq').val(j.ar_trn_mq == null ? '' : j.ar_trn_mq.toString().replace('.', ','));
			        	}
			        },
					error: function()
					{
						alert('error! contact support...');
					}
			    });
			});
		});
		
		// plugin de combo com busca
		var config = 
		{
	      '.chosen-select'           : {},
	      '.chosen-select-deselect'  : {allow_single_deselect:true},
	      '.chosen-select-no-single' : {disable_search_threshold:10},
	      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
	      '.chosen-select-width'     : {width:"95%"}
	    }

	    for (var selector in config) 
	    {
	      $(selector).chosen(config[selector]);
	    }
	</script>
@stop

guaru