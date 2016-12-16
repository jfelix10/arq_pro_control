<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',['as' => 'login', 'uses' => 'LoginController@loginHome']);
Route::post('logar',['as' => 'logar', 'uses' => 'LoginController@loginAction']);


// Rotas do sistema quando logado
Route::group(['prefix' => 'sistema'], function()
{
	Route::group(['middleware' => ['guest']], function ()
	{
			Route::any('home',['as' => 'homesistema', 'uses' => 'sistema\SistemaHomeController@home']);
			Route::post('home',['as' => 'postHomesistema', 'uses' => 'sistema\SistemaHomeController@postHome']);
			Route::any('projeto/novo',['as' => 'novoprojeto', 'uses' => 'sistema\SistemaHomeController@novoProjeto']);
			Route::post('projeto/novo',['as' => 'novoprojetoPost', 'uses' => 'sistema\SistemaHomeController@postNovoProjeto']);
			Route::post('projeto/update',['as' => 'updateprojetoPost', 'uses' => 'sistema\SistemaHomeController@postUpdateProjeto']);
			Route::post('projeto/check_project',['as' => 'checkProject', 'uses' => 'sistema\SistemaHomeController@postCheckProject']);
			Route::any('projeto/areas',['as' => 'areasprojeto', 'uses' => 'sistema\SistemaHomeController@areasProjeto']);
			Route::post('projeto/areas',['as' => 'areasprojetoPost', 'uses' => 'sistema\SistemaHomeController@postAreasProjeto']);
			Route::any('projeto/etapas',['as' => 'etapasprojeto', 'uses' => 'sistema\SistemaHomeController@etapasProjeto']);
			Route::post('projeto/etapas',['as' => 'etapasprojetoPost', 'uses' => 'sistema\SistemaHomeController@postEtapasProjeto']);
			Route::post('projeto/visualizacao',['as' => 'visualizacaoProjetoPost', 'uses' => 'sistema\SistemaHomeController@postVisualizacaoProjeto']);
	});
});

Route::group(['prefix' => 'cms'], function()
{
	// Rota para cms
	Route::get('login',['as' => 'cmsLogin', 'uses' => 'cms\CmsController@login']);

	// adicionar usuario
	Route::post('cms_add_usuario',['as' => 'postAddUsuario', 'uses' => 'cms\CmsController@postAddUsuario']);

	// constroi usuario e traz os dados e checkboxes preenchidos ao selecionar um usuario
	Route::post('cms_combo_usuario',['as' => 'postComboUsuario', 'uses' => 'cms\CmsController@postComboUsuario']);
	
	// alterar usuario
	Route::post('cms_alter_usuario',['as' => 'postAlterUsuario', 'uses' => 'cms\CmsController@postAlterUsuario']);

	Route::group(['middleware' => ['guest']], function ()
	{
		// Rota para cms
		Route::any('home',['as' => 'cmsHome', 'uses' => 'cms\CmsController@home']);
	});
});

Route::group(['prefix' => 'cadastro'], function()
{
	Route::group(['middleware' => ['guest']], function ()
	{
		// Rota para cms
		Route::get('nova_senha',['as' => 'novaSenha', 'uses' => 'cadastro\CadastroController@novaSenha']);
		Route::post('nova_senha',['as' => 'novaSenhaPost', 'uses' => 'cadastro\CadastroController@postNovaSenha']);
	});
});