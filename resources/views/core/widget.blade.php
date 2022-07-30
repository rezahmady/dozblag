<div class="modal-overlay" x-show="isModalOpen">
    <div class="modal-iframe-holder">
        <button class="lity-close modal-button-close" x-on:click="isModalOpen = false" type="button" aria-label="Close (Press escape to close)" data-lity-close="">×</button>
        <iframe id="widget-setting-modal" allowfullscreen allow="autoplay; fullscreen" x-bind:src="url" x-on:click.away="isModalOpen = false" class="modal-iframe"></iframe>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('home_state', () => ({
            isModalOpen: false,
            widget: @entangle('widget'),
            url: '',
            setwidget(event) {
                this.widget = event.detail;
                element = event.target;
                this.url = element.getAttribute('href');
                this.isModalOpen = true;
            },
            init() {
                document.addEventListener('widget.modal:close', function(event, instance) {
                    Livewire.emit('update-widget');
                });
            }
        }))
    })
</script>