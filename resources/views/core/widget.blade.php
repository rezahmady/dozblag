<div class="modal-overlay" x-show="isModalOpen">
    <div class="modal-iframe-holder">
        <button class="lity-close modal-button-close"  @widgetmodalclose.window="close_modal()" x-on:click="close_modal()" type="button" >×</button>
        <iframe onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight+"px";}(this));' style="height:200px;width:100%;border:none;overflow:hidden;" x-ref="iframe" id="widget-setting-modal"  allowfullscreen allow="autoplay; fullscreen" x-bind:src="url" x-on:click.away="close_modal()" class="modal-iframe"></iframe>
    </div>
    <div x-on:click="close_modal()" data-lity-close=""></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('home_state', () => ({
            isModalOpen: false,
            widget: @entangle('widget'),
            url: '',
            close_modal() {
                this.isModalOpen = false;
                this.url = '';
                Livewire.emit('update-widget');
            },
            setwidget(event) {
                this.widget = event.detail;
                element = event.target;
                this.url = element.getAttribute('href');
                (this.$refs.iframe).contentWindow.location.reload();
                this.isModalOpen = true;
            }
        }))  
    })
</script>