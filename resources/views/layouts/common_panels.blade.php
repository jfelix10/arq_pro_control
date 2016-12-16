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
		min-height: 45%;  /* Fallback for browsers do NOT support vh unit */
		min-height: 45vh; /* These two lines are counted as one :-)       */

		display: flex;
		align-items: center;
	}
</style>

@section('content')

@yield('btnChange')

<div class="container vertical-center">
	<div class="col-sm-1 col-md-1"></div>
	<div class="col-sm-10 col-md-10">

		<!-- MENSAGENS DE ALERTA -->
		@if(isset($alertMessage) && !empty($alertMessage))
			<div class="alert alert-{{ $alertType }}">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ $alertMessage }}
			</div>
		@endif
	
		<!-- RECEBE OS FORMS -->
		@yield('form')
		
	</div>
</div>
@stop
