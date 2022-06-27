<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use InvalidArgumentException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use DropdownHelper;
use App\Models\Guestbook;
use App\Models\Province;
use App\Models\City;
use App\Http\Requests\GuestbookRequest;

class GuestbookController extends Controller
{
	protected $ddnActiveStatus;
	protected $ddnProvince;
	protected $ddnCities;
	
	public function __construct()
	{
		$this->ddnActiveStatus = DropdownHelper::activeStatus();
		
		$this->ddnProvinces = Province::select('name', 'id')->where('is_active', 1)->get();
		$this->ddnCities = City::select('name', 'id')->where('is_active', 1)->get();
		
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //		
		$data = $request->all();
		$query = Guestbook::query();
		
		if($request->has('first_name'))
		{
			$query->where('first_name', 'LIKE', '%'.$request->first_name.'%');
		}
	
		if($request->has('last_name'))
		{
			$query->where('last_name', 'LIKE', '%'.$request->last_name.'%');
		}
	
		if($request->has('organization'))
		{
			$query->where('organization', 'LIKE', '%'.$request->organization.'%');
		}
			
		if($request->has('province_id') && $request->province_id != Null)
		{
			$query->where('province_id', $request->province_id);
		}
		
		if($request->has('city_id') && $request->city_id != Null)
		{
			$query->where('city_id', $request->city_id);
		}
		
		if($request->has('is_active') && $request->is_active != Null)
		{
			$query->where('is_active', $request->is_active);
		}
		
		$guestbooks = $query->paginate(50);
		
		return view(
            'admin.guestbook.list',
            [
                'guestbooks' => $guestbooks,
				'ddnProvinces' => $this->ddnProvinces,
                'ddnCities' => $this->ddnCities,
                'ddnActiveStatus' => $this->ddnActiveStatus,
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
		$template = array(
                        'title' => 'Create a Guestbook', 
                        'menuTitle' => 'Guestbook',
                        'action' => route('admin.guestbooks.store', ['guestbook' => Null]),
                        'action_label' => 'Create',
                    );
					
		if (!Auth::check()) {
			
			$template['action'] = route('send.guestbook', ['guestbook' => Null]);
			
			return view('home.home', 
                        [
                            'guestbook' => Null,
                            'ddnProvinces' => $this->ddnProvinces,
                            'ddnCities' => $this->ddnCities,
                            'ddnActiveStatus' => $this->ddnActiveStatus,
                            'template' => $template
                        ]);
		}
		
		
		return view('admin.guestbook.form', 
                        [
                            'guestbook' => Null,
                            'ddnProvinces' => $this->ddnProvinces,
                            'ddnCities' => $this->ddnCities,
                            'ddnActiveStatus' => $this->ddnActiveStatus,
                            'template' => $template
                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestbookRequest $request)
    {
        //
		$validatedData = $request->safe()->all();
		
		DB::beginTransaction();
		
		try{
			
			$guestbook = new Guestbook();
			$guestbook->first_name = $request['first_name'];
			$guestbook->last_name = $request['last_name'];
			$guestbook->organization = $request['organization'];
			$guestbook->address = $request['address'];
			$guestbook->province_id = $request['province_id'];
			$guestbook->city_id = $request['city_id'];
			$guestbook->phone = $request['phone'];
			$guestbook->message = $request['message'];
			$guestbook->is_active = Auth::check() ? $request['is_active'] : 1;
			$guestbook->created_by = Auth::check() ? Auth::id() : Null;
			$guestbook->save();
			
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
		
		$guestbook->fresh();
		
		if (!Auth::check()) {
			return redirect()->route('home')->with('success','Data Added Successfully.');
		}
				
		return redirect()->route('admin.guestbooks.index')->with('success','Data Added Successfully.');
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
		$guestbook =  Guestbook::find($id);
		
		if(!$guestbook){
			return back()->withErrors('Guestbook not found')->withInput();
		}

		$template = array(
						'title' => 'Edit a guestbook : '.$guestbook->name ?? '', 
						'menuTitle' => 'Guestbook',
						'action' => route('admin.guestbooks.update', ['guestbook' => $id]),
                        'action_label' => 'Update',
					);

		return view('admin.guestbook.form',
			[
				'guestbook' => $guestbook,
				'ddnProvinces' => $this->ddnProvinces,
                'ddnCities' => $this->ddnCities,
				'ddnActiveStatus' => $this->ddnActiveStatus,
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
    public function update(GuestbookRequest $request, $id)
    {
        //
		DB::beginTransaction();
		
		try{
			
			$guestbook = Guestbook::find($id);

			if(!$guestbook)
			{
				DB::rollBack();
				return back()->withErrors('Guestbook not found')->withInput();
			}

			$guestbook->first_name = $request['first_name'];
			$guestbook->last_name = $request['last_name'];
			$guestbook->organization = $request['organization'];
			$guestbook->address = $request['address'];
			$guestbook->province_id = $request['province_id'];
			$guestbook->city_id = $request['city_id'];
			$guestbook->phone = $request['phone'];
			$guestbook->message = $request['message'];
			$guestbook->is_active = $request['is_active'];
			$guestbook->updated_by = Auth::id();
			$guestbook->update();
			
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
		
		$guestbook->fresh();

		return redirect()->route('admin.guestbooks.index')->with('success','Data Updated Successfully.');
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
		DB::beginTransaction();
		
		try{
			
			$guestbook = Guestbook::find($id);

			if(!$guestbook)
			{
				DB::rollBack();
				return back()->withErrors('Guestbook not found')->withInput();
			}

			$guestbook->is_active = 2;
			$guestbook->updated_by = Auth::id();
			$guestbook->update();
			
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
		
		$guestbook->fresh();

		return redirect()->route('admin.guestbooks.index')->with('success','Data Deleted Successfully.');
    }
}
