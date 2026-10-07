{{-- Tiêu đề trang + breadcrumb. Biến: $title, $parent --}}
<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">{{ $title }}</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">{{ $parent }}</li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
