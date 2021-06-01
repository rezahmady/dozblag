<div>
    @php
        use Rezahmady\SettingOperation\Setting;
    @endphp
    <div class="card" style="background: #f8f9fa;">
        <div class="card-header">
            بات اطلاع رسانی
        </div>
        <div class="card-body">
            <p class="card-text">برای دریافت اطلاع رسانی های گرین لطفا از طریق لینک زیر در<strong> بات تلگرامی اطلاع رسان</strong> عضو شوید</p>
            <a href="{{Setting::get('messages.telegram_link')}}" class="btn btn-info " style="float: left;">پیوستن به بات</a>
        </div>
    </div>

    @if ($user->hasTemplate('customer'))
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="background: slategrey;color: white;">
                <div class="card-body">
                  <h5 class="card-title" style="
                  color: blanchedalmond;
              ">پرونده پزشکی</h5>
                  <p class="card-text">ما برای پاسخ گویی بهتر به مشکلات و سوالات شما نیاز به اطلاعاتی در زمینه سابقه درمانی و مدارک پزشکی شما داریم.</p>
                  <p class="card-text">می توانید از اینجا مدارک پزشکی خود را بارگزاری کنید</p>
                  <a href="{{route('profile.medical')}}" class="card-link" style="
                  color: aqua;
              ">تکمیل پرونده پزشکی</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card" style="background: #907090;color: white;">
                <div class="card-body">
                  <h5 class="card-title" style="
                  color: blanchedalmond;
              ">مشاوره</h5>
                  <p class="card-text">برای دریافت مشاوره از هر یک از متخصصان مجموعه گرین کافیست پس انتخاب متخصص مورد نظر پلن متناسب با نیاز خود را انتخاب و فعال نمایید</p>
                  
                  <a href="{{route('doctor.list')}}" class="card-link" style="
                  color: aqua;
              ">دریافت مشاوره</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if ($user->hasTemplate('doctor'))
    {{-- <x-rezahmady.profile.doctor-counter-widget />
    <x-rezahmady.profile.doctor-patients-widget /> --}}
    @endif
</div>
