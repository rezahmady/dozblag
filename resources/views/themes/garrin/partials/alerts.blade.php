{{-- Bootstrap Notifications using Prologue Alerts & PNotify JS --}}
<script>
  document.addEventListener("turbolinks:load", function() {
      const flash_message_element = document.querySelector(".noty_layout")
      if (flash_message_element) {
          flash_message_element.remove()
      }
      @foreach (\Alert::getMessages() as $type => $messages)
      
          @foreach ($messages as $message)

          new Noty({
              type: "{{ $type }}",
              text: "{!! str_replace('"', "'", $message) !!}"
          }).show();

          @endforeach
      @endforeach
  });
</script>