@if(session('status'))
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-info">
                {{session('status')}}
            </div>
        </div>
    </div>
@endif