@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
  <!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
          <div class="col-sm-6">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
          </div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        @php
            $theme = $crud->getEntries()->where('active',  1)->first();
        @endphp

        @if ($theme)
        <div class="row" >
            <div class="col-sm-4">
                <img class="img-responsive" width="300px" src="{{ url(config('thememanager.assets_folder').$theme->img ?? '/')}}">
            </div>
            <div class="col-sm-8">
                <h3 class="margin-top">
                    {{ $theme->name }}
                </h3>
                <p class="text-gray ln-higher">
                    آخرین بروزرسانی در {{ $theme->updated_at }}<br>
                    دارای {{ $theme->widgets()->count() }} ابزارک | 
                    نسخه : {{ $theme->version }}
                </p>
                <a class="btn btn-xs btn-primary d-none"
                id="filemanager"
                data-elfinder-trigger-url="{{ url(config('elfinder.route.prefix').'/popup/fole#elf_l1_aW1hZ2VzL3BhZ2U') }}"
                >فایل‌ها</a>
                @if ($theme->update)
                <a href="{{ backpack_url("theme/$theme->id/rebuild") }}"  class="btn btn-success btn-xs">به‌روزرسانی</a>
                @endif
                <a href="{{ backpack_url("theme/$theme->id/edit") }}" class="btn btn-default btn-xs">تنظیمات</a>
                <a href="{{ backpack_url('widget') }}" class="btn btn-default btn-xs">ابزارک‌ها</a>
                <a href="{{ backpack_url('menu') }}" class="btn btn-default btn-xs">منو</a>
                <a href="{{ url($crud->route.'/'.$theme->folder.'/activate') }} " class="btn btn-link btn-xs">
                    <span class="text-danger">
                        حذف
                    </span>
                </a>
                @if ($theme->update)
                <div class="d-block mt-3"></div>
                <span class="bg-warning "><i class="la la-flag-o"></i>
                  نسخه جدید {{ $theme->update }} برای {{ $theme->name }} در دسترس می باشد</span>
                @endif
            </div>
            <div class="col-sm-12">
                <hr class="margin-top-xl margin-bottom" >
            </div>
        </div>
        @endif
        <div class="row">            
            @foreach ($crud->getEntries()->where('active',  0) as $entry)
            <div class="col-sm-6 col-lg-4">
                <div class="brand-card">
                  <div class="brand-card-header" style="height:200px;background-size: cover;background-image: url('{{url(config('thememanager.assets_folder').$entry->img ?? '/')}}')"></div>
                  <div class="card-header" style="background: #f9f9f9;">{{ $entry->name }}<span class="badge badge-warning float-right">{{ $entry->version }}</span></div>
                </div>
                <div style="margin-top: -20px;">
                  <div>
                      <a href="{{ url($crud->route.'/'.$entry->folder.'/activate') }} " class="btn btn-xs btn-success"><i class="fa fa-ban"></i> نصب</a>
                  </div>
                </div>
            </div>
            @endforeach
            @if ($crud->getEntries()->where('active',  0)->count() == 0)
            <div class="col-12">
              <p><b class="text-center">قالب دیگری برای انتخاب وجود ندارد</b></p>
            </div>
            @endif
        </div>

          @if ( $crud->buttons()->where('stack', 'bottom')->count() )
          <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
            @include('crud::inc.button_stack', ['stack' => 'bottom'])

            <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
          </div>
          @endif

    </div>

  </div>

@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css').'?v='.config('backpack.base.cachebusting_string') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css').'?v='.config('backpack.base.cachebusting_string') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
  		<!-- include browse server css -->
      <link href="{{ asset('packages/jquery-colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
      <style>
        #cboxContent, #cboxLoadedContent, .cboxIframe {
          background: transparent;
        }
      </style>
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')
  <script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/form.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/list.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')

  <script src="{{ asset('packages/jquery-colorbox/jquery.colorbox-min.js') }}"></script>
  <script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function (element) {

      
      document.querySelector("#filemanager").addEventListener("click", function (event) {
        event.preventDefault();
        // this global variable is used to remember what input to update with the file path
        // because elfinder is actually loaded in an iframe by colorbox
        var elfinderTarget = false;
        var element = $(this);
        // function to update the file selected by elfinder
        function processSelectedFile(filePath, requestingField) {
          elfinderTarget.val(filePath.replace(/\\/g,"/"));
          elfinderTarget = false;
        }

        var triggerUrl = element.data('elfinder-trigger-url')
				var name = 'file';//element.attr('name');

        elfinderTarget = element;

        // trigger the reveal modal with elfinder inside
        $.colorbox({
            href: triggerUrl,
            fastIframe: true,
            iframe: true,
            width: '80%',
            height: '80%'
        });
			
        
      })



    }, false);


    
    
  </script>
@endsection
