@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Page Create
            </div>
            <div class="actions">
                <a href="{{ route('page.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('page.store')}}" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Page Title</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="page title "
                               data-container="body"></i>
                            <input type="text" name="title" class="form-control"></div>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Page body</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="page body"
                               data-container="body"></i>
                            <textarea name="body" class="form-control"  id="editor"  ></textarea>
                            @if ($errors->has('body'))
                                <span class="text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Page body (Bengali)</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="page body"
                               data-container="body"></i>
                            <textarea name="body_bn" class="form-control"  id="editor_bn"  ></textarea>
                            @if ($errors->has('body'))
                                <span class="text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="control-label">Select Navigation Area</label>
                        <div class="input-icon right">
                            <select class="form-control" name="navigation_location_id">
                                <option value="NULL"> Select nav area</option>
                                @foreach($navigations as $navigation)
                                    <option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Banner Image</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Image"
                               data-container="body"></i>
                            <input type="file" class="form-control" onchange="loadFile(event)"
                                   id="image" name="banner_image" >
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
    <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
        CKEDITOR.replace( 'editor_bn' );
    </script>
@endsection
