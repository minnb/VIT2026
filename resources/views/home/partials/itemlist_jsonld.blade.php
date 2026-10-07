{{--
  Structured Data cho các trang danh sách (schema.org CollectionPage + ItemList).
  Biến bắt buộc:
    $listName   (string) - tên trang danh sách
    $listItems  (array)  - [['name' => ..., 'url' => ...], ...]
  Tuỳ chọn:
    $listOffset (int)    - vị trí bắt đầu, dùng cho trang phân trang (mặc định 1)
  Cách gọi: @include('home.partials.itemlist_jsonld', ['listName' => 'Sản phẩm', 'listItems' => $listItems])
--}}
@if(!empty($listItems))
  @push('jsonld')
  @php
      $listStart   = isset($listOffset) && $listOffset > 0 ? (int) $listOffset : 1;
      $listElements = [];

      foreach (array_values($listItems) as $listIndex => $listItem) {
          $listElements[] = [
              '@type'    => 'ListItem',
              'position' => $listStart + $listIndex,
              'name'     => $listItem['name'],
              'url'      => seo_canonical($listItem['url']),
          ];
      }

      $listSchema = [
          '@context'   => 'https://schema.org',
          '@type'      => 'CollectionPage',
          'name'       => $listName,
          'url'        => seo_canonical(request()->getRequestUri()),
          'isPartOf'   => ['@id' => config('seo.base_url') . '/#website'],
          'mainEntity' => [
              '@type'           => 'ItemList',
              'name'            => $listName,
              'numberOfItems'   => count($listElements),
              'itemListOrder'   => 'https://schema.org/ItemListUnordered',
              'itemListElement' => $listElements,
          ],
      ];
  @endphp
  <script type="application/ld+json">{!! json_encode($listSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
  @endpush
@endif
