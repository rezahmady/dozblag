<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\DropzoneRequest;
use TorMorten\Eventy\Facades\Events as Hook;

trait DropzoneTrait
{
    protected function setupDropzoneRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/dropzone-add', [
            'as'        => $routeName . '.dropzone-add',
            'uses'      => $controller . '@dropzoneUpload',
            'operation' => 'dropzoneUpload',
        ]);

        Route::post($segment . '/dropzone-remove', [
            'as'        => $routeName . '.dropzone-remove',
            'uses'      => $controller . '@dropzoneDelete',
            'operation' => 'dropzoneDelete',
        ]);
    }

    public function dropzoneUpload(DropzoneRequest $request)
    {
        $file = $request->file('file');

        try {
            $image = \Image::make($file);
            $filename = $request->slug . '-' . Str::random(4) . '.' . \File::extension($file->getClientOriginalName());
            $file_path =  $request->destination_path . '/' . $filename;

            $big_image = \Image::make($image)->fit($request->image_width, $request->image_height, function ($constraint) {
                $constraint->upsize();
            });

            Hook::action('core-operation-revise', $big_image);

            $big_image->stream();


            \Storage::disk($request->disk)->put($file_path, $big_image->__toString());

            return response()->json([
                'success' => true,
                'filename' => $file_path
            ]);
        } catch (\Exception $e) {
            if (empty($image)) {
                return response('Not a valid image type', 412);
            } else {
                return $e->getMessage();
            }
        }
    }

    public function dropzoneDelete(Request $request)
    {
        try {
            $this->crud->model->where('id', $request->entry)->update([
                $request->field_name => json_encode($request->images ?? NULL)
            ]);

            \Storage::disk($request->disk)->delete([
                $request->destination_path . '/' . $request->image_path,
            ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
