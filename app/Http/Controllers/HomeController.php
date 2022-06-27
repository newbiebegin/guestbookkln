<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DropdownHelper;

use App\Models\Province;
use App\Models\City;

class HomeController extends Controller
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
    public function index()
    {
        //
		$template = array(
                        'title' => 'Create a Guestbook', 
                        'menuTitle' => 'Guestbook',
                        'action' => route('admin.guestbooks.store', ['guestbook' => Null]),
                        'action_label' => 'Create',
                    );
					
		
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
