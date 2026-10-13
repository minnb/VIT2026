{{--
  Breadcrumb dùng chung + Structured Data BreadcrumbList.
  Biến: $items = [['label' => 'Sản phẩm', 'url' => '...'], ...]
  Phần tử cuối là trang hiện tại (không cần 'url').
--}}
@php
    $crumbPosition = 1;
    $crumbList = [[
        '@type'    => 'ListItem',
        'position' => $crumbPosition++,
        'name'     => 'Trang chủ',
        'item'     => seo_canonical(route('index')),
    ]];

    foreach ($items as $crumb) {
        $crumbEntry = [
            '@type'    => 'ListItem',
            'position' => $crumbPosition++,
            'name'     => $crumb['label'],
        ];

        if (!empty($crumb['url'])) {
            $crumbEntry['item'] = seo_canonical($crumb['url']);
        } else {
            $crumbEntry['item'] = seo_current_url();
        }

        $crumbList[] = $crumbEntry;
    }
@endphp
<nav class="breadcrumbs" aria-label="Đường dẫn">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
          <li class="home"><a title="Quay về trang chủ" href="{{ route('index') }}">Trang chủ</a><span>&raquo;</span></li>
          @foreach($items as $i => $crumb)
            <li>
              @if(!empty($crumb['url']))
                <a title="{{ $crumb['label'] }}" href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
              @else
                <span aria-current="page">{{ $crumb['label'] }}</span>
              @endif
              @if($i < count($items) - 1)<span>&raquo;</span>@endif
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</nav>
<script type="application/ld+json">{!! json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => $crumbList,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
