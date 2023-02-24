<?php

namespace App\Http\Controllers;

use App\Models\Lyric;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class LyricController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $song = Lyric::find(2)->song;
        // return response()->json($song);
        $lyrics = Lyric::with('song')->get();
        return $lyrics->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'dashbord';
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
            'title'  => 'required|min:2',
            'content' => 'required',
            'song_ID' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $input = $request->all();
        Lyric::create($input);
        return 'creation sucss';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lyr = Lyric::findOrFail($id);
        if (is_null($lyr)) {
            return $this->returnError('E016', 'Somthing not correct for this EDIT lyric please try again!');
        }
        
        return $lyr->toJson();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prd = Lyric::findOrFail($id);
        if (is_null($prd)) {
            return $this->returnError('E016', 'Somthing not correct for this EDIT lyric please try again!');
        }
        return $prd->toJson();
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
        $lyric = Lyric::find($id);
        if (is_null($lyric)) {
            return $this->returnError('E016', 'Somthing not correct for this update lyric please try again!');
        }
        $lyric->update($request->all());
        return $this->returnData("lyric", $lyric, "lyric update with success", "");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lyric = Lyric::find($id);
        if (is_null($lyric)) {
            return $this->returnError('E013', 'deleted failed!');
        }
        $lyric->delete();
        return $this->returnError('E013', 'Deleted Success');
    }
       
    
}
