<?php

namespace Sosupp\SlimDashboard\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Sosupp\SlimDashboard\Http\Controllers\Controller;


class EditorImageUploadAdapterController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('upload')){
            $filename = pathinfo($request->file('upload')->getClientOriginalName(), PATHINFO_FILENAME);

            $user = auth()->user()->id ?? random_int(2,4);
            $image = 'images/'.$filename . '-' .  $user .'.webp';

            Image::make($request->file('upload'))
            ->save(
                path: $image,
                quality: 50,
                format: 'webp'
            );

            // $filepath = $request->file('upload')->move('images', $filename);

            // $url = asset($filepath);
            $url = asset($image);

            return response()
            ->json([
                'filename' => $image,
                'uploaded' => 1,
                'url' => $url,
            ]);
        }

    }
}

