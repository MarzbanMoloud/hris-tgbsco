<?php


namespace App\Http\Controllers;

use App\Image;
use Validator;
use Illuminate\Http\Request;


/**
 * Class UploadFileController
 * @package App\Http\Controllers
 */
class UploadFileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validation->passes()) {
            $image = $request->file('image');

            $fileName = 'image-' . now()->format('d') . '-' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();

            $path = '/upload/profile/' . now()->format('Y-m') . '/';

            $image->move(public_path('/upload/profile/') . now()->format('Y-m') . '/', $fileName);
            $fullPath = $path . $fileName;

            $image = Image::create([
                'title' => 'noname',
                'src' => $fullPath
            ]);

            return response()->json([
                'message'   => 'تصویر با موفقیت ثبت شد',
                'uploaded_image' =>  $fullPath ,
                'color'  => 'green',
                'image_id' => $image->id
            ]);
        }

        return response()->json([
            'message'   => $validation->errors()->first(),
            'uploaded_image' => '',
            'color'  => 'red',
            'image_id' => ''
        ]);
    }
}
