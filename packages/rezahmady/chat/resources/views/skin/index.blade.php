<div class="layout" id="app" x-data="data()">

    <!-- navigation -->
    <nav class="navigation">
        <div class="nav-group">
            <ul>
                <li>
                    <a x-on:click.prevent="set_navigation('chats')" :class="{ 'active': navigation_target == 'chats' }" href="#">
                        <i class="ti-comment-alt"></i>
                    </a>
                </li>
                <li>
                    <a x-on:click.prevent="set_navigation('suggestion')" :class="{ 'active': navigation_target == 'suggestion' }" href="#" >
                        <i class="ti-user"></i>
                    </a>
                </li>
                <li x-on:click.prevent="set_navigation('archives')" :class="{ 'active': navigation_target == 'archives' }" class="brackets">
                    <a href="#">
                        <i class="ti-archive"></i>
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
            <div x-show="navigation_target == 'chats'" :class="{ 'active': navigation_target == 'chats' }" class="sidebar">
                <header>
                    <span>چت ها</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                <x-chat-rooms />
            </div>
            <!-- ./ Chats sidebar -->

            <!-- Friends sidebar -->
            <div x-show="navigation_target == 'suggestion'" :class="{ 'active': navigation_target == 'suggestion' }" class="sidebar">
                <header>
                    <span>پذیرش نشده</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجوی چت">
                </form>
                <x-chat-suggestions />
            </div>
            <!-- ./ Friends sidebar -->

            <!-- Favorites sidebar -->
            <div x-show="navigation_target == 'archives'" :class="{ 'active': navigation_target == 'archives' }" class="sidebar">
                <header>
                    <span>آرشیو</span>
                </header>
                <form action="#">
                    <input type="text" class="form-control" placeholder="جستجو در آرشیو">
                </form>
                <x-chat-archives />
            </div>
            <!-- ./ Stars sidebar -->

        </div>
        <!-- ./ sidebar group -->

        <!-- chat -->
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
            navigation_target: localStorage.getItem("navigation-target") ?? 'chats',
            set_navigation(target) {
                localStorage.setItem("navigation-target", target);
                this.navigation_target = target;
            },
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
            content: '',
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
        setTimeout(function() { document.getElementById("textarea").focus() }, 1000);
        console.log('csrllTo');
    })

    window.addEventListener('scrollToBottom', event => {
        location.href = '#'
        var element = document.getElementById("messages-holder");
        element.scrollIntoView({
            block: "end",
            behavior: "smooth"
        });
        if (document.getElementById("textarea")) {
            setTimeout(function() { document.getElementById("textarea").focus() }, 2000);
        }
        console.log('scrollToBottom');

    })
    document.addEventListener('DOMContentLoaded', function () {
        
        Livewire.hook('component.initialized', (component) => {
            $(document).on('lity:close', function(event, instance) {
                setTimeout(() => {
                    Livewire.emit('edited-rooms')
                }, 1000);
            }); 
        })
    
    })

</script>
