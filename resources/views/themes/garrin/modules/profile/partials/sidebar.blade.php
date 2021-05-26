<div class="profile-sidebar card">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                <img src="{{$user->profile}}" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3>{{$user->name ?? ''}}</h3>
                @if (backpack_user()->hasTemplate('doctor'))
                <div class="patient-details">
                    <h5 class="mb-0">{{$user->getSpecilty()}}</h5>
                </div>    
                @endif
            </div>
        </div>
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="">
                    <a href="{{route('profile.dashboard')}}">
                        <i class="fas fa-columns"></i>
                        <span>داشبورد</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('profile.info')}}">
                        <i class="fas fa-user-cog"></i>
                        <span>تنظیمات پروفایل</span>
                    </a>
                </li>
                @if (backpack_user()->hasTemplate('customer'))
                <li>
                    <a href="{{route('profile.medical')}}">
                        <i class="fas fa-user-cog"></i>
                        <span>پرونده پزشکی</span>
                    </a>
                </li>
                @endif
                <li>
                    <a target="_blank" href="{{route('chatyno.index')}}">
                        <i class="fas fa-comments"></i>
                        <span>گفت و گو ها</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="reviews.html">
                        <i class="fas fa-star"></i>
                        <span>نظرات</span>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="schedule-timings.html">
                        <i class="fas fa-hourglass-start"></i>
                        <span>ساعات کاری</span>
                    </a>
                </li>
                <li>
                    <a href="social-media.html">
                        <i class="fas fa-share-alt"></i>
                        <span>شبکه‌های اجتماعی</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{route('auth.logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>خروج</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>
