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
<div class="container vertical-center">
	<div class="col-sm-4 col-md-4"></div>
	<div class="col-sm-4 col-md-4">
		<div class="alert alert-info" id="alertas">
			<p>Ou é seu primeiro acesso, ou você esqueceu sua senha e ela foi deletada... De qualquer forma confirme a senha que acabou de digitar na tela anterior!</p>
		</div>
		{{ Form::open(array('route' => $actionLogin, 'class' => 'text-left form-transparent', 'id' => 'formNovaSenha')) }}
			<div class="login-form-main-message"></div>
			<div class="main-login-form panel-body">
				<div class="login-group">
					<div class="form-group">
						<label style='font-size:15px; color: gray'>e-mail</label>
						{{ Form::text('email', $aDadosNovaSenha['email'], ['class' => 'form-control', 'readonly' => 'readonly']) }}
					</div>
					<div class="form-group">
						<label style='font-size:15px; color: gray'>senha</label>
						<input type="password" name="senha_nova" id="senha_nova" class="form-control" value="{{$aDadosNovaSenha['senha_nova']}}" placeholder="senha" readonly="readonly">
					</div>
					<div class="form-group">
						<label style='font-size:15px; color: gray'>confirma senha</label>
						{{ Form::password('confirma_senha', array('class' => 'form-control', 'id' => 'confirma_senha','placeholder' => 'confirma senha')) }}
					</div>
				</div>
				<button type="submit" class="btn btn-success">cadastrar</button>
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop

@section('script')
<script>
	$(document).ready(function(){
		$('.btn').click(function(e){
			e.preventDefault();
			if ($('#confirma_senha').val() == '') 
			{
				var htmlMsg = '<p>preencha a confirmação da senha conforme senha digitada anteriormente.</p>';
				$('#alertas').html(htmlMsg);
				$('#confirma_senha').focus();
				return false;
			}
			else
			{
				if ($('#senha_nova').val() == $('#confirma_senha').val()) 
				{
					var htmlMsg = '<p>senha cadastrada com sucesso!</p>';
					$('#alertas').attr('class', 'alert alert-success');
					$('#alertas').html(htmlMsg);

					setTimeout(function(){
					  $('#formNovaSenha').submit();
					}, 2100);
				}
				else
				{
					var htmlMsg = '<p>Você não confirmou a senha corretamente! Tente novamente e caso tenha esquecido a senha digitada anteiormente pressione "F5" no seu teclado e tente de novo.</p>';
					$('#alertas').attr('class', 'alert alert-danger');
					$('#alertas').html(htmlMsg);
					$('#confirma_senha').focus();
				}
			}

		});
	});
</script>
@stop
