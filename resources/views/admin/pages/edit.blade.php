@extends('layouts.app')

@section('content')


    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Page
            </div>
            <div class="actions">
                <a href="{{ route('page.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('page.update',['id'=>$page->id])}}" method="post" enctype="multipart/form-data">
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
                            <i class="fa fa-info-circle tooltips" data-original-title="page title is optional"
                               data-container="body"></i>
                            <input type="text" name="title" value="{{ $page->title }}" class="form-control"></div>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>


                    <div class="form-group">
                        <label class="control-label">Page body</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="page body"
                               data-container="body"></i>
                            <textarea name="body" class="form-control"  id="editor"  >{{ $page->body }}</textarea>
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
                            <textarea name="body_bn" class="form-control"  id="editor_bn">{{$page->body_bn}}</textarea>
                            @if ($errors->has('body'))
                                <span class="text-danger">{{ $errors->first('body') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Page banner Image</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Image"
                               data-container="body"></i>
                            <input type="file" class="form-control" onchange="loadFile(event)"
                                   id="banner_image" name="banner_image">
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
