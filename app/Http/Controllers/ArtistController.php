<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;

class ArtistController extends Controller
{
    // trait to generate Error and success message
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist = Artist::with('song')->get();
        if (is_null($artist)) {
            return $this->returnError('E021', 'Not found any data!');
        }
        return response()->json($artist, 200);
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
        $rules = [
            'name'  => 'required|min:2'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $create = Artist::create($request->all());
        if (is_null($create)) {
            return $this->returnError('E020', 'Somthing not correct for this create artist please try again!');
        }
        return response()->json($create, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::find($id);
        if (is_null($artist)) {
            return $this->returnError('E019', 'Artist not found!');
        }
        return response()->json($artist, 200);
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
        $artist = Artist::find($id);
        if (is_null($artist)) {
            return $this->returnError('E016', 'Somthing not correct for this update artist please try again!');
        }
        $artist->update($request->all());
       return $this->returnData("Artist",$artist,"Artist update with success","");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = Artist::find($id);
        if (is_null($artist)) {
            return $this->returnError('E013', 'deleted failed!');
        }
        $artist->delete();
        return $this->returnError('E013', 'Deleted Success');
    }
}
