<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peoples = People::get();
        return view('crud', ['peoples'=> $peoples]);
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
        $peoples = People::get();
        $numberOfRowsInTable = $peoples->count();
        $numberOfRolesStored = $peoples->where('job_role', $request['job_role'])->count();

        $request['numberOfRolesStored'] = $numberOfRolesStored;
        $request['numberOfRowsInTable'] = $numberOfRowsInTable;
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|email|unique:peoples,email',
            'job_role' => 'required|max:50',
            'numberOfRolesStored' => 'required|numeric|max:3',
            'numberOfRowsInTable' => 'required|numeric|max:9'
        ],['numberOfRowsInTable.max' => 'We have reached the maximum of 10 records in table', 'numberOfRolesStored.max' => 'We already have 4 '.$request['job_role'].'s']);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->getMessages()]);
        }

        $person = new People();
        $person->firstname = $request['firstname'];
        $person->lastname = $request['lastname'];
        $person->email = $request['email'];
        $person->job_role = $request['job_role'];
        $person->save();
        return response()->json(['message'=>'Record for '.$request['firstname'].' '.$request['lastname'].' have been successfully stored!']);
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

        $numberOfRolesStored = People::where('job_role', $request['job_role'])->count();

        $numberOfEmailsStored = People::where('email', $request['email'])->count();

        $person = People::find($id);
        if($person->job_role === $request['job_role']){
            $maximumNumberOfRoles = 4;
        } else{
            $maximumNumberOfRoles = 3;
        }

        if($person->email !== $request['email'] and $numberOfEmailsStored >= 1){
            return response()->json(['errors'=>['Another record has the same email address!']]);
        }

        $request['numberOfRolesStored'] = $numberOfRolesStored;
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|email',
            'job_role' => 'required|max:50',
            'numberOfRolesStored' => 'required|numeric|max:'.$maximumNumberOfRoles,
        ],['numberOfRolesStored.max' => 'We already have 4 '.$request['job_role'].'s']);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->getMessages()]);
        }

        $person->firstname = $request['firstname'];
        $person->lastname = $request['lastname'];
        $person->email = $request['email'];
        $person->job_role = $request['job_role'];
        $person->save();
        return response()->json(['message'=>'Record for '.$request['firstname'].' '.$request['lastname'].' have been successfully updated!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = People::find($id);

        if(!$person instanceof People){
            return response()->json(['errors'=>['Record does not exists!']]);
        }

        $personFirstName = $person->firstname;
        $personLastName = $person->lastname;
        $person->delete();
        return response()->json(['message'=>'Record for '.$personFirstName.' '.$personLastName.' have been successfully delete!']);

    }
}
