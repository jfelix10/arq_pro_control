<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SistemaModel extends Model
{
    // Desabilitando updated_at
	public $timestamps = false;
	
    // Set table name on Database
	protected $table = 'sistema';

	public function getSistemas()
	{
		// Variavel de retorno
		$aQuery;
		
		$aQuery = $this->select('id_sistema', 'nome_sistema')->get()->toArray();

		return $aQuery;
	}
}
