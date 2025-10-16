<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
class VideoController extends Controller
{

    public function index()
    {
        $videos = Video::latest()->get();
        return view('videos.index', compact('videos'));
    }


    public function create()
    {
        return view('videos.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi'
        ]);


        if (!$request->hasFile('video') || !$request->file('video')->isValid()) {
            return back()->with('error', 'Video file is required and must be valid.');
        }

        $videoFile = $request->file('video');


        $path = $videoFile->store('videos', 'public');

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'original_video' => $path,
        ]);

        $video->convertToHLS();

        return redirect()->back()->with('success', 'Video uploaded and conversion started.');
    }


    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }


    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }


    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $video->update($request->only(['title', 'description']));
        return redirect()->route('videos.index')->with('success', 'Video updated successfully.');
    }


    public function destroy(Video $video)
    {
        if ($video->original_video) {
            Storage::disk('videos')->delete($video->original_video);
        }
        if ($video->hls_output) {
            Storage::disk('hls-outputs')->deleteDirectory($video->hls_output);
            $video->delete();
            return redirect()->route('videos.index')->with('success', 'Video deleted successfully.');
        }
    }

    public function stream(Video $video){
        if($video->hls_output || $video->conversion_percent < 100){
            return redirect()->route('videos.show', $video)->with('error', 'Video is not ready for streaming.');
        }
        $hlsPath = Storage::disk('hls-outputs')->url($video->hls_output . '/playlist.m3u8');
        return view('videos.stream', compact('video', 'hlsPath'));
    }
}
