@extends('layouts.masterpage')

@extends('layouts.common_panels', ['aBtns' => $aBtns])

@section('btnChange')
<div class="container" id="btnUpPanelContainer">
	<div class="col-sm-3 col-md-3"></div>
	<div class="col-sm-6 col-md-6">
		{{ Form::open(array('class' => 'text-center form-transparent', 'id' => 'btnUpPanelForm')) }}
			<div class="main-login-form panel-body">
				{{ Form::button($aBtns['insert'], ['class' => 'btn btn-info', 'id' => 'change_to_insert']) }}
				{{ Form::button($aBtns['update'], ['class' => 'btn btn-warning', 'id' => 'change_to_alter']) }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop



@section('form')

<style>
	#municipio_projeto
	{
		text-transform: uppercase;
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

	{{ Form::open(['route' => 'novoprojetoPost', 'method' => 'POST' ,'class' => 'form form-horizontal text-left form-transparent', 'id' => 'formNp']) }}
		<div class="panel-body">
		<div id="receptHidden"></div>

		<input type="hidden" id="hdnApelido" value="">
		<input type="hidden" id="hdnNomeProjeto" value="">
		<input type="hidden" id="hdnCodProjeto" value="">
			
		<legend>
			<div class="form-group form-inline">
				<div class="col-sm-4 col-md-4">
					<b>inserir novo projeto</b>
				</div>
				<div class="col-sm-8 col-md-8 text-right" id="containerComboProjetos">
					<small>selecione um projeto: </small>
					{!! Form::select('projetos', $aProjetos, '', ['class' => 'form-control input-sm chosen-select obg', 'id' => 'projetos']) !!}
				</div>
			</div>
		</legend>

		<div class="form-group">
			<div class="col-sm-4 col-md-4">
				{!! Form::label('', 'bandeira:') !!}
				{!! Form::select('bandeira', $aBandeiras, '', ['class' => 'form-control obg', 'id' => 'bandeira']) !!}
			</div>

			<div class="col-sm-4 col-md-4">
				<label>apelido do projeto</label>
				{{ Form::text('apelido_projeto', '', ['class' => 'form-control obg', 'id' => 'apelido_projeto', 'placeholder' => 'apelido do projeto']) }}
			</div>

			<div class="col-sm-4 col-md-4">
				{!! Form::label('', 'nome do projeto:') !!}
				{{ Form::text('nome_projeto', '', ['class' => 'form-control', 'id' => 'nome_projeto', 'placeholder' => 'nome do projeto']) }}
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-4 col-md-4">
				{!! Form::label('', 'código da loja:') !!}
				{{ Form::number('codigo_projeto_manual', '', ['class' => 'form-control', 'id' => 'codigo_projeto_manual', 'placeholder' => 'código numérico da loja']) }}
			</div>

			<div class="col-sm-4 col-md-4">
				{!! Form::label('', 'estado:') !!}
				{!! Form::select('estado_projeto', $aEstadosChaveValor, '', ['class' => 'form-control obg', 'id' => 'estado_projeto']) !!}
			</div>

			<div class="col-sm-4 col-md-4">
			{!! Form::label('', 'município:') !!}
			{{ Form::text('municipio_projeto', '', ['class' => 'form-control obg', 'id' => 'municipio_projeto', 'placeholder' => 'município']) }}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'categoria:') !!}
				{!! Form::select('categorias_projeto', $aCategorias, '', ['class' => 'form-control', 'id' => 'categorias_projeto']) !!}
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'perfil arquitetônico:') !!}
				{!! Form::select('perfil_arq', $aPerfis, '', ['class' => 'form-control', 'id' => 'perfil_arq']) !!}
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'data da inauguração:') !!}
				{{ Form::date('data_inaugurcao', '', ['class' => 'form-control', 'id' => 'data_inaugurcao', 'placeholder' => 'data de inauguração']) }}
			</div>

			<div class="col-sm-3 col-md-3">
				{!! Form::label('', 'ativo ou inativo:') !!}
				<div class="radio">
				  <label><input type="radio" name="ativo_inativo" value="1" {{ $aBoolAtivoInativo['1'] }}> ativo</label>
				</div>
				<div class="radio">
				  <label><input type="radio" name="ativo_inativo" value="0" {{ $aBoolAtivoInativo['0'] }}> inativo</label>
				</div>
			</div>
		</div>

		<hr />
		<button type="submit" class="btn btn-success" id='btnSubmitForm'>inserir projeto</button>

		</div>
	{{ Form::close() }}

@stop

@section('script')
<script>
	$(document).ready(function()
	{
		// divi que armazena combo de projetos, começa escondida
		$('#containerComboProjetos').hide();

		// validações no submit do formulário
		$('#btnSubmitForm').click(function(e)
		{
			e.preventDefault();

			// contador para validar submit do form
			var contador = 0;

			$('#formNp .obg').each(function(idx, val)
			{
				contador = 0;

				if ($(this).val() == '') 
				{		
					$(this).focus()
					.css('border-color', 'red')
					.tooltip({
				        title: 'preencha-me por favor!'
				    });

				    $(this).tooltip('show');

				    contador++;

					return false;
				}
				else
				{
					$(this).css('border-color', '#ccc');
					$(this).tooltip('destroy');
					return true;
				}
			});

			if (contador == 0) 
			{
				if ($("input[name=ativo_inativo]:radio:checked").val() == 0) 
				{
					$('#modalAlertBody').attr('class' ,'modal-body alert-info');

					$('#modalAlertBody').html('<p>você esta INATIVANDO o projeto! Claro que você pode vir aqui depois e editar este status, no entanto, enquanto isso não acontecer este projeto estará invisível aos outros procedimentos...</p>');

					$('#modalAlert').modal('show');

					$('#modalAlert').on('hidden.bs.modal', function () {
					    $('#formNp').submit();
					});
				}
				else
				{
					$('#formNp').submit();
				}
			}
		});

		// voltar a tela de insert
		$('#change_to_insert').click(function(e){
			e.preventDefault();

			window.location.replace('{{ route("novoprojetoPost") }}');
		});


		// mudando para alterar dados
		$('#change_to_alter').click(function(e)
		{
			e.preventDefault();

			// criando hidden para fazer induzir ao update no submit do form
			var htmlHidden = "<input type='hidden' name='actUpdate' id='actUpdate' value='0'>";


			// alterando id botão submit
			$('#btnSubmitForm').attr('id', 'btnSubmitFormUpd');

			// alterando propriedades do botão com novo id
			$('#btnSubmitFormUpd').attr('disabled', 'disabled');
			$('#btnSubmitFormUpd').text('alterar projeto');

			// inserindo hidden no formulário
			$('#receptHidden').html(htmlHidden);

			$('#formNp').attr('action', "{{ route('updateprojetoPost') }}");

			// resetando os campos
			$(':input','#formNp')
			.not(':button, :submit, :reset, :hidden, :radio')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected')
			.blur()
			.css('border-color', '#ccc')
			.css('background-color', '#fff')
			.tooltip('destroy');

			$('#containerComboProjetos').show();

        	// reler elementos da pagina
			$(document).ready();

		    // preenchedo form com projeto selecionado
			$('#projetos').change(function()
			{
				var id = $(this).val();
				console.log(id);
				$.ajax({
			        type: "POST",
			        url: "{{ route('updateprojetoPost') }}",
			        data: {'id' : id},
			        dataType: 'JSON',
			        success: function(j) 
			        {
			        	if (j[0] == 'escolha um projeto') 
			        	{
			        		// trava o botão no caso de não ter selecionado um projeto
			        		$('#btnSubmitFormUpd').prop('disabled', true);

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
			        		$('#btnSubmitFormUpd').prop('disabled', false);

			        		$('#apelido_projeto').val(j.apelido);
			        		$('#hdnApelido').val(j.apelido); // para comparar no blues dos campos que não podem se repetir
							$('#nome_projeto').val(j.nome);
							$('#hdnNomeProjeto').val(j.nome); // para comparar no blues dos campos que não podem se repetir
							$('#codigo_projeto_manual').val(j.codigo_loja);
							$('#hdnCodProjeto').val(j.codigo_loja); // para comparar no blues dos campos que não podem se repetir
							$('#bandeira').val(j.bandeira);
							$('#estado_projeto').val(j.uf_projeto);
							$('#municipio_projeto').val(j.municipio);
							$('#perfil_arq').val(j.arquit);
							$('#categorias_projeto').val(j.categoria);
							$('#data_inaugurcao').val(j.dt_inauguracao);
							if (j.ativo_inativo == 0) 
							{
								$('input:radio[value="1"]').prop('checked', false);
								$('input:radio[value="0"]').prop('checked', true);
							}
							else if (j.ativo_inativo == 1) 
							{
								$('input:radio[value="0"]').prop('checked', false);
								$('input:radio[value="1"]').prop('checked', true);
							}
			        	}
			        },
					error: function()
					{
						alert('error! contact support...');
					}
			    });
			});

			$('#btnSubmitFormUpd').click(function(e)
			{
				e.preventDefault();
				$('#actUpdate').val(1);

				if ($("input[name=ativo_inativo]:radio:checked").val() == 0) 
				{
					e.preventDefault();
				}
				else
				{
					$('#formNp').submit();
				}
			});
		});

		function blockButton(id)
		{
            $(id).focus(function(e)
			{
				e.preventDefault();
				// trava o botão no caso de não ter selecionado um projeto
	        	$('#btnSubmitFormUpd').prop('disabled', true);
	        	$('#btnSubmitForm').prop('disabled', true);

			});
        }

		blockButton('#apelido_projeto, #nome_projeto, #codigo_projeto_manual');

		// obrigando a seleção de uma bandeira
		$('#codigo_projeto_manual').keypress(function(){
			if($('#bandeira').val() == '')
			{
				$('#bandeira').focus()
				.css('border-color', 'red')
				.tooltip({
			        title: 'selecione uma bandeira!'
			    });
			}
		});

		// variáveis para armazenar valores 
		var bKeyApelido = null;
		var bKeyNome = null;
		var bKeyCodigo = null;

		$('#apelido_projeto, #nome_projeto, #codigo_projeto_manual').blur(function(e)
		{
			e.preventDefault();

			var sBandeira = $("#bandeira").val();
			var sCampoWhere = $(this).attr('id');
			var sValorWhere = $(this).val();

			$.ajax(
			{
		        type: "POST",
		        url: "{{ route('checkProject') }}",
		        data: {'sCampoWhere' : sCampoWhere, 'sValorWhere' : sValorWhere, 'sBandeira' : sBandeira},
		        dataType: 'JSON',
		        success: function(j) 
		        {
		        	// bloqueando ou desbloqueando botão de acordo com o apelido
		        	if (j > 0 && sCampoWhere == 'apelido_projeto' && sValorWhere != $('#hdnApelido').val()) 
		        	{
		        		// seta um valor verdadeira para travar o botão
			        	bKeyApelido = true;
						
						// trava o botão no caso do apelido existir
			        	$('#'+sCampoWhere).focus()
						.css('border-color', 'red')
						.tooltip({
					        title: 'este apelido já existe!'
					    });

						// mostra o alerta de valor repetido
					    $('#'+sCampoWhere).tooltip('show');
		        	}
		        	
		        	if (j < 1 && sCampoWhere == 'apelido_projeto')
		        	{
		        		bKeyApelido = null;
		        		// destrava o campo e destrou o alerta tooltip
		        		$('#'+sCampoWhere).css('border-color', '#ccc');
						$('#'+sCampoWhere).tooltip('destroy');
		        	}

		        	// bloqueando ou desbloqueando botão de acordo com o nome de projeto
		        	if (j > 0 && sCampoWhere == 'nome_projeto' && sValorWhere != $('#hdnNomeProjeto').val()) 
		        	{
						// seta um valor verdadeira para travar o botão
			        	bKeyNome = true;

			        	// trava o botão no caso do nome de projeto existir
			        	$('#'+sCampoWhere).focus()
						.css('border-color', 'red')
						.tooltip({
					        title: 'este nome de projeto já existe!'
					    });

						// mostra o alerta de valor repetido
					    $('#'+sCampoWhere).tooltip('show');
		        	}
		        	
		        	if (j < 1 && sCampoWhere == 'nome_projeto')
		        	{
		        		bKeyNome = null;
		        		// destrava o campo e destrou o alerta tooltip
		        		$('#'+sCampoWhere).css('border-color', '#ccc');
		        		$('#'+sCampoWhere).tooltip('destroy');
		        	}

		        	// bloqueando ou desbloqueando botão de acordo com o código de projeto
		        	if (j > 0 && sCampoWhere == 'codigo_projeto_manual' && sValorWhere != $('#hdnCodProjeto').val()) 
		        	{
						// seta um valor verdadeira para travar o botão
			        	bKeyCodigo = true;

			        	// trava o botão no caso do código de projeto existir
			        	$('#'+sCampoWhere).focus()
						.css('border-color', 'red')
						.tooltip({
					        title: 'este código de projeto com essa bandeira já existe!'
					    });

						// mostra o alerta de valor repetido
					    $('#'+sCampoWhere).tooltip('show');
		        	}
		        	
		        	if (j < 1 && sCampoWhere == 'codigo_projeto_manual')
		        	{
		        		bKeyCodigo = null;
		        		// destrava o campo e destrou o alerta tooltip
		        		$('#'+sCampoWhere).css('border-color', '#ccc');
		        		$('#'+sCampoWhere).tooltip('destroy');
		        	}


					if (bKeyApelido == true || bKeyNome == true || bKeyCodigo == true) 
		        	{
						// trava o botão no caso de não ter selecionado um projeto
			        	$('#btnSubmitFormUpd').prop('disabled', true);
			        	$('#btnSubmitForm').prop('disabled', true);
		        	}
		        	else if ($('#apelido_projeto').is( ":focus" ) || $('#nome_projeto').is( ":focus" ) || $('#codigo_projeto_manual').is( ":focus" )) 
		        	{
		        		// trava o botão no caso de não ter selecionado um projeto
			        	$('#btnSubmitFormUpd').prop('disabled', true);
			        	$('#btnSubmitForm').prop('disabled', true);
		        	}
		        	else
		        	{
		        		// destrava o botão no caso de ter selecionado um projeto
			        	$('#btnSubmitFormUpd').prop('disabled', false);
			        	$('#btnSubmitForm').prop('disabled', false);
		        	}
		        }
			});
		});

	}); // Final do jquery


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
