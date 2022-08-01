@livewireScripts
@stack('custom-script')

@can('page update')
<div class="modal-overlay" x-show="$store.theme.themeModal">
    <div class="modal-iframe-holder">
        <button class="modal-button-close"  @widgetmodalclose.window="$store.theme.close_modal()" @widgetupdatemodalclose.window="$store.theme.update_widget()" x-on:click="$store.theme.close_modal()" type="button" >×</button>
        <iframe onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight+"px";}(this));' style="height:200px;width:100%;border:none;overflow:hidden;" id="theme-setting-modal"  allowfullscreen allow="autoplay; fullscreen" x-bind:src="$store.theme.url" x-on:click.away="$store.theme.close_modal()" class="modal-iframe"></iframe>
    </div>
    <div x-on:click="close_modal()" data-lity-close=""></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            themeModal: false,
            editable:false,
            url:'',
            set_edit(status) {
                this.editable = status
            },
            openModal(url) {
                console.log(url);
                this.url = url;
                (document.getElementById('theme-setting-modal')).contentWindow.location.reload();
                this.themeModal = true;
            },
            close_modal() {
                if(this.themeModal) {
                    this.themeModal = false;
                }
            },
            update_widget() {
                if(this.themeModal) {
                    this.themeModal = false;
                    Livewire.emit('widget-updated:ThemeSettings');
                    this.url = '';
                }
            },
        })
    })
</script>
@endcan