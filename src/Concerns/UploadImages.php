<?php
namespace Sosupp\SlimDashboard\Concerns;

use Livewire\Attributes\Validate;
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
    protected function uploadImage($data, $width = null, $height = null, $subDir = null)
    {

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


}
