<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp = Employee::with('company')->paginate(10);
        return response()->json(['data' => $emp, 'status' => $this->successStatus], $this->successStatus);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try{
            $emp = new Employee();

            $emp->firstname = $request->firstname;
            $emp->lastname = $request->lastname;
            $emp->company_id = $request->company_id;
            $emp->email = $request->email;
            $emp->phone = $request->phone;

            if ($emp->save())
            {
                return response()->json(['message' => 'saved successfully', 'status' => 201, 'data' => $emp]);
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
        if ($id != null){
            $emp = Employee::with('company')->where('id', $id)->get();

            if (count($emp) > 0){
                return response()->json(['data' => $emp, 'status' => $this->successStatus]);
            }
            else{
                return response()->json(['status' => 401, 'message' => 'no data']);
            }
        }
        else{
            return response()->json(['status' => 400, 'message' => 'id cannot be null']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id != null){
            $emp = Employee::with('company')->where('id', $id)->get();

            if (count($emp) > 0){
                return response()->json(['data' => $emp, 'status' => $this->successStatus]);
            }
            else{
                return response()->json(['status' => 401, 'message' => 'no data']);
            }
        }
        else{
            return response()->json(['status' => 400, 'message' => 'id cannot be null']);
        }
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
            if ($id != null)
            {
                $emp = Employee::findOrFail($id);

                $emp->firstname = $request->firstname;
                $emp->lastname = $request->lastname;
                $emp->company_id = $request->company_id;
                $emp->email = $request->email;
                $emp->phone = $request->phone;

                if ($emp->save()){
                    return response()->json(['message' => 'updated successfully', 'status' => 200, 'data' => $emp]);
                }

            }else{
                return response()->json(['status' => 404, 'message' => 'data not saved']);
            }

        }catch (\Exception $exception)
        {
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
        $emp = Employee::find($id);
        $emp->delete();

        return response()->json(null, 204);
    }

    public function company($id)
    {
        $company = Company::where('id', $id)->get();

        if (count($company) > 0){
            return response()->json(['status' => 200, 'data' => $company]);
        }else{
            return response()->json('no data found', 404);
        }
    }
}
