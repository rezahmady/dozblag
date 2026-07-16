<html>
    
    <style>
        
        @media print {
            html, body {
                width: {{$page_width}}mm;
                height: {{$page_height}}mm;
            }

            .pagebreak {
                page-break-after: always;
            }

            @page {
                size: '{{$paper_size}}';
                margin: 0;
            }
        }

        .front_page, .back_page {
            position: relative;
            width: 100%;
            height: 100%;
            display: block;
            padding: 0;
            margin: 0;
        }

        .field {
            position: absolute;
            top: auto;
            right: auto;
        }
        

        .bold {
            font-weight: 700;
        }

    </style>
    <body>

    <div class="front_page">
        @foreach($front_fields as $field)
    
            <span class="field @if($field['bold'] === '1') bold @endif" style="bottom:{{$field['y_mm']}}mm;left:{{$field['x_mm']}}mm;font-size:{{$field['font_size'] ?? 14}};width:{{$field['width']}}">{!! $field['value'] !!}</span>
    
        @endforeach
    </div>


    @if(sizeof($back_fields))

        <div class="pagebreak"></div>
        <div class="back_page">

            @foreach($back_fields as $field)

                <span class="field @if($field['bold'] === '1') bold @endif" style="bottom:{{$field['y_mm']}}mm;left:{{$field['x_mm']}}mm;font-size:{{$field['font_size'] ?? 14}};width:{{$field['width']}}">{!! $field['value'] !!}</span>
   
            @endforeach

        </div>


    @endif


        
    </body>


<script>
    
    window.print();

    window.onafterprint = function () {
        $('.printpage', window.parent.document).hide();
    }
</script>
</html>