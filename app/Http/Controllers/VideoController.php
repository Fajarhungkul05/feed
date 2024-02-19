<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(4);
        return view('vidio.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vidio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,jpeg,png,jpg,gif|max:10048',
        ]);

        $user = auth()->user();
        $video = new Video;

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoName = time() . '.' . $videoFile->getClientOriginalExtension();
            $destinationPath = 'video/';
            $videoFile->move($destinationPath, $videoName);
            $video->video = $videoName;
        }

        $video->created_by = $user->id;
        $video->caption = $request->caption;
        $video->save();

        return redirect()->route('vidio.index')->with('success', 'Video berhasil diunggah!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        try {
            $video->delete();
            return redirect()->route('vidio.index')->with('success', 'Video berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Video: ' . $e->getMessage());
        }
    }  
}
