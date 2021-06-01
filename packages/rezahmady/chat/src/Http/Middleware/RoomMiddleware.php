<?php

namespace Rezahmady\Chat\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rezahmady\Chat\Models\Room;

class RoomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->id and Room::where(DB::raw('md5(id)') , $request->id)->first()) {
            if(backpack_user()->template == 'customer') {
                if(Room::where(DB::raw('md5(id)') , $request->id)->first()->user_id == backpack_user()->id ) {
                    return $next($request);
                }
            } elseif(backpack_user()->template == 'doctor') {
                if(Room::where(DB::raw('md5(id)') , $request->id)->first()->doctor_id == backpack_user()->id ) {
                    return $next($request);
                }
            } elseif(backpack_user()->template == 'operator') {
                if(backpack_user()->can('chat join')) {
                    return $next($request);
                } elseif(Room::where(DB::raw('md5(id)') , $request->id)->first()->operator_id == backpack_user()->id ) {
                    return $next($request);
                }
            }
        }
        return redirect()->to(route('chatyno.index'));
    }
}
