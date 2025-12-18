<?php

namespace Modules\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Media\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::paginate(10);
        return view('media::index', compact('media'));
    }

    public function create()
    {
        return view('media::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_name' => 'required|string',
            'disk' => 'required|string',
            'size' => 'required|integer',
        ]);

        // Убираем поля model_type и model_id, они будут автоматически заполнены при использовании morphs
        $data = $request->only(['name', 'file_name', 'disk', 'size']);

        $media = Media::create($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media created successfully');
    }

    public function edit(Media $media)
    {
        return view('media::edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_name' => 'required|string',
            'disk' => 'required|string',
            'size' => 'required|integer',
        ]);

        $media->update($request->only(['name', 'file_name', 'disk', 'size']));

        return redirect()->route('admin.media.index')
            ->with('success', 'Media updated successfully');
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully');
    }
}
