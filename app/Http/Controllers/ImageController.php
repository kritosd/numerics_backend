<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the incoming request
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // Get the image data from the request
        $imageData = $request->input('image');
        $name = $request->input('name');

        // Decode the base64-encoded image data
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        // Generate a unique name for the file
        $imageName = $name . '.png';
         // Ensure the 'images' directory exists, create it if not
         $imagesDirectory = public_path('images');
         if (!file_exists($imagesDirectory)) {
             mkdir($imagesDirectory, 0755, true);
         }

        // Move the file to the public/images directory
        file_put_contents($imagesDirectory . '/' . $imageName, $imageData);
        // file_put_contents(public_path('images') . '/' . $imageName, $imageData);

        // You can also store the file path in the database if needed
        // $path = 'images/' . $imageName;

        return response()->json([
            'message' => 'Image uploaded successfully',
            'imgUrl' =>  url('images/' . $imageName)
        ]);
    }
}
