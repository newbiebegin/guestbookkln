<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use InvalidArgumentException;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use DropdownHelper;
use App\Models\City;
use App\Http\Requests\CityRequest;

class CityController extends Controller
{
	protected $ddnActiveStatus;
	
	public function __construct()
	{
		$this->ddnActiveStatus = DropdownHelper::activeStatus();
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
		
		$query = City::query();
		
		if($request->has('name'))
		{
			$query->where('name', 'LIKE', '%'.$request->name.'%');
		}
	
		if($request->has('code'))
		{
			$query->where('code', 'LIKE', '%'.$request->code.'%');
		}
	
		if($request->has('province_id') && $request->province_id != Null)
		{
			$query->where('province_id', $request->province_id);
		}
		
		if($request->has('is_active') && $request->is_active != Null)
		{
			$query->where('is_active', $request->is_active);
		}
		
		$cities = $query->paginate(50);
		
		return view(
            'admin.city.list',
            [
                'cities' => $cities,
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
                        'title' => 'Create a city', 
                        'menuTitle' => 'City',
                        'action' => route('admin.cities.store', ['city' => Null]),
                        'action_label' => 'Create',
                    );
                    
		return view('admin.city.form', 
                        [
                            'city' => Null,
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
    public function store(CityRequest $request)
    {
        //
		$validatedData = $request->safe()->all();
		
		DB::beginTransaction();
		
		try{
			
			$city = new City();
			$city->code = $request['code'];
			$city->name = $request['name'];
			$city->is_active = $request['is_active'];
			$city->created_by = Auth::id();
			$city->save();
			
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
		
		$city->fresh();
				
		return redirect()->route('admin.cities.index')->with('success','Data Added Successfully.');
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
		$city = City::find($id);
		
		if(!$city){
			return back()->withErrors('City not found')->withInput();
		}

		$template = array(
						'title' => 'Edit a city : '.$city->name ?? '', 
						'menuTitle' => 'City',
						'action' => route('admin.cities.update', ['city' => $id]),
                        'action_label' => 'Update',
					);

		return view('admin.city.form',
			[
				'city' => $city,
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
    public function update(CityRequest $request, $id)
    {
        //
		DB::beginTransaction();
		
		try{
			
			$city = City::find($id);

			if(!$city)
			{
				DB::rollBack();
				return back()->withErrors('City not found')->withInput();
			}

			$city->code = $request['code'];
			$city->name = $request['name'];
			$city->is_active = $request['is_active'];
			$city->updated_by = Auth::id();
			$city->update();
			
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
		
		$city->fresh();

		return redirect()->route('admin.cities.index')->with('success','Data Updated Successfully.');
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
			
			$city = City::find($id);

			if(!$city)
			{
				DB::rollBack();
				return back()->withErrors('City not found')->withInput();
			}

			$city->is_active = 2;
			$city->updated_by = Auth::id();
			$city->update();
			
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
		
		$city->fresh();

		return redirect()->route('admin.cities.index')->with('success','Data Deleted Successfully.');
    }
	
	public function import()
	{
		try {
			$res = Http::get('https://d.kapanlaginetwork.com/banner/test/city.json');	
		} catch (\Exception $e) {
           return back()->withErrors($e->getMessage())->withInput();
        }

        if ( $res->status() == 401) {
			return back()->withErrors('Error Authentication, Please Contact Our Admin')->withInput();
        } else if (! $res->successful()) {
		   return back()->withErrors('Error, Please Contact Our Admin')->withInput();
        }

		DB::beginTransaction();
		
		$i=1;
		
		try{
			foreach($res->json() as $val)
			{
				$checkCity = City::where('code',  $val['kode'])
									->orWhere('name', $val['nama'])->count();
				if($checkCity < 1)
				{
					$city = new City();
					$city->code = $val['kode'];
					$city->name = $val['nama'];
					$city->is_active = 1;
					$city->created_by = Auth::id();
					$city->save();
					$i++;
				}
			}
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
		
		if(isset($city))
		{
			$city->fresh();
		}
		
		return redirect()->route('admin.cities.index')->with('success','Data Added Successfully.');
	}
	
	public function check_name(Request $request)
	{
        $input = $request->only('name');
		$cityId = $request->key;
        $name = $request->name;

        $requestData = [
            'name' => [
				'required',
				Rule::unique('cities')->ignore($cityId ?: null)
            ],
		];
		
		$validator = Validator::make($input, $requestData);
		
		if($validator->fails())
		{
			
			$errors = $validator->errors();
		
			return response()->json(
									array(
										'success' => false,
										'message' => $errors,
									),
									400
								);
		}
			
		return response()->json(
									array(
										'success' => true,
										'message' => 'success',
										'data' => 'ok',
									),
									200
								);
	}
	
	public function check_code(Request $request)
	{
		$input = $request->only('code');
		$cityId = $request->key;
        $code = $request->code;
				
		$requestData = [
           'code' => [
				'required',
				Rule::unique('cities', 'code')->ignore($cityId ?: null, 'id')
			],
		];
		
		$validator = Validator::make($input, $requestData);
		
		if($validator->fails())
		{
			$errors = $validator->errors();
		
			return response()->json(
									array(
										'success' => false,
										'message' => $errors,
									),
									400
								);
		}
			
		return response()->json(
									array(
										'success' => true,
										'message' => 'success',
										'data' => 'ok',
									),
									200
								);
	}
}
