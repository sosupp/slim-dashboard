<?php

namespace Sosupp\SlimDashboard\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Sosupp\SlimDashboard\Http\Controllers\Controller;


class EditorImageUploadAdapterController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('image')){
            $filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);

            $user = auth()->user()->id ?? random_int(2,4);
            $image = 'images/'.$filename . '-' .  $user .'.webp';

            Image::read($request->file('image'))
            ->save(
                path: $image,
                quality: 50,
                format: 'webp'
            );

            // $filepath = $request->file('image')->move('images', $filename);

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

