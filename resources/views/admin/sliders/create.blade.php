@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Sliders
            </div>
            <div class="actions">
                <a href="{{ route('slider.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="messageDiv">
                    @if(Session::has('success'))
                        @include('layouts.message.success')
                    @elseif(Session::has('error'))
                        @include('layouts.message.error')
                    @endif
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="slider title is optional"
                               data-container="body"></i>
                            <input type="text" name="title" class="form-control"></div>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>



                        <div class="form-group">
                            <label class="control-label">Slider Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Image"
                                   data-container="body"></i>
                                <input type="file" class="form-control" onchange="loadFile(event)"
                                       id="image" name="image" required>
                            </div>
                            <p><img id="output" width="200"/></p>
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>




                        <div class="form-actions right">
                            <button type="button" class="btn default">Cancel</button>
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

@endsection