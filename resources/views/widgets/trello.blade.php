<style>
    
    .board {
      overflow-x: scroll;
      white-space: nowrap;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background: #cd5a91;
      font-family: IRANSans;
    }
  
    .list-wrapper { 
      width: 20rem; 
      background-color: #eee;
      margin: .5em;
      border-radius: 3px;
      box-sizing: border-box;
      display: inline-block;
      vertical-align: top;
    }
   
    .list {
      background-color: #eee;
      border: none;
      padding: .5em;
      margin-bottom: 2em;
      box-sizing: border-box;
      font-family: IRANSans;
    }
  
    .list-header {
      height: 3em;
      line-height: 3em;
      padding: 0 1em;
    }
   
    .list-title {
      font-weight: bold;
    }
    .card {
        box-sizing: border-box;
        position: relative;
        width: 100%;
        min-height: 4em;
        padding: 1em;
        border-radius: 3px;
        margin-bottom: .5em;
        background: #fff;
    }
    .pull-left {
        float: left;
    }
    /* .card-edit {
        display: block;
        box-sizing: border-box;
        position: relative;
        width: 100%;
        min-height: 4em;
        padding: 1em;
        border-radius: 3px;
        margin-bottom: .5em;
        background: #fff;
        font-size: 1em;
        border: none;
    } */

    .card-edit-controls {
        margin-bottom: .5em;
    }

    .card-controls {
        position: absolute;
        left: .5em;
        top: .5em;
        display: none;
    }

    .card:hover .card-controls{
        display: inline-block;
    }

    .k-add-button, .k-edit-button, .k-delete-button {
        cursor: pointer;
    }

    /* new style */

    .board {
        background: none;
        border: 0px;   
    }

    .list-wrapper {
        background-color: #f1f4f8;
        border-left: 1px solid #e7eaee;
    }

    .list {
        background-color: #f1f4f8;
    }
    .card-default {
        box-sizing: border-box;
        position: relative;
        width: 100%;
        padding: 0;
        border-radius: 3px;
        margin-bottom: .5em;
        background: #f1f4f8;
        box-shadow: none;
        border-style: dashed;
        text-align: center;
        font-size: 30px;
        font-weight: 800;
        color: #d4dbe6;
    }

    .k-edit-item {
        padding: 10px;
        background: #eceff3;
        margin-bottom: 10px;
    }
</style>
  
<div class="board"></div>


 

@push('after_scripts')
<script src="https://kendo.cdn.telerik.com/2018.3.911/js/kendo.all.min.js"></script>

<!-- INITIALIZATION -->
<script>
    jQuery(document).ready(function($) {
        
        
        
        $('.board').kendoListView({
            template: kendo.template($('#listTemplate').html()),
            dataSource: [
                {listID: 0, name: 'جدید'},
                {listID: 1, name: 'اختصاص یافته'},
                {listID: 2, name: 'درجریان'},
                {listID: 3, name: 'تبدیل شده'},
                {listID: 4, name: 'مجدد فعال شده'},
                {listID: 5, name: 'از دست رفته'}
            ]
        });

        $('#list-0').kendoListView({
            template: kendo.template($('#cardTemplate').html()),
            editTemplate: kendo.template($('#cardEditTemplate').html()),
            dataSource: [
                { cardID: 0, name: 'شرکت کاریناپارس', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'},
                { cardID: 1, name: 'شرکت کاریناپارس', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'},
                { cardID: 2, name: 'شرکت کاریناپارس', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'},
                { cardID: 3, name: 'شرکت کاریناپارس', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'},
                { cardID: 4, name: 'شرکت کاریناپارس', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'}
            ]
        });

        $('#list-1').kendoListView({
            template: kendo.template($('#cardTemplate').html()),
            editTemplate: kendo.template($('#cardEditTemplate').html()),
            dataSource: [
                { cardID: 1, name: 'شهرایده‌آل', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg'  },
                { cardID: 2, name: 'پارسکدر', company: 'نام حساب', image: 'https://carinapars.com/portal/assets/img/logo/40429c7941cc11590f83e9a76e333aa63459b16d.jpg' }
            ]
        });

        $('#list-2').kendoListView({
            template: kendo.template($('#cardTemplate').html()),
            editTemplate: kendo.template($('#cardEditTemplate').html())
        });
        

        // sortable
        var sortableOptions = {
            filter: '.card',
            container: '.board',
            connectWith: '.list',
            cursor: 'grabbing',
            placeholder: function(element){
                return $('<div class="card"></div>').css({
                    background: '#eceff3',
                    border: '1px solid rgb(231, 234, 238)',
                    boxShadow: 'none'
                });
            },
            hint: function(element) {
                return element.clone().css({
                    width: '15em',
                    transform: 'rotate(-5deg)',
                    border: '1px solid #eee'
                });
            }
        };

        $('#list-0').kendoSortable(sortableOptions);
        $('#list-1').kendoSortable(sortableOptions);
        $('#list-2').kendoSortable(sortableOptions);
        $('#list-3').kendoSortable(sortableOptions);
        $('#list-4').kendoSortable(sortableOptions);
        $('#list-5').kendoSortable(sortableOptions);

        // Activating the Add Button
        $('.k-add-button').click(function(e){
            var list = $(e.target).closest('.list-wrapper').find('.list');
            var listID = '#' + $(list).prop('id');
            var listView = $(listID).data('kendoListView');
            listView.add();
        });

        $('.select2').select2();

    });
</script>
<!-- LIST TEMPLATE -->
<script id="listTemplate" type="text/x-kendo-template">
    <div class="list-wrapper">
        <div class="list-header">
                         
        <span class="list-title">#: name #</span>
        <div class="pull-left">
            <span class="k-add-button k-icon k-i-add"></span>
        </div> 
        </div>
        <div id="list-#: listID #" class="list">
        </div>
    </div>
</script>

<!-- CARD TEMPLATE -->
<script id="cardTemplate" type="text/x-kendo-template">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="#= image #">
            </div>
            <div class="col-md-8">
                <p>#= name #</p>
                <small>#= company #</small>
                <div class="card-controls">
                <span class="k-edit-button k-icon k-i-edit"></span>
                <span class="k-delete-button k-icon k-i-close"></span>
              
            </div>
        </div>
        
        </div>
    </div>
</script>

<script id="cardEditTemplate" type="text/x-kendo-template">
    <div>
        <div class="form-group">
            <input class="card-edit form-control" name="name" data-bind="value:name" required="required">
        </div>

        <div class="form-group">
            <select class="form-control select2" name="company" data-bind="value:company">
                <option value="نام حساب" >نام حساب</option>
                <option value="شرکت دوم" >شرکت دوم</option>
            </select>
        </div>

        <div class="card-edit-controls">
        <button class="k-update-button k-button">
            <span class="k-icon k-i-check"></span> ذخیره
        </button>
        </div>
    </div>
</script>

  
  
  
<script>
    
 </script>
@endpush