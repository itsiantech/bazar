@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green-seagreen">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Categories </div>
        <div class="actions">
            <a href="{{ route('category.index') }}" class="btn btn-default btn-sm">
                <i class="fa fa-list"></i> List </a>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label">Default input</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                        <input type="text" class="form-control"> </div>
                </div>
                <div class="form-group has-success">
                    <label class="control-label">Input with success</label>
                    <div class="input-icon right">
                        <i class="fa fa-check tooltips" data-original-title="You look OK!" data-container="body"></i>
                        <input type="text" class="form-control"> </div>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Input with warning</label>
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips" data-original-title="please provide an email" data-container="body"></i>
                        <input type="text" class="form-control"> </div>
                </div>
                <div class="form-group has-error">
                    <label class="control-label">Input with error</label>
                    <div class="input-icon right">
                        <i class="fa fa-exclamation tooltips" data-original-title="please write a valid email" data-container="body"></i>
                        <input type="text" class="form-control"> </div>
                </div>
            </div>
            <div class="form-actions right">
                <button type="button" class="btn default">Cancel</button>
                <button type="submit" class="btn green">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END Portlet PORTLET-->
                         
@endsection