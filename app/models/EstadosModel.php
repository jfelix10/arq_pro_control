<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class EstadosModel extends Model
{
    // Desabilitando updated_at
	public $timestamps = false;
	
    // Set table name on Database
	protected $table = 'estados';

	public function getEstados()
	{
		// Variavel de retorno
		$aQuery;
		
		$aQuery = $this->select('sigla', 'descricao')->get()->toArray();

		return $aQuery;
	}
}
