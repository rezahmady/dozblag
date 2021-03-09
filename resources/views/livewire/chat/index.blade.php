<div class="layout" id="app" x-data="data()">

    <!-- navigation -->
    <nav class="navigation">
        <div class="nav-group">
            <ul>
                <li>
                    <a data-navigation-target="chats" class="active" href="#">
                        <i class="ti-comment-alt"></i>
                    </a>
                </li>
                <li>
                    <a data-navigation-target="friends" href="#" class="notifiy_badge">
                        <i class="ti-user"></i>
                    </a>
                </li>
                <li data-navigation-target="favorites" class="brackets">
                    <a href="#">
                        <i class="ti-star"></i>
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#editProfileModal">
                        <i class="ti-pencil"></i>
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#settingModal">
                        <i class="ti-settings"></i>
                    </a>
                </li>
                <li>
                    <a href="login.html">
                        <i class="ti-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ./ navigation -->

    <!-- content -->
    <div class="content">

        <!-- sidebar group -->
        <div class="sidebar-group">

            <!-- Chats sidebar -->
            <div id="chats" class="sidebar active">
                <header>
                    <span>چت ها</span>
                    <ul class="list-inline">
                        {{-- <li class="list-inline-item" data-toggle="tooltip" title="گروه جدید" >
                            <a class="" href="#" data-toggle="modal" data-target="#newGroup">
                                <i class="fa fa-users"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-light" data-toggle="tooltip" title="چت جدید" href="#" data-navigation-target="friends">
                                <i class="ti-comment-alt"></i>
                            </a>
                        </li>
                        <li class="list-inline-item d-lg-none d-sm-block">
                            <a href="#" class="btn btn-light sidebar-close">
                                <i class="ti-close"></i>
                            </a>
                        </li> --}}
                    </ul>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                {{-- <livewire:chat.rooms /> --}}
                <x-rooms />
            </div>
            <!-- ./ Chats sidebar -->

            <!-- Friends sidebar -->
            <div id="friends" class="sidebar">
                <header>
                    <span>دوستان</span>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="btn btn-light" href="#" data-toggle="modal" data-target="#addFriends">
                                <i class="ti-plus btn-icon"></i> افزودن دوست
                            </a>
                        </li>
                        <li class="list-inline-item d-lg-none d-sm-block">
                            <a href="#" class="btn btn-light sidebar-close">
                                <i class="ti-close"></i>
                            </a>
                        </li>
                    </ul>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                <livewire:chat.suggestions />
            </div>
            <!-- ./ Friends sidebar -->

            <!-- Favorites sidebar -->
            <div id="favorites" class="sidebar">
                <header>
                    <span>موارد دلخواه</span>
                    <ul class="list-inline">
                        <li class="list-inline-item d-lg-none d-sm-block">
                            <a href="#" class="btn btn-light sidebar-close">
                                <i class="ti-close"></i>
                            </a>
                        </li>
                    </ul>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی موارد دلخواه">
                </form>
                <div class="sidebar-body">
                    <ul class="list-group list-group-flush users-list">
                        <li class="list-group-item">
                            <div class="users-list-body">
                                <h5>جسیکا</h5>
                                <p>می دانم این پرونده برای شما چقدر مهم است. تو میتوانی به من اعتماد کنی ؛)</p>
                                <div class="users-list-action action-toggle">
                                    <div class="dropdown">
                                        <a data-toggle="dropdown" href="#">
                                            <i class="ti-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">نمایش چت</a>
                                            <a href="#" class="dropdown-item">ارسال</a>
                                            <a href="#" class="dropdown-item">حذف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="users-list-body">
                                <h5>جعفر عباسی</h5>
                                <p>اختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                                <div class="users-list-action action-toggle">
                                    <div class="dropdown">
                                        <a data-toggle="dropdown" href="#">
                                            <i class="ti-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">نمایش چت</a>
                                            <a href="#" class="dropdown-item">ارسال</a>
                                            <a href="#" class="dropdown-item">حذف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="users-list-body">
                                <h5>طاهر نصیری</h5>
                                <p>اختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                                <div class="users-list-action action-toggle">
                                    <div class="dropdown">
                                        <a data-toggle="dropdown" href="#">
                                            <i class="ti-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">نمایش چت</a>
                                            <a href="#" class="dropdown-item">ارسال</a>
                                            <a href="#" class="dropdown-item">حذف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="users-list-body">
                                <h5>جعفر</h5>
                                <p>اختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                                <div class="users-list-action action-toggle">
                                    <div class="dropdown">
                                        <a data-toggle="dropdown" href="#">
                                            <i class="ti-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">نمایش چت</a>
                                            <a href="#" class="dropdown-item">ارسال</a>
                                            <a href="#" class="dropdown-item">حذف</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ./ Stars sidebar -->

        </div>
        <!-- ./ sidebar group -->

        <!-- chat -->
        {{-- <livewire:chat.room :room="$currentRoom" /> --}}
        <div class="chat position-relative" >
            <x-room :room="$currentRoom" :audience="$audience" :onlineUsers="$onlineUsers" />

            <div x-show="loadingRoom" class="loading-holder">
                <div class="container p-3 empty-chat-holder" >
                    <div  class="empty-chat-img loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- ./ chat -->

        <div class="sidebar-group">
            <div id="contact-information" class="sidebar">
                <header>
                    <span>درباره</span>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#" class="btn btn-light sidebar-close">
                                <i class="ti-close"></i>
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="sidebar-body">
                    <div class="pl-4 pr-4 text-center">
                        <figure class="avatar avatar-state-danger avatar-xl mb-4">
                            <img src="/packages/chatino/media/img/women_avatar5.jpg" class="rounded-circle">
                        </figure>
                        <h5 class="text-primary">طاهر نصیری</h5>
                        <p class="text-muted">آخرین بازدید: دیروز</p>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>درباره</h6>
                        <p class="text-muted">من عاشق خواندن ، مسافرت و کشف چیزهای جدید هستم. شما باید در زندگی شاد باشید.</p>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>تلفن</h6>
                        <p class="text-muted">(555) 555 55 55</p>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>رسانه</h6>
                        <div class="files">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                        <span class="avatar-title bg-warning">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </span>
                                        </figure>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                            <img src="/packages/chatino/media/img/women_avatar1.jpg">
                                        </figure>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                            <img src="/packages/chatino/media/img/women_avatar3.jpg">
                                        </figure>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                            <img src="/packages/chatino/media/img/women_avatar4.jpg">
                                        </figure>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                        <span class="avatar-title bg-success">
                                            <i class="fa fa-file-excel-o"></i>
                                        </span>
                                        </figure>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <figure class="avatar avatar-lg">
                                        <span class="avatar-title bg-info">
                                            <i class="fa fa-file-text-o"></i>
                                        </span>
                                        </figure>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>شهر</h6>
                        <p class="text-muted">آلمان / برلین</p>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>وب سایت</h6>
                        <p>
                            <a href="#">www.franshanscombe.com</a>
                        </p>
                    </div>
                    <hr>
                    <div class="pl-4 pr-4">
                        <h6>لینک اجتماعی</h6>
                        <ul class="list-inline social-links">
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-dribbble">
                                    <i class="fa fa-dribbble"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-whatsapp">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-google">
                                    <i class="fa fa-google"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-behance">
                                    <i class="fa fa-behance"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-sm btn-floating btn-instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>
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
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ./ content -->

</div>

<script>
    function data() {
        return {
            loadingRoom: @entangle('loadingRoom'),
            currentRoom: @entangle('currentRoom'),
            setRoom() {
                this.loadingRoom = true;
            },
            hiddenLoader() {
                this.loadingRoom = false;
            },
        }
    }

    function CreateMessage() {
        return {
            voice_holder: false,
            buttons_holder: false,
            open_voice() {
                this.buttons_holder = false;
                this.voice_holder = true;
            },
            close_voice() {
                this.voice_holder = false;
            },
            open_buttons() {
                this.buttons_holder = true;
            },
            close_buttons() {
                this.buttons_holder = false;
            },
            toggle_buttons() {
                this.buttons_holder = ! this.buttons_holder;
            }
        }
    }
    
    function autosize(div,ta) {
        setTimeout(function() {
            ta.style.cssText = 'height:0px';
            var height = Math.min(20 * 5, ta.scrollHeight);
            var height_holder = (height < 65) ? 65 : height;
            div.style.cssText = 'height:' + height_holder + 'px';
            ta.style.cssText = 'height:' + height + 'px';
        },0);
    }


    window.addEventListener('scrollTo', event => {
        location.href = '#'+event.detail.hash;
        document.getElementById("textarea").focus();
    })

    window.addEventListener('scrollToBottom', event => {
        var element = document.getElementById("messages-holder");
        element.scrollIntoView({
            block: "end",
            behavior: "smooth"
        });
        document.getElementById("textarea").focus();
    })

    // Echo.join('chat')
    //     .here((users) => {
    //         console.log(users);
    //         window.Livewire.emit('setUsersHere', users)
    //     })
    //     .joining((user) => {
    //         window.Livewire.emit('setUserJoining', user)
    //     })
    //     .leaving((user) => {
    //         window.Livewire.emit('setUserLeaving', user)
    //     });
   

</script>

<script>
    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }
    
    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }
    
    var slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      var captionText = document.getElementById("caption");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
      captionText.innerHTML = dots[slideIndex-1].alt;
    }
    </script>