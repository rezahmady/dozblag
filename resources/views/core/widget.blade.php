@can('page update')
<div class="modal-overlay" x-show="isModalOpen" @setwidget.window="setwidget_from_event">
    <div class="modal-iframe-holder">
        <button class="lity-close modal-button-close"  @widgetmodalclose.window="close_modal()" @widgetupdatemodalclose.window="update_widget()" x-on:click="close_modal()" type="button" >×</button>
        <iframe onload='javascript:(function(o){o.style.height=o.contentWindow.document.body.scrollHeight+"px";}(this));' style="height:200px;width:100%;border:none;overflow:hidden;" x-ref="iframe" id="widget-setting-modal"  allowfullscreen allow="autoplay; fullscreen" x-bind:src="url" x-on:click.away="close_modal()" class="modal-iframe"></iframe>
    </div>
    <div x-on:click="close_modal()" data-lity-close=""></div>
</div>

<div class="core-admin-bottom-navigation">
    <div>
        <a class="button" @click="$wire.toggleEdite();$store.theme.set_edit(!editable)">
            <div class="loader-holder" wire:loading.class="d-flex" wire:target="toggleEdite">
                <div class="loader"></div>
            </div>
            <i class="fa fa-pencil-alt"></i><span x-text="editable_lable"></span>
        </a>
        {{-- <a class="button" @click="add_crud = true"><i class="fa fa-plus"></i>
            <div class="options" 
            x-show="add_crud" 
            x-transition.500
            @click.away="add_crud = false"
            @click="add_crud = false">
                <ul>
                    <li>مجله</li>
                    <li>آخرین مطالب</li>
                    <li>تست</li>
                </ul>
            </div>
        </a> --}}
        {{-- <a class="button" @click="widget_hidden_option = true"><i class="fa fa-eye"></i>
        
            <div class="options" 
            x-show="widget_hidden_option" 
            x-transition.500
            @click.away="widget_hidden_option = false"
            @click="widget_hidden_option = false">
                <ul>
                    <li>مجله</li>
                    <li>آخرین مطالب</li>
                    <li>تست</li>
                </ul>
            </div>
        </a> --}}
    </div>
    <div>
        <a href="{{backpack_url()}}" class="button back-to-admin">بازگشت به مدیریت<i class="fa fa-arrow-left"></i> </a>
        <a class="button" href="{{backpack_url('logout')}}" ><i class="fa fa-sign-out-alt"></i></a>
    </div>
    
</div>

@endcan
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('home_state', () => ({
            isModalOpen: false,
            widget: @entangle('widget'),
            editable: @entangle('editable'),
            url: '',
            editable_lable: '',
            widget_hidden_option: false,
            add_crud: false,
            init() {
                this.editable_lable = (this.editable) ? 'اتمام ویرایش' : 'شروع ویرایش';
                this.$store.theme.set_edit(this.editable)
                this.$watch('editable', value => {
                    this.editable_lable = (value) ? 'اتمام ویرایش' : 'شروع ویرایش';
                })
            },
            close_modal() {
                if(this.isModalOpen) {
                    this.isModalOpen = false;
                }
            },
            update_widget() {
                if(this.isModalOpen) {
                    this.isModalOpen = false;
                    Livewire.emit('update-widget');
                    this.url = '';
                }
            },
            setwidget_from_event(event) {
                this.widget = event.detail;
                element = event.target;
                this.url = element.getAttribute('href');
                (this.$refs.iframe).contentWindow.location.reload();
                this.isModalOpen = true;
            },
            setwidget(widget) {
                this.widget = widget;
                element = this.$el;
                this.url = element.getAttribute('href');
                (this.$refs.iframe).contentWindow.location.reload();
                this.isModalOpen = true;
            }
        }))  
    })
</script>