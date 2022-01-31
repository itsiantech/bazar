@extends('layouts.app')

@section('content')
<div class="portlet solid margin-top-20 margin-bottom-20">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Invoice </div>
        <div class="actions">
            <div class="btn-group">
                <a class="btn btn-sm" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-gear"></i> Status
                    <i class="fa fa-angle-down "></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-gift"></i> delivered </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-check"></i> Complete </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-ban"></i> Canceled </a>
                    </li>
                    <li class="divider"> </li>
                    <li>
                        <a class="font-red-soft" href="javascript:;"><i class="fa fa-trash-o font-red-soft"></i> Delete </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <!-- <img width="100" src="{{ asset('images/logo.png') }}" alt=""> -->

        <div class="margin-top-20 note note-info">
            <div class="row">
                <div class="col-md-4">Supplier Address</div>
                <div class="col-md-4">Delivery Address</div>
                <div class="col-md-4">Invoice</div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-4">
                <strong>Ekhoni dorker</strong>
                <address>
                    House: 36, Road: 12, <br>
                    Sector: 13, Uttara <br> Dhaka-1230
                </address>
                <address>
                <strong>Phone</strong> 01716 456 123 <br>
                <strong>Email</strong> support@bangoshop.com
                </address>
            </div> --}}
            {{-- <div class="col-md-4">
                <strong>Md. fahim ahmed</strong>
                <address>
                    House: 36, Road: 12, <br>
                    Sector: 13, Uttara <br> Dhaka-1230
                </address>
                <address>
                <strong>Phone</strong> 01716 456 123 <br>
                <strong>Email</strong> fahim@bangoshop.com
                </address>
            </div> --}}
            <div class="col-md-4">
                <p class="margin-bottom-10"><strong>Invoice ID</strong> #Ak-153-01</p>
                <p class="margin-bottom-10"><strong> Order Date </strong> 20-Jun-2020</p>
                <p class="margin-bottom-10"><strong>Payment</strong> Paid</p>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>  # </th>
                                <th> Title </th>
                                <th> Quantity </th>
                                <th> Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="javascript:;"> 01 </a>
                                </td>
                                <td class="hidden-xs"> Server hardware purchase </td>
                                <td>5</td>
                                <td> 52560.10$</td>

                            </tr>
                            <tr>
                                <td> <a href="javascript:;"> 02 </a> </td>
                                <td> Office furniture purchase </td>
                                <td>6</td>
                                <td> 5760.00$</td>

                            </tr>
                            <tr>
                                <td> <a href="javascript:;"> 03 </a> </td>
                                <td> Company Anual Dinner Catering </td>
                                <td>5</td>
                                <td> 12400.00$ </td>

                            </tr>
                            <tr>
                                <td> <a href="javascript:;"> 04 </a>
                                </td>
                                <td class="hidden-xs"> Payment for Jan 2013 </td>
                                <td>4</td>
                                <td> 610.50$</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Total</strong></td>
                                <td><strong>25000 $</strong></td>
                            </tr>

                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Delivery Charge</strong></td>
                                <td><strong>15 $</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>VAT</strong></td>
                                <td><strong>15 %</strong></td>
                            </tr>

                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Grent Total</strong></td>
                                <td><strong>2510 $</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
