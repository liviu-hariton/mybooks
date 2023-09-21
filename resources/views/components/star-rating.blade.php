@if($rating)
    @for($i = 1; $i <= 5; $i++)
        {!! $i <= round($rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>' !!}
    @endfor
@else
    No rating yet
@endif
