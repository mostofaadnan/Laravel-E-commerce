@extends('frontend.layout.master')
@section('content')

<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Notification</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="shop_area">
    <div class="container">
        <ul>
            @foreach($notifications as $notify)
            @if($notify->read_at==null)
            <li class="notification-box bg-gray notification-item" data-id="{{ $notify->id }}">
                @else
            <li class="notification-box notification-item" data-id="{{ $notify->id }}">
                @endif
                <div class="row">
                    <div class="col-lg-8 col-sm-8 col-8">
                        <strong class="text-info">{{ $notify->data['type'] }}</strong>
                        <div>
                            {{ $notify->data['message'] }}
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-4 col-4">
                        <small class="text-warning">{{ $notify->data['inputdate'] }}</small><br>
                        <small class="text-info">{{ $notify->data['invoice_no'] }}</small>
                        <strong class="text-danger">{{ $notify->data['total'] }}</strong>
                    </div>
                </div>
            </li>

            @endforeach
        </ul>
        @if($notifications->count()>9)
        <div class="shop_toolbar t_bottom">
            <div class="pagination">
                <ul>
                    {{ $notifications->links() }}
                </ul>
            </div>
        </div>
        @endif


    </div>
</div>


@endsection