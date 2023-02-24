<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class albumController extends Controller
{
    // use trait to handle error and success
    use GeneralTrait;

    public function __construct()
    {
        // $this->middleware('');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $songs = Album::find(2)->song;
        $albums = Album::with('song')->orderBy('id')->get();
        // $this->returnData('albums', $albums, "Success", '');
        return response()->json([
            'status' => 'success',
            'albums' => $albums
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

        $rules = [
            'name'  => 'required|min:2',
            'release_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); // 400 means bad request
        }

        $album = Album::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Album Created successfully!",
            'album' => $album
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        $album->find($album->id);
        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }
        return response()->json($album, 200);
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
    public function update(Request $request, Album $album)
    {
        $rules = [
            'name'  => 'required|min:2',
            'release_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); // 400 means bad request
        }

        $album->update($request->all());

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Album Updated successfully!",
            'album' => $album
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $album->delete();

        if (!$album) {
            return response()->json([
                'message' => 'Album not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Album deleted successfully'
        ], 200);
    }
}
