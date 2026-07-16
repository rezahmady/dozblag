<div class="card">
    <div class="card-header">گزارش به تفکیک نوع مجوز</div>
    <div class="card-body p-0">
    <table class="table table-responsive-sm table-striped mb-0">
        <thead class="thead-light">
        <tr>
            <th>کشور</th>
            <th class="text-center">دریافتی</th>
            <th>موجودی</th>
            <th class="text-center">لاشه باز</th>
            <th class="text-center">لاشه تحویلی</th>
            <th class="text-center">ابطالی</th>
        </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            @php  
                $percent = $item->available_traficpermits_count/$item->qty*100;
                $color = ($percent > 50) ? 'success' : (($percent > 20) ? 'warning' : 'danger'); 
            @endphp
                <tr>
                    <td class="text-right">
                        <div>{{$item->country->fa_name}}</div>
                        <div class="small text-muted"><span>{{$item->getYear()}} | </span>{{$item->types_label}}</div>
                    </td>
                    <td>
                        <div>{{$item->qty}}</div>
                    </td>
                    <td>
                        <div class="clearfix">
                            <div class="float-left"><strong>{{$item->available_traficpermits_count }} عدد</strong></div>
                            <div class="float-right"><small class="text-muted">{{$percent}}%</small></div>
                        </div>
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-{{$color}}" role="progressbar" style="width: {{$percent}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>{{$item->issued_traficpermits_count}}</div>
                    </td>
                    <td  class="text-center">
                        <div>{{$item->consumed_traficpermits_count}}</div>
                    <td class="text-center">
                        <div>{{$item->revoke_traficpermits_count}}</div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>