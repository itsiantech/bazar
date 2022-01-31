@extends("layouts.app")

@push("stylesheets")
    @include("layouts.asset.css.dateTimePicker")
@endpush

@push("scripts")
    @include("layouts.asset.js.dateTimePicker")
@endpush

@section("content")
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-pin font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">Date Pickers</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn red btn-outline btn-circle btn-sm uppercase sbold" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> Option 1</a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;">Option 2</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 3</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 4</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="form-horizontal form-bordered">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Default Datepicker</label>
                                <div class="col-md-3">
                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="">
                                    <span class="help-block"> Select date </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Disable Past Dates</label>
                                <div class="col-md-3">
                                    <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                        <input type="text" class="form-control" readonly="">
                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block"> Select date </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Start With Years</label>
                                <div class="col-md-3">
                                    <div class="input-group input-medium date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                        <input type="text" class="form-control" readonly="">
                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block"> Select date </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Months Only</label>
                                <div class="col-md-3">
                                    <div class="input-group input-medium date date-picker" data-date="10/2012" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
                                        <input type="text" class="form-control" readonly="">
                                        <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block"> Select month only </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date Range</label>
                                <div class="col-md-4">
                                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control" name="from">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control" name="to"> </div>
                                    <!-- /input-group -->
                                    <span class="help-block"> Select date range </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Inline</label>
                                <div class="col-md-3">
                                    <div class="date-picker" data-date-format="mm/dd/yyyy"> <div class="datepicker datepicker-inline"><div class="datepicker-days" style="display: block;"><table class=" table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev" style="visibility: visible;"><i class="fa fa-angle-left"></i></th><th colspan="5" class="datepicker-switch">May 2021</th><th class="next" style="visibility: visible;"><i class="fa fa-angle-right"></i></th></tr><tr><th class="dow">Su</th><th class="dow">Mo</th><th class="dow">Tu</th><th class="dow">We</th><th class="dow">Th</th><th class="dow">Fr</th><th class="dow">Sa</th></tr></thead><tbody><tr><td class="old day">25</td><td class="old day">26</td><td class="old day">27</td><td class="old day">28</td><td class="old day">29</td><td class="old day">30</td><td class="day">1</td></tr><tr><td class="day">2</td><td class="day">3</td><td class="day">4</td><td class="day">5</td><td class="day">6</td><td class="day">7</td><td class="day">8</td></tr><tr><td class="day">9</td><td class="day">10</td><td class="day">11</td><td class="day">12</td><td class="day">13</td><td class="day">14</td><td class="day">15</td></tr><tr><td class="day">16</td><td class="day">17</td><td class="day">18</td><td class="day">19</td><td class="day">20</td><td class="day">21</td><td class="day">22</td></tr><tr><td class="day">23</td><td class="day">24</td><td class="day">25</td><td class="day">26</td><td class="day">27</td><td class="day">28</td><td class="day">29</td></tr><tr><td class="day">30</td><td class="day">31</td><td class="new day">1</td><td class="new day">2</td><td class="new day">3</td><td class="new day">4</td><td class="new day">5</td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-months" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev" style="visibility: visible;"><i class="fa fa-angle-left"></i></th><th colspan="5" class="datepicker-switch">2021</th><th class="next" style="visibility: visible;"><i class="fa fa-angle-right"></i></th></tr></thead><tbody><tr><td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev" style="visibility: visible;"><i class="fa fa-angle-left"></i></th><th colspan="5" class="datepicker-switch">2020-2029</th><th class="next" style="visibility: visible;"><i class="fa fa-angle-right"></i></th></tr></thead><tbody><tr><td colspan="7"><span class="year old">2019</span><span class="year">2020</span><span class="year">2021</span><span class="year">2022</span><span class="year">2023</span><span class="year">2024</span><span class="year">2025</span><span class="year">2026</span><span class="year">2027</span><span class="year">2028</span><span class="year">2029</span><span class="year new">2030</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div></div></div>
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <a class="btn green btn-outline sbold uppercase" href="#form_modal2" data-toggle="modal"> View Datepicker in modal
                                        <i class="fa fa-share"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="form_modal2" class="modal fade" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Datepickers In Modal</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="#" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Default Datepicker</label>
                                            <div class="col-md-8">
                                                <input class="form-control input-medium date-picker" size="16" type="text" value=""> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Disable Past Dates</label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </button>
                                                                        </span>
                                                </div>
                                                <!-- /input-group -->
                                                <span class="help-block"> Select date </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Start With Years</label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </button>
                                                                        </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Months Only</label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker" data-date="10/2012" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </button>
                                                                        </span>
                                                </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Date Range</label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                    <input type="text" class="form-control" name="from">
                                                    <span class="input-group-addon"> to </span>
                                                    <input type="text" class="form-control" name="to"> </div>
                                                <!-- /input-group -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                    <button class="btn green" data-dismiss="modal">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@endsection
