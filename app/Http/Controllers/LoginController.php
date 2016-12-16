<?php

namespace App\Http\Controllers;

use Request;

use Session;

use Auth;

use App\Http\Requests;

class LoginController extends Controller
{
    /**
	 * Classe de login
	 *
	 * @package  LoginController
	 * @author   João Felix - volverine.felix@gmail.com
	 */

    public function loginHome()
    {
        // destruindo a sessão sempre que for logar novamente
        // Session::flush(Request::session()->get('usuario'));
        // Session::destroy( Request::session()->get('usuario') );
        Session::set('usuario', null);
        Session::save();

        // action do form
        $actionLogin = 'sistema/home';
        // titulo do login
        $loginTitle = 'sistema';

        $alertMessage = '';

        $alertType = '';

        // Capturando valores vindo da controller cms caso exista este redirecionamento
        if(!empty(Request::all()))
        {
            // action do form
            $actionLogin = Request::all()['actionLogin'];
            // titulo do login
            $loginTitle = Request::all()['loginTitle'];

            // action do form
            $alertMessage = Request::all()['alertMessage'];
            // titulo do login
            $alertType = Request::all()['alertType'];
        }

        return view('login/login', ['actionLogin' => $actionLogin
                                 , 'loginTitle' => $loginTitle
                                 , 'alertMessage' => $alertMessage
                                 , 'alertType' => $alertType]);
    } 

    public function loginAction()
    {
    	return redirect()->action('sistema\SistemaHomeController@home');
    }
}
