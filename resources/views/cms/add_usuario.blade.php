@extends('layouts.masterpage')

<style type="text/css">
	.form-transparent 
	{
	    background: none;	    
	}

	.form-transparent .panel-body
	{
	    background: rgba(46, 51, 56, 0.2)!important;
	}

	.vertical-center 
	{
		min-height: 50%;  /* Fallback for browsers do NOT support vh unit */
		min-height: 50vh; /* These two lines are counted as one :-)       */

		display: flex;
		align-items: center;
	}
</style>

@section('content')
<div class="container">
	<div class="col-sm-3 col-md-3"></div>
	<div class="col-sm-6 col-md-6">
		{{ Form::open(array('route' => $actionLogin, 'class' => 'text-center form-transparent')) }}
			<div class="main-login-form panel-body">
				{{ Form::button('inserir novo usuário', ['class' => 'btn btn-info', 'id' => 'change_to_insert']) }}
				{{ Form::button('alterar dados usuário', ['class' => 'btn btn-warning', 'id' => 'change_to_alter']) }}
			</div>
		{{ Form::close() }}
	</div>
</div>


<div class="container vertical-center">
	<div class="col-sm-3 col-md-3"></div>
	<div class="col-sm-6 col-md-6">

		<!-- MENSAGENS DE ALERTA -->
		@if(isset($alertMessage) && !empty($alertMessage))
			<div class="alert alert-{{ $alertType }}">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ $alertMessage }}
			</div>
		@endif

		{{ Form::open(array('route' => $actionLogin, 'class' => 'text-left form-transparent', 'id' => 'formDados')) }}
			<!-- hidden que indica tipo de ação do form para alterar ou resetar senha -->
			<input type="hidden" name="actMudarResetar" id="actMudarResetar" value="">

			<div class="login-form-main-message"></div>
			<div class="main-login-form panel-body">
			<legend>inserir novo usuário</legend>
				<div class="login-group">
					<!-- div que recebe o combo de usuarios cadastrados do ajax -->
					<div class="form-group" id="comboUsuariosHidden"></div>
					<div class="form-group">
						<label style='font-size:15px; color: #2E2825'>nome</label>
						{{ Form::text('nome_usuario', '', ['class' => 'form-control', 'placeholder' => 'nome do usuário']) }}
					</div>
					<div class="form-group">
						<label style='font-size:15px; color: #2E2825'>e-mail</label>
						{{ Form::text('email_usuario', '', ['class' => 'form-control', 'placeholder' => 'e-mail do usuário']) }}
					</div>

					<!-- div que recebe html de combo do status -->
					<div class="form-group" id="comboStatusUsuario"></div>

					<!-- div que recebe o combo de status do usuario -->
					<div class="form-group" id="comboSatusHidden"></div>

					<div class="form-group" id="cbSistemas">
						@foreach($aSiemasChaveValor as $key => $value)
							<div class="checkbox">
							  <label><input type="checkbox" name="arr_sistemas[{{ $key }}]">{{ $value }}</label>
							</div>
						@endforeach
					</div>
				</div>
				<hr />
				<div class="form-inline">
					<div class="form-group">
						<button type="submit" class="btn btn-success" id='btnSubmitForm'>adicionar usuário</button>
					</div>	
						
					<div class="form-group">
						<!-- div que recebe  -->
						<div id="btnResetSenha"></div>
					</div>	
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop

@section('script')
	<script>
		$(document).ready(function(){
			// alterando o formulário para adicionar o usuário (estado natural do form)
			$('#change_to_insert').click(function(e){
				e.preventDefault();
				$('#formDados').attr('action', '');
				$('#formDados').attr('method', '');
				window.location.replace('{{ route("cmsHome") }}');
			});

			// alterando o formulário para alterar o usuário
			$('#change_to_alter').click(function(e){
				e.preventDefault();

				// mudando nome do botão
				$('#btnSubmitForm').html('alterar usuário');

				// removendo conjunto de checkboxes fixo
				var hHtml = '';
				$( "#cbSistemas" ).html(hHtml);

				// atribuindo rota de alteração para o form 
				$('#formDados').attr('action', "{{ route('postAlterUsuario') }}");

				// atribuindo valor ao hidden para indicar a controller que a ação será de alteração de dados
				$('#actMudarResetar').attr('value', "alter");

				$.ajax({
			        type: "POST",
			        url: "{{ route('postComboUsuario') }}",
			        dataType: 'JSON',
			        success: function(j) 
			        {
			        	// variavel que vai armazenar o html formado pelo foreach
			        	var html;

			        	// compondo o html de combo
			        	html = "<label style='font-size:15px; color: #2E2825'>usuários cadastrados</label>";
			        	html += "<select name='iUsuarioAlter' id='iUsuarioAlter' class='form-control' onChange='preencheCampos(this)'>";
			        	// html += "<select name='iUsuarioAlter' id='iUsuarioAlter' class='form-control'>";
			        	html += "<option value=''>selecione um usuário</option>";
			        	// looping que forma as opções de valores 
			        	$.each(j, function(val, str)
			        	{
			        		html += "<option value='" + val + "'>" + str + "</option>";
			        	});
			        	html += "<select>";

			        	// integrando o html contruido na div receptora
			        	$('#comboUsuariosHidden').html(html);

			        	// reler elementos da pagina
						$(document).ready();
			        }
			    });
			});

			// Declarando uma função jquery para ser chamada em javascript clique resetar senha
			$.fn.rstSenha = function() 
			{

				// atribuindo valor ao hidden para indicar a controller que a ação será de alteração de dados
				$('#actMudarResetar').attr('value', "resetSenha");
				
				// Submetendo o formulário
				$('#formDados').submit();
			}

			// Declarando uma função jquery para ser chamada em javascript
			$.fn.fillDados = function(val) 
			{ 
			    // alert(val);
			    $.ajax({
			        type: "POST",
			        url: "{{ route('postAlterUsuario') }}",
			        data: {'val' : val},
			        dataType: 'JSON',
			        success: function(j) 
			        {
			        	// incluindo botão de resetar senha
			        	var htmlBtnReset = "<button type='button' class='btn btn-danger' id='resetSenha' onClick='resetSenhaJs()'>resetar senha</button>";

			        	// atribuindo html de botão resetar senha
			        	$('#btnResetSenha').html(htmlBtnReset);

			        	// preenchendo nome e email com a resposta json
			        	$('input[name=nome_usuario]').val(j.usuario);
			        	$('input[name=email_usuario]').val(j.email);

			        	// variavel que vai armazenar o html formado pelo foreach
			        	var html;

			        	// compondo o html de combo
			    		html = "<div class='checkbox'>";

			        	// looping que forma as opções de valores 
			        	$.each(j.sistema, function(val, str)
			        	{
			        		// variavel que armazena atributo checked
			        		var sIsCheck = " ";

			        		// quebrando o valor para verificar se o checkbox deve ser checado ou não
			        		// e o nome do sistema
			        		$aResposta = str.split("||");

			        		if ($aResposta[1] == 'check') 
			        		{
			        			sIsCheck = "checked = 'checked'";
			        		}

							html += "<label><input type='checkbox' name='arr_sistemas["+val+"]' "+sIsCheck+">"+$aResposta[0]+"</label><br />";
			        	});

						html += "</div>";

			        	// integrando o html contruido na div receptora
			        	$('#cbSistemas').html(html);

			        	// compondo combo de status do usuário
			        	htmlComboStatus = "<label style='font-size:15px; color: #2E2825'>status do usuário</label>";
			        	htmlComboStatus += "<select name='iUsuarioStatus' id='iUsuarioStatus' class='form-control'>";

			        	if (j.status_usuario == 1) 
			        	{
							htmlComboStatus += "<option value='1' selected>ativo</option>";
							htmlComboStatus += "<option value='0'>inativo</option>";
			        	}
			        	else
			        	{
			        		htmlComboStatus += "<option value='1'>ativo</option>";
							htmlComboStatus += "<option value='0' selected>inativo</option>";	
			        	}

						htmlComboStatus += "<select>";

						// atribuindo html de combo de status
			        	$('#comboStatusUsuario').html(htmlComboStatus);

			        	// reler elementos da pagina
						$(document).ready();
			        }
			    });
			};

		}); //FIM DO AUTOLOAD JQUERY

		// function para preencher campos
		function preencheCampos(val)
		{
			$.fn.fillDados(val.value);
		}

		// function para resetar senha
		function resetSenhaJs()
		{
			$.fn.rstSenha();
		}
		
	</script>
@stop
