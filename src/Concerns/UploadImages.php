<?php
namespace Sosupp\SlimDashboard\Concerns;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait UploadImages
{
    #[Validate([
        'inlineImages.*' => 'image'
    ])]
    public $inlineImages = [];

    #[Validate([
        'inlineImagesNames.*' => 'filename'
    ])]
    public $inlineImagesNames = [];

    protected $uploadedImagesPath = [];

    // For single image
    protected function uploadImage(
        $data, $width = null, $height = null, $subDir = null,
        $private = false,
    )
    {
        // dd($data['image']);


        if(isset($data['image']) && $data['image'] !== null){
            // $filename = $data['image']->getClientOriginalName();
            $filename = '';

            if(isset($data['filename']) && !empty($data['filename'])){
                $filename = str($data['filename'])->slug()->value();
            }else{
                $originalName = pathinfo($data['image']->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str($originalName)->slug()->value();
            }

            if($private && $subDir){
                return $this->storePrivately(
                    dir: $subDir,
                    file: $data['image'],
                    filename: $filename.'.webp'
                );
            }

            $image = '';
            if($subDir !== null){
                $image = 'images/'.$subDir .'/'.$filename.'.webp';
            } else {
                $image = 'images/'.$filename.'.webp';
            }

            // dd($image);
            Image::read($data['image'])
            // ->resize()
            ->save(
                path: $image,
                quality: 50,
                format: 'webp'
            );

            return $image;
        };

    }

    // For multiple images
    protected function uploadImages(array $data, string $fileType = '.webp')
    {
        if(!empty($data)){
            foreach($data['images'] as $file){
                $filename = '';

                // dd($data['images'], $file['filename'], $file['image'], str()->slug($file['filename']), pathinfo($file['image']->getClientOriginalName(), PATHINFO_FILENAME));
                if(isset($data['filename']) && !empty($data['filename'])){
                    $filename = str($data['filename'])->slug()->value();
                }else{
                    $originalName = pathinfo($data['image']->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = str($originalName)->slug()->value();
                }


                $image = 'images/'.$filename.$fileType;

                Image::read($file['image'])
                // ->resize($width, $height)
                ->save(
                    path: $image,
                    quality: 50,
                    format: 'webp'
                );

                $this->uploadedImagesPath[] = $image;
            }
            return $this->uploadedImagesPath;
        }
    }

    public function uploadInlineImage(array $data, $width = null, $height = null, $subDir = null)
    {

        // dd($data, str()->slug($data['filename']));
        if(isset($data['image']) && $data['image'] !== null){
            // $filename = $data['image']->getClientOriginalName();
            $filename = '';

            if(isset($data['filename']) && !empty($data['filename'])){
                $filename = str($data['filename'])->slug()->value();
            }else{
                $originalName = pathinfo($data['image']->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str($originalName)->slug()->value();
            }

            $image = '';
            if($subDir !== null){
                $image = 'images/'.$subDir .'/'.$filename.'.webp';
            } else {
                $image = 'images/'.$filename.'.webp';
            }

            Image::read($data['image'])
            // ->resize()
            ->save(
                path: $image,
                quality: 50,
                format: 'webp'
            );


            // dd($image);
            return $image;
        };
    }

    private function storePrivately(string $dir, $file, string $filename)
    {
        // dd($dir, $file, $filename);
        // Case 1: If it's an UploadedFile (from request()->file(...))
        if ($file instanceof UploadedFile) {
            return Storage::putFileAs($dir, $file, $filename);
        }

        // Case 2: If it's a valid file path
        if (is_string($file) && file_exists($file)) {
            return Storage::putFileAs($dir, new File($file), $filename);
        }

        // Case 3: If it's raw file contents (string or binary data)
        if (is_string($file)) {
            return Storage::put($dir . '/' . $filename, $file);
        }

        throw new \InvalidArgumentException('Unsupported file type passed to storePrivately');
    }
}
