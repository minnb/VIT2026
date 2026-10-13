{{-- $lstCate, $hotline: cung cấp bởi ViewComposerServiceProvider --}}

<div id="mobile-menu">
  <ul>
    <li><a href="{{ route('index') }}" class="home1">Trang chủ</a></li>
    @foreach($lstCate as $item)
      <li><a href="{{ route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])]) }}">{{ $item['name'] }}</a></li>
    @endforeach
    <li><a href="{{ route('get.project.all') }}">Dự án tiêu biểu</a></li>
    <li><a href="{{ route('get.document.all') }}">Báo giá &amp; Catalog</a></li>
    <li><a href="{{ route('get.about') }}">Giới thiệu</a></li>
    <li><a href="{{ route('get.about') }}">Liên hệ</a></li>
  </ul>
</div>
{{-- <div id="page"> MO tai day, DONG o home/layouts/master.blade.php (sau @include footer). Sua can dong bo ca 2 file. --}}
<div id="page">
  {{-- Topbar: thong tin lien he, an tren mobile --}}
  <div class="vit-topbar hidden-xs">
    <div class="container">
      <div class="vit-topbar__inner">
        <ul class="vit-topbar__info">
          @if(!empty($com[0]['address']))
            <li><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $com[0]['address'] }}</li>
          @endif
          @if(!empty($com[0]['email']))
            <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:{{ $com[0]['email'] }}">{{ $com[0]['email'] }}</a></li>
          @endif
        </ul>
        <a class="vit-topbar__social" href="https://www.facebook.com/vitduct.com.vn" target="_blank" rel="noopener" aria-label="Facebook VITDUCT">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </div>

  <header>
    <div class="header-container">
      <div class="header-inner">
        <div class="container">
          <div class="vit-header">

            <div class="vit-header__brand">
              <a class="vit-logo" title="{{ $com[0]['name'] ?? 'CÔNG TY CỔ PHẦN VITDUCT' }}" href="{{ route('index') }}">
                <img src="{{ asset('public/home/images/logo.jpg') }}" alt="{{ $com[0]['name'] ?? 'CÔNG TY CỔ PHẦN VITDUCT' }}"
                     width="592" height="592" loading="eager" fetchpriority="high" decoding="async">
              </a>
              <p class="vit-tagline">Ống gió &middot; Van gió &middot; Cửa gió</p>
            </div>

            <div class="vit-header__search">
              <form method="post" action="{{ route('post.search') }}" role="search">
                {{ csrf_field() }}
                <div class="vit-search">
                  <label for="search-input" class="sr-only">Tìm kiếm sản phẩm</label>
                  <input id="search-input" type="text" name="search" value="{{ old('search') }}"
                         class="vit-search__input" placeholder="Tìm sản phẩm: ống gió, van gió, cửa gió...">
                  <button class="vit-search__btn" type="submit" aria-label="Tìm kiếm">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </div>
              </form>
            </div>

            <div class="vit-header__cta">
              <a class="vit-hotline" href="tel:{{ telLink($hotline) }}">
                <span class="vit-hotline__icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <span class="vit-hotline__text">
                  <small>Hotline tư vấn</small>
                  <strong>{{ $hotline }}</strong>
                </span>
              </a>
              <a class="vit-quote" href="{{ route('get.document.all') }}">Nhận báo giá</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </header>

  <nav class="vit-nav">
    <div class="container">
      <div class="row">
        {{-- Chi hien khi nav da thu gon (class .is-stuck do vit-ui.js gan) --}}
        <a class="vit-mini-logo" href="{{ route('index') }}" aria-hidden="true" tabindex="-1">
          <img src="{{ asset('home/images/logo.jpg') }}" alt="" width="592" height="592" loading="lazy" decoding="async">
        </a>
        <div class="mm-toggle-wrap">
          <div class="mm-toggle" role="button" tabindex="0" aria-label="Mở danh mục" aria-expanded="false" aria-controls="mobile-menu"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
          <span class="mm-label">Danh mục</span>
        </div>
        <div class="col-md-3 col-sm-3 mega-container hidden-xs">
          <div class="navleft-container">
            <div class="mega-menu-title" role="button" tabindex="0"
                 aria-expanded="false" aria-controls="mega-menu-category">
              <div class="mega-menu-heading"><span>Danh mục</span></div>
            </div>
            <div class="mega-menu-category" id="mega-menu-category">
              <ul class="nav">
                @foreach($lstCate as $item)
                  <li class="nosub"><a href="{{ route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])]) }}">{{ $item['name'] }}</a></li>
                @endforeach
                <li class="nosub"><a href="{{ route('get.project.all') }}">Dự án tiêu biểu</a></li>
                <li class="nosub"><a href="{{ route('get.document.all') }}">Tải báo giá và Catalog</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-9 jtv-megamenu">
          <div class="mtmegamenu">
            <ul class="hidden-xs">
              <li class="mt-root demo_custom_link_cms">
                <div class="mt-root-item"><a href="{{ route('index') }}">
                  <div class="title title_font"><span class="title-text">Trang chủ</span></div>
                </a></div>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="{{ route('get.product.all') }}">
                  <div class="title title_font"><span class="title-text">Sản phẩm</span></div>
                </a></div>
                <ul class="menu-items col-xs-12">
                  <li class="menu-item depth-1 menucol-1-3">
                    <ul class="submenu">
                      @foreach($lstCate as $item)
                        <li class="menu-item">
                          <div class="title"><a href="{{ route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])]) }}">{{ $item['name'] }}</a></div>
                        </li>
                      @endforeach
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="{{ route('get.document.all') }}">
                  <div class="title title_font"><span class="title-text">Báo giá &amp; Catalog</span></div>
                </a></div>
                <ul class="menu-items col-xs-12">
                  <li class="menu-item depth-1 menucol-1-3">
                    <ul class="submenu">
                      @foreach($lstDoc as $item)
                        <li class="menu-item">
                          <div class="title"><a href="{{ route('get.document.all') }}">{{ $item['name'] }}</a></div>
                        </li>
                      @endforeach
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="{{ route('get.project.all') }}">
                  <div class="title title_font"><span class="title-text">Dự án</span></div>
                </a></div>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="{{ route('get.about') }}">
                  <div class="title title_font"><span class="title-text">Giới thiệu</span></div>
                </a></div>
              </li>
              <li class="mt-root">
                <div class="mt-root-item"><a href="{{ route('get.about') }}">
                  <div class="title title_font"><span class="title-text">Liên hệ</span></div>
                </a></div>
              </li>
            </ul>
            {{-- Nut goi nhanh, chi hien khi nav thu gon --}}
            <a class="vit-nav-call" href="tel:{{ telLink($hotline) }}">
              <i class="fa fa-phone" aria-hidden="true"></i> {{ $hotline }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
