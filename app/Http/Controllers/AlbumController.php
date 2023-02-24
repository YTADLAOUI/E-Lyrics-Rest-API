<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

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
        // $musics = Album::find(1)->musics;
        $albums = Album::with('song')->orderBy('id')->get();

        $this->returnData('albums', $albums, "Success", '');
        // return response()->json([
        //     'status' => 'success',
        //     'albums' => $albums
        // ]);
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
    public function store(StoreAlbumRequest $request)
    {
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
    public function update(StoreAlbumRequest $request, Album $album)
    {
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
