@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Categories
            </div>
            <div class="actions">
                <a href="{{ route('category.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Category name in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in English"
                               data-container="body"></i>
                            <input type="text" name="name_en" class="form-control"></div>
                        @if ($errors->has('name_en'))
                            <span class="text-danger">{{ $errors->first('name_en') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Category name in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                               data-container="body"></i>
                            <input type="text" name="name_bn" class="form-control"></div>
                        @if ($errors->has('name_bn'))
                            <span class="text-danger">{{ $errors->first('name_bn') }}</span>
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
                        <label class="control-label">Select Parent Category</label>
                        <div class="input-icon right">
                            <select class="form-control" name="parent_id">
                                <option value="NULL"> Select Parent Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label">Category Banner Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                   data-container="body"></i>
                                <input type="file" class="form-control" onchange="loadFile(event)"
                                       id="image" name="image">
                            </div>
                            <p><img id="output" width="200"/></p>
                            @if ($errors->has('name_bn'))
                                <span class="text-danger">{{ $errors->first('name_bn') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Category Icon</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category icon"
                                   data-container="body"></i>
                                <input type="file" class="form-control"
                                         name="icon">
                            </div>
                            <p><img id="output" width="200"/></p>
                            @if ($errors->has('icon'))
                                <span class="text-danger">{{ $errors->first('icon') }}</span>
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