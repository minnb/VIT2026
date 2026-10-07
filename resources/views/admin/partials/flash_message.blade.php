@if(Session::has('flash_message'))
    <div class="row">
        <div class="col-12" id="flash-message">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        {{ Session::get('flash_message') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
