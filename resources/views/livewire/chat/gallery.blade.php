<div class="{{$class}}" x-data="Gallery()" x-init="modal = false;slideIndex = 1;">
    <div class="gallery-thumb-holder">
        @foreach ($photos as $key => $photo)
        <div class="gallery-column gallery-thumb">
          <img src="{{asset("/uploads/chat/photo/{$photo}")}}" style="width:100%" x-on:click="openModal();currentSlide({{$key+1}},'{{$id}}')" class="hover-shadow cursor">
        </div>
        @endforeach
    </div>
      
    <div x-show="modal" class="gallery-modal">
        <span class="gallery-close cursor" x-on:click="closeModal()">&times;</span>
        <div class="modal-content">
            @foreach ($photos as $key => $photo)
                <div class="mySlides mySlides{{$id}}">
                    <a href="{{asset("/uploads/chat/photo/{$photo}")}}" download class="gallery-download"><i class="fa fa-download"></i></a>
                    <div class="numbertext">{{$key+1}} / {{$total}}</div>
                    <img src="{{asset("/uploads/chat/photo/{$photo}")}}" >
                </div>
            @endforeach
        
            <a class="gallery-prev" x-on:click="plusSlides(-1,'{{$id}}')">&#10094;</a>
            <a class="gallery-next" x-on:click="plusSlides(1,'{{$id}}')">&#10095;</a>
        

            <div class="files">
                <ul class="list-inline gallery-thumb-holder" tabindex="1">
                    @foreach ($photos as $key => $photo)
                        <li class="list-inline-item">
                            <a href="#">
                                <figure class="avatar avatar-lg">
                                    <img class="demo demo{{$id}} cursor" src="{{asset("/uploads/chat/photo/{$photo}")}}" x-on:click="currentSlide({{$key+1}},'{{$id}}')">
                                </figure>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        
        </div>
    </div>
</div>