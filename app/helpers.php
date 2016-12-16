<?php

// namespace App\Http\helpers;


/*
** classe helpers com funções commons
*/
class Helpers
{

	/*
    ** Metodo para construção de array com chava contendo um valor determinado e não aleatório
    ** e um valor correspondente também definido
    * @$sKey - coluna do banco para chave
    * @$sValue - coluna do banco para valor
    */
    public function makeArrayKeyValeu($aQuery, $sKey = null, $sValue = null, $sFirstValue = null)
    {
    	// variável de retorno
    	$aArray = [];
        $aArray[''] = $sFirstValue;
        foreach ($aQuery as $key => $value) 
        {
        	$aArray[$value[$sKey]] = $value[$sValue];
        }
        // dd($aArray);
        return $aArray;
    }
}
