@if(($paginator->lastPage() == 1))
@elseif($paginator->currentPage() == $paginator->lastPage())
@if ($paginator->lastPage() == 2)
<ul class="pagination mt-3 justify-content-center pagination_style1">
    <li class="page-item">
        <a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1)}}">
            <i class="linearicons-arrow-left"></i>
        </a>
    </li>
    <li class="page-item">
        <a class="page-link" href="{{$paginator->url($paginator->lastPage() - 1)}}">{{$paginator->lastPage() - 1}}</a>
    </li>
    <li class="page-item active">
        <a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a>
    </li>

</ul>
@else
<ul class="pagination mt-3 justify-content-center pagination_style1">
    <li class="page-item">
        <a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1)}}">
            <i class="linearicons-arrow-left"></i>
        </a>
    </li>
    <li class="page-item">
        <a class="page-link" href="{{$paginator->url($paginator->lastPage() - 2)}}">{{$paginator->lastPage() - 2}}</a>
    </li>
    <li class="page-item">
        <a class="page-link" href="{{$paginator->url($paginator->lastPage() - 1)}}">{{$paginator->lastPage() - 1}}</a>
    </li>
    <li class="page-item active">
        <a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a>
    </li>
</ul>
@endif

@elseif($paginator->currentPage() < $paginator->lastPage() && $paginator->lastPage() <=3) <ul class="pagination mt-3 justify-content-center pagination_style1">
        @for($i= 1; $i <= $paginator->lastPage(); $i++)
            <li class="page-item {{($paginator->currentPage() == $i) ? 'active' : ''}}">
                <a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a>
            </li>
            @endfor

            <li class="page-item">
                <a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1)}}">
                    <i class="linearicons-arrow-right"></i>
                </a>
            </li>

            </ul>
            @elseif($paginator->currentPage() == 1 && $paginator->lastPage() > 3)
            <ul class="pagination mt-3 justify-content-center pagination_style1">
                <li class="page-item active">
                    <a class="page-link" href="{{$paginator->url(1)}}">{{1}}</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{$paginator->url(2)}}">{{2}}</a>
                </li>
                <li class="page-item ">
                    <a class="page-link" href="{{$paginator->url(3)}}">{{3}}</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1)}}">
                        <i class="linearicons-arrow-right"></i>
                    </a>
                </li>
            </ul>

            @else
            <ul class="pagination mt-3 justify-content-center pagination_style1">
                <li class="page-item">
                    <a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1)}}">
                        <i class="linearicons-arrow-left"></i>
                    </a>
                </li>

                @for($i= $paginator->currentPage() - 1; $i < $paginator->currentPage() + 2; $i++)
                    <li class="page-item {{($paginator->currentPage() == $i) ? 'active' : ''}}">
                        <a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a>
                    </li>
                    @endfor

                    <li class="page-item">
                        <a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1)}}">
                            <i class="linearicons-arrow-right"></i>
                        </a>
                    </li>

            </ul>

            @endif