<div class="{{$class}}" x-data="Gallery()" x-init="modal = false;slideIndex = 1;">
    <div class="gallery-thumb-holder">
        @foreach ($photos as $key => $file)
            @if (is_array($file))
            <div class="gallery-column gallery-thumb">
            <img src="{{asset($file['photo'])}}" style="width:100%" x-on:click="openModal();currentSlide({{$key+1}},'{{$id}}')" class="hover-shadow cursor">
            </div>
            @else
            <div class="gallery-column gallery-thumb">
                <img src="{{asset($file)}}" style="width:100%" x-on:click="openModal();currentSlide({{$key+1}},'{{$id}}')" class="hover-shadow cursor">
            </div>
            @endif
        @endforeach
    </div>
      
    <div x-show="modal" class="gallery-modal">
        <span class="gallery-close cursor" x-on:click="closeModal()">&times;</span>
        <div class="modal-content">
            @foreach ($photos as $key => $file)
                @if (is_array($file))
                <div class="mySlides mySlides{{$id}}">
                    <a href="{{asset($file['photo'])}}" download class="gallery-download"><i class="fa fa-download"></i></a>
                    <div class="numbertext">{{$key+1}} / {{$total}}</div>
                    <img src="{{asset($file['photo'])}}" >
                    <div class="file-detail">
                        <h3>{{$file['title']}}</h3>
                        <p>{{$file['description']}}</p>
                    </div>
                </div>
                @else
                <div class="mySlides mySlides{{$id}}">
                    <a href="{{asset($file)}}" download class="gallery-download"><i class="fa fa-download"></i></a>
                    <div class="numbertext">{{$key+1}} / {{$total}}</div>
                    <img src="{{asset($file)}}" >
                </div>
                @endif
            @endforeach
        
            <a class="gallery-prev" x-on:click="plusSlides(-1,'{{$id}}')">&#10094;</a>
            <a class="gallery-next" x-on:click="plusSlides(1,'{{$id}}')">&#10095;</a>
        

            <div class="files">
                <ul class="list-inline gallery-thumb-holder" tabindex="1">
                    @foreach ($photos as $key => $file)
                    @if (is_array($file))
                        <li class="list-inline-item">
                            <a href="#">
                                <figure class="avatar avatar-lg">
                                    <img class="demo demo{{$id}} cursor" src="{{asset($file['photo'])}}" x-on:click="currentSlide({{$key+1}},'{{$id}}')">
                                </figure>
                            </a>
                        </li>
                    @else
                    <li class="list-inline-item">
                        <a href="#">
                            <figure class="avatar avatar-lg">
                                <img class="demo demo{{$id}} cursor" src="{{asset($file)}}" x-on:click="currentSlide({{$key+1}},'{{$id}}')">
                            </figure>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        
        </div>
    </div>
</div>