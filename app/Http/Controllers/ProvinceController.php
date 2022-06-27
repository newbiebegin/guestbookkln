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
use App\Models\Province;
use App\Http\Requests\ProvinceRequest;

class ProvinceController extends Controller
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
		$query = Province::query();
		
		if($request->has('name'))
		{
			$query->where('name', 'LIKE', '%'.$request->name.'%');
		}
	
		if($request->has('code'))
		{
			$query->where('code', 'LIKE', '%'.$request->code.'%');
		}
		
		if($request->has('is_active') && $request->is_active != Null )
		{
			$query->where('is_active', $request->is_active);
		}
		
		$provinces = $query->paginate(50);
		
		return view(
            'admin.province.list',
            [
                'provinces' => $provinces,
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
                        'title' => 'Create a province', 
                        'menuTitle' => 'Province',
                        'action' => route('admin.provinces.store', ['province' => Null]),
                        'action_label' => 'Create',
                    );
                    
		return view('admin.province.form', 
                        [
                            'province' => Null,
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
    public function store(ProvinceRequest $request)
    {
        //
		$validatedData = $request->safe()->all();
		
		DB::beginTransaction();
		
		try{
			
			$province = new Province();
			$province->code = $request['code'];
			$province->name = $request['name'];
			$province->is_active = $request['is_active'];
			$province->created_by = Auth::id();
			$province->save();
			
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
		
		$province->fresh();
				
		return redirect()->route('admin.provinces.index')->with('success','Data Added Successfully.');
   
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
		$province =  Province::find($id);
		
		if(!$province){
			return back()->withErrors('Province not found')->withInput();
		}

		$template = array(
						'title' => 'Edit a province : '.$province->name ?? '', 
						'menuTitle' => 'Province',
						'action' => route('admin.provinces.update', ['province' => $id]),
                        'action_label' => 'Update',
					);

		return view('admin.province.form',
			[
				'province' => $province,
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
    public function update(ProvinceRequest $request, $id)
    {
        //
		DB::beginTransaction();
		
		try{
			
			$province = Province::find($id);

			if(!$province)
			{
				DB::rollBack();
				return back()->withErrors('Province not found')->withInput();
			}

			$province->code = $request['code'];
			$province->name = $request['name'];
			$province->is_active = $request['is_active'];
			$province->updated_by = Auth::id();
			$province->update();
			
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
		
		$province->fresh();

		return redirect()->route('admin.provinces.index')->with('success','Data Updated Successfully.');
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
			
			$province = Province::find($id);

			if(!$province)
			{
				DB::rollBack();
				return back()->withErrors('Province not found')->withInput();
			}

			$province->is_active = 2;
			$province->updated_by = Auth::id();
			$province->update();
			
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
		
		$province->fresh();

		return redirect()->route('admin.provinces.index')->with('success','Data Deleted Successfully.');
    }
	
	public function import()
	{
		try {
			$res = Http::get('https://d.kapanlaginetwork.com/banner/test/province.json');	
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
				$checkProvince = Province::where('code',  $val['kode'])
									->orWhere('name', $val['nama'])->count();
				if($checkProvince < 1)
				{
					$province = new Province();
					$province->code = $val['kode'];
					$province->name = $val['nama'];
					$province->is_active = 1;
					$province->created_by = Auth::id();
					$province->save();
					$i++;
				}
			}
		}catch(\Illuminate\Database\QueryException $ex) {
			
			DB::rollBack();
			Log::Info($ex->getMessage());
			return back()->withErrors($ex->getMessage())->withInput();
			return back()->withErrors('Error Query, Please Contact Our Admin')->withInput();
		}catch(\Exception $e){
			
			DB::rollBack();
			Log::Info($e->getMessage());
			return back()->withErrors($e->getMessage())->withInput();
		}
		
		DB::commit();	
		
		if(isset($province))
		{
			$province->fresh();
		}
		
		return redirect()->route('admin.provinces.index')->with('success','Data Added Successfully.');
	}
	
	public function check_name(Request $request)
	{
        $input = $request->only('name');
		$provinceId = $request->key;
        $name = $request->name;

        $requestData = [
            'name' => [
				'required',
				Rule::unique('provinces')->ignore($provinceId ?: null)
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
		$provinceId = $request->key;
        $code = $request->code;
				
		$requestData = [
           'code' => [
				'required',
				Rule::unique('provinces', 'code')->ignore($provinceId ?: null, 'id')
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
