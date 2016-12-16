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
		@if(!empty($alertMessage))
			<div class="alert alert-{{ $alertType }}">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ $alertMessage }}
			</div>
		@endif

		@if($loginTitle)
			<legend>{{ $loginTitle }}</legend>
		@endif

		{{ Form::open(array('url' => $actionLogin, 'class' => 'text-left form-transparent')) }}
			<div class="login-form-main-message"></div>
			<div class="main-login-form panel-body">
				<div class="login-group">
					<div class="form-group">
						<label style='font-size:15px; color: gray'>e-mail</label>
						<input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="e-mail">
					</div>
					<div class="form-group">
						<label style='font-size:15px; color: gray'>senha</label>
						<input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="senha">
					</div>
				</div>
				<button type="submit" class="btn btn-success">entrar</button>
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop
