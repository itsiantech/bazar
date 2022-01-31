@if(isset($state) && !empty($state))
<div class="col-md-6">
    <form action="{{route($actionURL)}}" autocomplete="off" method="post">
        @csrf
        <input type="hidden" name="state" value="{{$state}}">
        <div class="form-group">
            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd" style="width: 100% !important;">
                <input placeholder="start" autocomplete="off" type="text" class="form-control" name="start">
                <span class="input-group-addon"> to </span>
                <div class="input-group">
                    <input placeholder="end" autocomplete="off" type="text" class="form-control" name="end" data-date-format="yyyy-mm-dd" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit">SEARCH</button>
                    </span>
                </div>
            </div>
        </div>
    </form>
</div>
@endif
