<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use App\Http\Controllers\PDFController;

class FacebookController extends Controller
{
    public function postToFacebook(Request $request)
    {

        $fb = new \Facebook\Facebook([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v18.0',
        ]);

        $accessToken = config('services.facebook.client_token');
        
        $message = $request->input('message');
        $description = $request->input('description');
        $link = $request->input('link');
        $image = $request->input('image_url');
        $html_url = $request->input('html_url');

        // Upload the image to Facebook and get media ID
        // $imagePath = $image;//public_path('images/'.$image);
        

        try {
            $mediaId = null;
            $imgData = null;

            $caption = $link ? $message : $message . ' ' . $link;
            if ($image) { 
                if (str_starts_with($image, 'data:image/jpeg;base64')) {
                    $imageContents = file_get_contents($image);
                    $tempImagePath = tempnam(sys_get_temp_dir(), 'fb_image');
                    file_put_contents($tempImagePath, $imageContents);
                    $imgData = [
                        'caption' => $caption,
                        'source' => $fb->fileToUpload($tempImagePath)
                    ];
                } else {
                    $tempImagePath = $image;
                    $imgData = [
                        'caption' => $caption,
                        'url' => $tempImagePath
                    ];
                }
                
                $response = $fb->post('/me/photos', $imgData, $accessToken);
                // $graphNode = $imageResponse->getGraphNode();
                // $mediaId = $imageGraphNode['id'];
            } else if ($html_url) {
                $tempImagePath = PDFController::generateImage($html_url);
                $imgData = [
                    'caption' => $caption,
                    'url' => $tempImagePath
                ];
                $response = $fb->post('/me/photos', $imgData, $accessToken);
            } else {
                $response = $fb->post('/me/feed', [
                    'caption' => $caption,
                    'description' => $description,
                    'link' => $link,
                    // 'attached_media' => [
                    //     ['media_fbid' => $mediaId]
                    // ]
                ], $accessToken);
            }
            
            $graphNode = $response->getGraphNode();

            // Handle the result
            return response()->json([
                'message' => 'Post ID: ' . $graphNode['id']
            ]);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Handle API errors
            return response()->json([
                'message' => 'Graph returned an error: ' . $e->getMessage()
            ]);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK errors
            return response()->json([
                'message' => 'Facebook SDK returned an error: ' . $e->getMessage()
            ]);
        }
    }
}
