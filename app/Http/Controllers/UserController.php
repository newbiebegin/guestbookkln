<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use InvalidArgumentException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Requests\UpdatePasswordRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
		$data = $request->all();
		$query = User::query();
		
		if($request->has('name'))
		{
			$query->where('name', 'LIKE', '%'.$request->name.'%');
		}
	
		if($request->has('email'))
		{
			$query->where('email', 'LIKE', '%'.$request->email.'%');
		}
		
		$users = $query->paginate(50);
		
		return view(
            'admin.user.list',
            [
                'users' => $users,
                'data' => $data,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$user =  User::find($id);
		
		if(!$user){
			return back()->withErrors('User not found')->withInput();
		}

		$template = array(
						'title' => 'Edit a user : '.$user->name ?? '', 
						'menuTitle' => 'User',
						'action' => route('admin.users.update', ['user' => $id]),
                        'action_label' => 'Update',
					);

		return view('admin.user.form',
			[
				'user' => $user,
        		'template' => $template
			]
		);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordRequest $request, $id)
    {
        //
		DB::beginTransaction();
		
		try{
			
			$user = User::find($id);

			if(!$user)
			{
				DB::rollBack();
				return back()->withErrors('User not found')->withInput();
			}

			$user->password = $request['password'];
			$user->update();
			
		}catch(\Illuminate\Database\QueryException $ex) {
			
			DB::rollBack();
			Log::Info($ex->getMessage());
			return back()->withErrors('Error Query, Please Contact Our Admin')->withInput();
		}catch(\Exception $e){
			
			DB::rollBack();
			Log::Info($e->getMessage());
			return back()->withErrors($e->getMessage())->withInput();
		}
		
		DB::commit();
		
		$user->fresh();

		return redirect()->route('admin.users.index')->with('success','Data Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
