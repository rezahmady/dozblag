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
                <x-chat-rooms />
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
            <x-chat-room :room="$currentRoom" :audience="$audience" :onlineUsers="$onlineUsers" />

            <div x-show="loadingRoom" class="loading-holder">
                <div class="container p-3 empty-chat-holder" >
                    <div  class="empty-chat-img loader-spiner-01"></div>
                </div>
            </div>
        </div>
        <!-- ./ chat -->
        <x-chat-room-sidebar :room="$currentRoom" :audience="$audience" />

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

    function Gallery() {
        return {
            modal: false,
            slideIndex: 1,
            openModal() {
                this.modal = true;
            },
            closeModal() {
                this.modal = false;
            },
            plusSlides(n,m) {
                this.showSlides(this.slideIndex += n,m);
            },
            currentSlide(n,m) {
                this.showSlides(this.slideIndex = n,m);
            },
            showSlides(n,m) {
                var i;
                var slides = document.getElementsByClassName(`mySlides${m}`);
                var dots = document.getElementsByClassName(`demo${m}`);
                if (n > slides.length) {this.slideIndex = 1}
                if (n < 1) {this.slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[this.slideIndex-1].style.display = "block";
                dots[this.slideIndex-1].className += " active";
            }
        }
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