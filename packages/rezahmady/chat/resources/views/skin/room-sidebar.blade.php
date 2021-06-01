@if ($room)
<div class="sidebar-group info" x-show="profile" >
    <div id="contact-information" class="sidebar">
        <header>
            <span>درباره</span>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" x-on:click.prevent="profileClose()" class="btn btn-light sidebar-close">
                        <i class="ti-close"></i>
                    </a>
                </li>
            </ul>
        </header>
        <div class="sidebar-body">
            <div class="pl-4 pr-4 text-center">
                <figure class="avatar avatar-xl mb-4">
                    <img src="{{$audience->getProfile()}}" class="rounded-circle">
                </figure>
                <h5 class="text-primary">{{$audience->name}}</h5>
            </div>
            <hr>
            
            <div class="pl-4 pr-4 mb-3">
                <h6>رسانه</h6>
                <x-chat-gallery :photos="$photos" :id="'About'" :class="'files'" />
            </div>
            <div class="pl-4 pr-4 mb-3">
                <h6>پرونده پزشکی</h6>
                <x-chat-gallery :photos="$medical_folder" :id="'medical_folder'" :class="'files'" />
            </div>
            
            {{-- <hr>
            <div class="pl-4 pr-4">
                <div class="form-group">
                    <div class="form-item custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch11">
                        <label class="custom-control-label" for="customSwitch11">بلاک</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-item custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" checked="" id="customSwitch12">
                        <label class="custom-control-label" for="customSwitch12">سایلنت</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-item custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch13">
                        <label class="custom-control-label" for="customSwitch13">دریافت اعلان</label>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endif