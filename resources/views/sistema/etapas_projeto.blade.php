@extends('layouts.masterpage')

@extends('layouts.common_panels')

@section('form')

<style>
	p
	{
		padding: 0px 0px 0px 0px;
		margin: 0px 0px 0px 0px;
	}

	.vertical-center 
	{
		padding: 7px 5px 7px 5px;
	}

	#bt-op-et_projeto
	{
		color: coral;	
	}

	i:hover, #bt-op-et_projeto:hover
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

	{{ Form::open(['route' => 'etapasprojetoPost', 'method' => 'POST' ,'class' => 'form form-horizontal text-left form-transparent', 'id' => 'formNp']) }}
		<div class="panel-body">
		<div id="receptHidden"></div>

		<input type="hidden" id="hdnApelido" value="">
		<input type="hidden" id="hdnNomeProjeto" value="">
		<input type="hidden" id="hdnCodProjeto" value="">
		
		<input type="hidden" id="hdnn_rev_ep" name="hdnn_rev_ep" value="">
		<input type="hidden" id="hdnn_rev_ev" name="hdnn_rev_ev" value="">
		<input type="hidden" id="hdnn_rev_pl" name="hdnn_rev_pl" value="">
		<input type="hidden" id="hdnn_rev_exec" name="hdnn_rev_exec" value="">
			
		<legend>
			<div class="form-group form-inline" id="containerComboProjetos">
				<div class="col-sm-4 col-md-4">
					<b>editar etapas do projeto</b>
				</div>
				<div class="col-sm-8 col-md-8 text-right">
					<small>selecione um projeto: </small>
					{!! Form::select('projetos', $aProjetos, '', ['class' => 'form-control input-sm chosen-select obg', 'id' => 'projetos']) !!}
				</div>
			</div>
		</legend>

		<div class="form-group">
			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'etapa do projeto ') !!}
				<i class="form-control input-sm" data-toggle="collapse" data-target="#cl-op-et_projeto" style="background-color: #F8FFF6">
	            sel. etapa(s) do projeto(s)
	            <span class="glyphicon glyphicon-chevron-down" data-toggle="collapse" data-target="#cl-op-et_projeto" id="bt-op-et_projeto" style="float: right">
	            </span>
	            </i> 
				<div class="collapse subcoll" id="cl-op-et_projeto">

					<label>
						<div class="col-sm-3 col-md-3 vertical-center">
							<small>
								<i>EV: </i>
							</small>
						</div>
						<div class="col-sm-9 col-md-9">
							{{ Form::text('n_rev_ev', '', ['class'=> 'form-control input-sm', 'id' => 'n_rev_ev', 'min' => '0']) }}
						</div>
					</label>
					
					<label>
						<div class="col-sm-3 col-md-3 vertical-center">
							<small>
								<i>EP: </i>
							</small>
						</div>
						<div class="col-sm-9 col-md-9">
							{{ Form::text('n_rev_ep', '', ['class'=> 'form-control input-sm', 'id' => 'n_rev_ep', 'min' => '0']) }}
						</div>
					</label>

					<label>
						<div class="col-sm-3 col-md-3 vertical-center">
							<small>
								<i>PL: </i>
							</small>
						</div>
						<div class="col-sm-9 col-md-9">
							{{ Form::text('n_rev_pl', '', ['class'=> 'form-control input-sm', 'id' => 'n_rev_pl', 'min' => '0']) }}
						</div>
					</label>

					<label>
						<div class="col-sm-3 col-md-3 vertical-center">
							<small>
								<i>EXEC: </i>
							</small>
						</div>
						<div class="col-sm-9 col-md-9">
							{{ Form::text('n_rev_exec', '', ['class'=> 'form-control input-sm', 'id' => 'n_rev_exec', 'min' => '0']) }}
						</div>
					</label>

				</div>
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'data envio da ultima etapa:') !!}
				{{ Form::date('dt_ultima_etapa', '', ['class' => 'form-control', 'id' => 'dt_ultima_etapa', 'placeholder' => 'data revisão layout']) }}
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'revisão perspectiva:') !!}
				{{ Form::number('n_rev_perspectiva', '', ['class' => 'form-control', 'id' => 'n_rev_perspectiva', 'placeholder' => 'nº revisão perspectiva', 'min' => '0']) }}
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'data revisão perspectiva:') !!}
				{{ Form::date('dt_rev_perspectiva', '', ['class' => 'form-control', 'id' => 'dt_rev_perspectiva', 'placeholder' => 'data revisão perspectiva']) }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 col-md-3">
				
			</div>

			<div class="col-sm-9 col-md-9">
				<!-- AQUI VAI O GRID PARA PREENCHER DADOS DE MUDANÇA DE STATUS... -->
				
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'tipo de obra:') !!}
				<select name="tipo_obra" id="tipo_obra" class="form-control">
					<option value="">selecione tipo de obra</option>
					<option value="CONSTRUÇÃO">CONSTRUÇÃO</option>
					<option value="DMLC./CONS.">DMLC./CONS.</option>
					<option value="REFORMA">REFORMA</option>
					<option value="BTS">BTS</option>
				</select>
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'parceiro sub-locação:') !!}
				<select name="sub_locacao" id="sub_locacao" class="form-control">
					<option value="">selecione uma afirmativa</option>
					<option value="SIM">SIM</option>
					<option value="NÃO">NÃO</option>
				</select>
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'célula:') !!}
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

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'observações:') !!}
				{{ Form::textarea('observacoes', '', ['class' => 'form-control', 'id' => 'observacoes', 'size' => '30x2']) }}
			</div>
		</div>

		<hr />
		<button type="submit" class="btn btn-success" id='btnSubmitForm'>salvar etapa do projeto</button>

		</div>
	{{ Form::close() }}

@stop


@section('script')
	<script>
		$(document).ready(function()
		{
			// mascara para estoque
			// mascara de números para as medidas
			$('#estoque').mask("###0,00", {reverse: true});

			// iniciando com o botão travado até selecionar um projeto
			$('#btnSubmitForm').prop('disabled', true);

			// mudando seta ao abrir e fechar etapas do projeto
			$('.glyphicon').click(function()
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

			// 
			/*
			** bloqueio desbloqueio dos campos de revisão de etapas do projeto
			*/

			// inicia com o primeiro compo destravado e os outros travados
			$('#n_rev_ep').prop('disabled', true);
			$('#n_rev_pl').prop('disabled', true);
			$('#n_rev_exec').prop('disabled', true);

			// algoritimo para travar ou destravar conforme preenchimento
			//------INICIO VALIDAÇÕES NUMERO REVISÕES---------------//
			$('#n_rev_ev').blur(function()
			{
				if ($(this).val() != '' && ($(this).val() >= 0 || $(this).val() == '-'))
				{
					$('#n_rev_ep').prop('disabled', false);
				}
				else
				{
					$('#n_rev_ep').prop('disabled', true);
				}
			});

			$('#n_rev_ep').blur(function()
			{
				// alert($(this).text()+'<-texto |||| valor->'+$(this).val());
				if ($(this).val() != '' && ($(this).val() >= 0 || $(this).val() == '-'))
				{
					$('#n_rev_ev').prop('disabled', true);
					$('#n_rev_pl').prop('disabled', false);
				}
				else
				{
					$('#n_rev_ev').prop('disabled', false);
					$('#n_rev_pl').prop('disabled', true);
				}
			});

			$('#n_rev_pl').blur(function()
			{
				if ($(this).val() != '' && ($(this).val() >= 0 || $(this).val() == '-'))
				{
					$('#n_rev_ep').prop('disabled', true);
					$('#n_rev_exec').prop('disabled', false);
				}
				else
				{
					$('#n_rev_ep').prop('disabled', false);
					$('#n_rev_exec').prop('disabled', true);
				}
			});

			$('#n_rev_exec').blur(function()
			{
				if ($(this).val() != '' && ($(this).val() >= 0 || $(this).val() == '-'))
				{
					$('#n_rev_pl').prop('disabled', true);
				}
				else
				{
					$('#n_rev_pl').prop('disabled', false);
				}
			});
			//------FIM VALIDAÇÕES NUMERO REVISÕES---------------//


			$('#projetos').change(function()
			{
				var id = $(this).val();
				var bFillFields = true;
				$.ajax({
			        type: "POST",
			        url: "{{ route('etapasprojetoPost') }}",
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

			        		// inicia com o primeiro compo destravado e os outros travados
							$('#n_rev_ep').prop('disabled', true);
							$('#n_rev_ev').prop('disabled', true);
							$('#n_rev_pl').prop('disabled', true);
							$('#n_rev_exec').prop('disabled', true);

			        		$('#n_rev_ev').val(j.n_rev_ev);
			        		$('#n_rev_ep').val(j.n_rev_ep);
			        		$('#n_rev_pl').val(j.n_rev_pl);
			        		$('#n_rev_exec').val(j.n_rev_exec);
			        		$("#hdnn_rev_ev").val(j.n_rev_ev);
							$("#hdnn_rev_ep").val(j.n_rev_ep);
							$("#hdnn_rev_pl").val(j.n_rev_pl);
							$("#hdnn_rev_exec").val(j.n_rev_exec);

							$('#dt_ultima_etapa').val(j.dt_ultima_etapa);
							$('#n_rev_perspectiva').val(j.rev_perspectiva);
							$('#dt_rev_perspectiva').val(j.dt_rev_perspectiva);
							$('#tipo_obra').val(j.tipo_obra);
							$('#aplicacao').val(j.aplicacao);
							$('#estoque').val(j.estoque);
							$('#sub_locacao').val(j.parceiro_locacao);
							$('#celula').val(j.celula);
							$('#observacoes').val(j.observacao);

							// algoritimo para travar ou destravar conforme preenchimento
							//------INICIO VALIDAÇÕES NUMERO REVISÕES---------------//
							if (j.n_rev_ev != null && (j.n_rev_ev >= 0 || j.n_rev_ev == '-'))
							{
								if (j.n_rev_ev == '-') 
								{
									$('#n_rev_ev').prop('disabled', true);
								}
								else
								{
									$('#n_rev_ev').prop('disabled', false);
									$('#n_rev_ep').prop('disabled', false);
								}
							}
							else if(j.n_rev_ev == null && (j.n_rev_ep != null || j.n_rev_pl != null || j.n_rev_exec != null))
							{
								$('#n_rev_ev').prop('disabled', true);
								$('#n_rev_ev').val('-');
							}
							else
							{
								$('#n_rev_ev').prop('disabled', false);
								$('#n_rev_ev').val('');
							}

							if (j.n_rev_ep != null && (j.n_rev_ep >= 0 || j.n_rev_ep == '-'))
							{
								if (j.n_rev_ep == '-')
								{
									$('#n_rev_ep').val('-');
								}
								else
								{
									$('#n_rev_ev').prop('disabled', true);
									$('#n_rev_ep').prop('disabled', false);
									$('#n_rev_pl').prop('disabled', false);
								}
							}
							else if(j.n_rev_ep == null && (j.n_rev_pl != null || j.n_rev_exec != null))
							{
								$('#n_rev_ep').prop('disabled', true);
								$('#n_rev_ep').val('-');
							}

							if (j.n_rev_pl != null && (j.n_rev_pl >= 0 || j.n_rev_pl == '-'))
							{
								if (j.n_rev_pl == '-') 
								{
									$('#n_rev_pl').val('-');
								}
								else
								{
									$('#n_rev_ep').prop('disabled', true);
									$('#n_rev_pl').prop('disabled', false);
									$('#n_rev_exec').prop('disabled', false);
								}
							}
							else if(j.n_rev_pl == null && j.n_rev_exec != null)
							{
								$('#n_rev_pl').prop('disabled', true);
								$('#n_rev_pl').val('-');
							}
	

							if (j.n_rev_exec != null && j.n_rev_exec >= 0)
							{
								$('#n_rev_pl').prop('disabled', true);
								$('#n_rev_exec').prop('disabled', false);
							}

							//------FIM VALIDAÇÕES NUMERO REVISÕES---------------//
			        	}
			        },
					error: function()
					{
						alert('error! contact support...');
					}
			    });
			});

			$('#btnSubmitForm').click(function(e){
				e.preventDefault();
				$("#hdnn_rev_ev").val($("#n_rev_ev").val());
				$("#hdnn_rev_ep").val($("#n_rev_ep").val());
				$("#hdnn_rev_pl").val($("#n_rev_pl").val());
				$("#hdnn_rev_exec").val($("#n_rev_exec").val());

				$("#formNp").submit();
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