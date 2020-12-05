<div class="container bg-transparent px-0 pt-3">
    <div class="row">
        <div class="col-12 pt-1 pl-0">
            <nav class="ml-auto">
                <ul class="pagination pagination-sm justify-content-center">
                    <li class="page-item @if(Request::get("page") && Request::get("page") == "1") disabled @endif">
                        <a class="page-link" href="/{{ Request::segment(1) }}?page=<?=Request::get("page") ? Request::get("page") - 1 : 1?>">‹</a></li>
                    @for($i = 1; $i <= $pager->getPages(); $i++)
                        <li class="page-item @if((!Request::get("page") && $i == 1) || (Request::get("page") && Request::get("page") == $i)) active @endif">
                            <a class="page-link" href="/{{ Request::segment(1) }}?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item @if(Request::get("page") && Request::get("page") == $pager->getPages()) disabled @endif">
                        <a class="page-link"
                           href="/{{ Request::segment(1) }}?page=<?=Request::get("page") ? Request::get("page") + 1 : $pager->getPages()?>">›</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
