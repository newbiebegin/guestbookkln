<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

use Hash;
use Session;

use DB;
use Log;
use Exception;
use InvalidArgumentException;


use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    //
	public function index()
    {
        return view('admin.auth.login');
    }  
		
	public function login(LoginRequest $request)
    {
        $credentials =  $request->validated();
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withErrors('You have entered invalid credentials');
    }
			
    public function registration()
    {
        return view('admin.auth.registration');
    }
	
	public function register(RegisterRequest $request)
    {  
        $data = $request->validated();
        $user = User::create($data);

        auth()->login($user);
		
		return redirect('dashboard')->with('success', "Account successfully registered.");
    }
	
	public function logout()
	{
		Session::flush();
        Auth::logout();

        return redirect('/');
	}
	
	public function dashboard()
	{
	   $template = array(
                        'title' => 'Dashboard', 
                        'menuTitle' => 'Dashboard',
                    );
                    
		return view('admin.auth.dashboard', 
                        [
                            'template' => $template
                        ]);
	}
	
	public function changePasswordForm()
	{
		return view('admin.auth.change_password');
	}
	
	public function changePassword(ChangePasswordRequest $request)
	{
		$data = $request->validated();
        
		DB::beginTransaction();
		
		try{
			$id = Auth::id();
			$user = User::find($id);

			if(!$user)
			{
				DB::rollBack();
				return back()->withErrors('User not found')->withInput();
			}

			$user->password = $request['new_password'];
			$user->update();
			
		}catch(\Illuminate\Database\QueryException $ex) {
			
			DB::rollBack();
			Log::Info($ex->getMessage());
			// return back()->withErrors('Error Query, Please Contact Our Admin')->withInput();
			return back()->withErrors($ex->getMessage())->withInput();
		}catch(\Exception $e){
			
			DB::rollBack();
			Log::Info($e->getMessage());
			return back()->withErrors($e->getMessage())->withInput();
		}
		
		DB::commit();
		
		$user->fresh();
		
		return redirect()->route('home')->with('success','Password changed successfully.');
	}
	
}
