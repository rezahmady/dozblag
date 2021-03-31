<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function save(Page $page, Request $request)
    {

        try {

            $fields = $request->all();

            unset($fields['_token']);
            unset($fields['_method']);
            foreach ($fields as $key => $value) {
                $newKey = Str::replaceFirst('f-', '', $key);
                $fields[$newKey] = $value;
                unset($fields[$key]);
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
    
            return redirect()->back()->with('success', 'اطلاعات وارد شده با موفقیت ثبت شد.');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()->back()->with('error', 'مشکلی در اطلاعات وارد شده رخ داده مجدد تلاش کنید');
        }

    }
}
