<div  x-data="state()" x-init="init()">
    <!-- Header -->
    <style>
        .modal-alpine {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }

        .product-custom span {
            display: block;
            text-align: center;
            font-size: 20px;
        }

        .product-custom span.price {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 800;
            font-size: 22px;
        }
    </style>
@php
  use Rezahmady\SettingOperation\Setting;
@endphp
    <div class="modal-alpine show" x-show="modal" style="display: flow-root;background-color: rgb(88 88 88 / 50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" x-on:click.away="closeModal()">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="modal_name"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span  x-on:click="closeModal()" aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="checkDiscount">
                        <div class="form-group">
                            <label class="col-form-label" for="recipient-name">کد تخفیف:</label>
                            <div class="container row">
                                <div class=" col-9">
                                    <input class="form-control" wire:model="discount" id="recipient-name" type="text" data-original-title="" title="">
                                </div>
                                <button class="btn btn-primery col-3" type="submit" data-original-title="" title="">اعمال</button>
                            </div>
                            <div class="container pt-1">
                            @error('discount') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <label class="col-form-label">انتخاب درگاه</label>
                        <div class="form-group gateways-holder">
                            @foreach ($gateways as $item)
                                <div class="gateways-logo" x-on:click="setDriver('{{$item}}')" :class="{ 'active': driver === '{{$item}}' }">
                                    <img src="{{asset(Setting::get("transactions.{$item}_logo"))}}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-between" style="background: aliceblue;">
                    <div>هزینه قابل پرداخت : <span x-text="getAmount()"></span></div>
                    <div>
                        <button class="btn btn-success" x-on:click="$wire.payment(modal_id)" type="button" data-original-title="" title="">پرداخت</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:partials.header />
    <!-- /Header -->
    <section class="section home-section-comments" >
        <div class="container position-relative subscribe-page">
            {{-- @can('subscribtion manage') --}}
                <a class="btn btn-setting mb-5"  x-on:click="setwidget('self-page')" style="right:0;" href="{{ url("admin/subscribtion/setting?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
            {{-- @endcan --}}
            <!-- Section Header -->
            <div class="section-header position-relative text-center">
                <h2 class="fw-800">{{Setting::get('subscribtions.title')}}</h2>
                {!! Setting::get('subscribtions.description') !!}
            </div>
            <!-- /Section Header -->

            <div class="row blog-grid-row">
                @foreach ($packages as $item)
                <div class="{{Setting::get('subscribtions.col_class')}}">
                    <div class="card flex-fill bg-cover-09 position-relative">
                        <a class="btn btn-setting mb-5" style="right:0;" href="{{ url("admin/subscribtion/{$item->id}/edit?iframe=true") }}" data-lity ><i class="fa fa-cog" wire:loading.class="loading"></i></a>
                        <div class="card-body pb-5">
                            <h5 class="card-title fw-800">{{$item->name}}</h5>
                            {!! $item->description !!}
                            
                            <div class="product-custom">
                                @if ($item->extras->amount_before_discount)
                                <span class="price-strike">{{number_format($item->extras->amount_before_discount)}} تومان</span>
                                @endif
                                <span class="price">{{number_format($item->amount)}} تومان</span>
                            </div>
                            <a class="apt-btn" href="javascript:void(0);" x-on:click="openModal('{{$item->id}}','{{$item->name}}','{{$item->amount}}')"  data-toggle="modal" data-target="#exampleModalmdo"  tabindex="0">{{Setting::get('subscribtions.button_label')}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>

        


    </section>

    <!-- Footer -->
    <livewire:partials.footer />
    <!-- /Footer -->
    <script>
        function state() {
            return {
                widget: @entangle('widget'),
                driver: @entangle('driver'),
                amount: @entangle('amount'),
                modal: false,
                modal_name: '',
                modal_id: '',
                setwidget(widget) {
                    this.widget = widget;
                },
                setDriver(driver) {
                    this.driver = driver
                },
                getAmount() {
                    return (new Intl.NumberFormat('fa-IR', { maximumSignificantDigits: 3 }).format(this.amount));
                },
                openModal(id,name,price) {
                    this.modal = true;
                    this.modal_id = id;
                    this.modal_name = name;
                    this.amount = price;
                },
                closeModal() {
                    this.modal = false;
                },
                init() {
                    $(document).on('lity:close', function(event, instance) {
                        setTimeout(() => {
                            Livewire.emit('update-widget');
                        }, 1500)
                    });
                },
            }
        }
    </script>
</div>