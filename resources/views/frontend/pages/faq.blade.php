@extends('frontend.layout.master')
@section('content')
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Frequently Questions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="accordion_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 align="center" style="color:#fdb813;">Frequently Asked Questions(FAQ)</h4>
                <hr>
                <div id="accordion" class="card__accordion">

                    @foreach($faqs as $faq)
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="heading{{ $faq->id }}">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                               {{ $faq->name }}

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>

                            </button>

                        </div>

                        <div id="collapse{{ $faq->id }}" class="collapse show" aria-labelledby="heading{{ $faq->id }}" data-parent="#accordion">
                            <div class="card-body">
                                <p>{{ $faq->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!--Accordion area end-->
@endsection