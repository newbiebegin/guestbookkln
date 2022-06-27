@if ($paginator->hasPages())
	
	
    <nav>
		<span>
			{!! __('Showing') !!}
			<span class="font-medium">{{ $paginator->firstItem() }}</span>
			{!! __('to') !!}
			<span class="font-medium">{{ $paginator->lastItem() }}</span>
			{!! __('of') !!}
			<span class="font-medium">{{ $paginator->total() }}</span>
			{!! __('results') !!}
		</span>
		
		<ul class="pagination float-right">
		@if ($paginator->onFirstPage())
			<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
				<span class="page-link" aria-hidden="true">
					&laquo;
				</span>
			</li>
		@else
			<li class="page-item">
				<a class="page-link" href="{{ \Request::url() }}" rel="prev" aria-label="@lang('pagination.first')">
					&laquo;
				</a>
			</li>
		@endif
		
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
			
			@if ($paginator->hasMorePages())
				<li class="page-item">
					<a class="page-link" href="{{ \Request::url().'?page='.$paginator->lastPage() }}" rel="last" aria-label="@lang('pagination.last')">
						&raquo;
					</a>
				</li>
			@else
				<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
					<span class="page-link" aria-hidden="true">
						&raquo;
					</span>
				</li>
			@endif
        </ul>
    </nav>
@endif
