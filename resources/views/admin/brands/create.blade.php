@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Brands
            </div>
            <div class="actions">
                <a href="{{ route('brand.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('brand.store')}}" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Brand Name</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in English"
                               data-container="body"></i>
                            <input type="text" name="name" class="form-control"></div>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Slug</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Category name in Bangla" data-container="body"></i>
                            <input type="text" name="slug"  class="form-control"> </div>
                        @if ($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Brand logo</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                               data-container="body"></i>
                            <input type="file" class="form-control" onchange="loadFile(event)"
                                   id="logo" name="logo">
                        </div>
                        <p><img id="output" width="200"/></p>
                        @if ($errors->has('logo'))
                            <span class="text-danger">{{ $errors->first('logo') }}</span>
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