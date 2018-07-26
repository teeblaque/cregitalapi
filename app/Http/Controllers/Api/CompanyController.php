<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Employee;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::paginate(10);
        return response()->json(['data' => $company, 'status' => $this->successStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {

        try{
            $company = new Company();

            $company->name = $request->name;
            $company->email = $request->email;

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $fileName = Str::random(10).'.'.$image->getClientOriginalExtension();
                $location = 'logo/'.$fileName;
                Image::make($image)->save($location);

                $company->logo = $fileName;
            }

            if ($company->save()){
                return response()->json(['data' => $company, 'status' => 201 ]);
            }
            else{
                return response()->json(['status' => 'data not save']);
            }

        }catch (\Exception $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comp = Company::findorFail($id);

        return response()->json(['data' => $comp, 'status' => $this->successStatus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comp = Company::findorFail($id);

        return response()->json(['data' => $comp, 'status' => $this->successStatus]);
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
        try{
            $company = Company::findOrFail($id);

            $company->name = $request->name;
            $company->email = $request->email;

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $fileName = Str::random(10).'.'.$image->getClientOriginalExtension();
                $location = 'logo/'.$fileName;
                Image::make($image)->save($location);

                $company->logo = $fileName;
            }

            if ($company->save())
            {
                return response()->json(['message' => 'updated', 'status' => 200, 'data' => $company]);
            }else{
                return response()->json(['status' => 404, 'message' => 'nothing saved']);
            }
        }catch (\Exception $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comp = Company::find($id);
        $comp->delete();

        return response()->json(null, 204);
    }

    public function employee($id){
        $emp = Employee::with('company')->where('company_id', $id)->get();

        if (count($emp) > 0){
            return response()->json(['status' => 200, 'data' => $emp]);
        }else{
            return response()->json('no data found', 404);
        }
    }
}
