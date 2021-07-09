<?php

namespace Rezahmady\Page\Http\Controllers;

use App\Models\Message;
use Rezahmady\Page\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Operator\NewForm;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function save(Page $page, Request $request)
    {

        try {

            $fields = $request->all();

            // $request->validate([
            //     'file' => 'mimes:jpg,jpeg,png,gif|max:5048'
            // ]);

            unset($fields['_token']);
            unset($fields['_method']);
            foreach ($fields as $key => $value) {
                $newKey = Str::replaceFirst('f-', '', $key);
                $fields[$newKey] = $value;
                unset($fields[$key]);
            }

            // ddd($request->file());

            if($request->file()) {
                foreach($request->file() as $name => $file) {
                    $fileName = time().'_'.$file->getClientOriginalName();
                    Storage::disk('local')->put('/uploads/form/'.$fileName, file_get_contents($file));
                    $newName = Str::replaceFirst('f-', '', $name);
                    $fields[$newName] = '/uploads/form/'.$fileName;
                }
            }
            
            $newMessage = new Message();
            $newMessage->extras = json_encode([
                'fields' => $fields,
                'user' => [
                    'ip' => $request->ip()
                ]
            ]);
            $newMessage->subject = $page->name;
            $newMessage->type = 'form';
            $newMessage->status = 0;
            $newMessage->form_id = $page->id;
    
            $newMessage->save();

            // operator
            User::where('template', 'operator')->where('extras->telegram_user_id', '!=', null)->get()->each(function($user) use($newMessage) {
                if($user->can('page create form')) {
                    $user->notify(new NewForm($newMessage));
                }
            });
    
            return redirect()->back()->with('success', 'اطلاعات وارد شده با موفقیت ثبت شد.');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()->back()->with('error', 'مشکلی در اطلاعات وارد شده رخ داده مجدد تلاش کنید');
        }

    }
}
