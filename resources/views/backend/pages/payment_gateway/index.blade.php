@extends('backend.layouts.app')
@section('title','Payment Gateway - ')
@section('content')

    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
                <div class="content-tab-title">
                    <h4>{{__('Payment Gateway')}}</h4>
                </div>
                <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="appearance" aria-labelledby="appearance-tab">
                        <div class="container">
                            <div class="card-group">
                                @foreach($payment_gateways as $key => $payment_gateway )
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ucfirst($payment_gateway->name)}}</h5>
                                            <form id="paymentGatewayForm" class="add-brand-form"
                                                  action="{{route('backend.payment_gateway.update',$payment_gateway->id)}}"
                                                  method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    @foreach(json_decode($payment_gateway->configuration,true) as $index => $config)
                                                        <div class="col-lg-3">
                                                            <p>{{$index}}</p>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                       name="{{'configuration'.'['.$index.']'}}"
                                                                       class="form-control @error('name') is-invalid @enderror"
                                                                       value="{{$config??old($index)}}"
                                                                       placeholder="{{$index}}"
                                                                       required>

                                                                @error($index)
                                                                <div class="invalid-feedback">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="col-lg-3">
                                                        <p>{{__('Status')}}</p>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <div class="form-check form-switch btn-one-off">
                                                                <input type="hidden" value="0" name="status">
                                                                <input name="status"
                                                                       @if($payment_gateway->status || old('status'))checked
                                                                       @endif class="form-check-input" value="1"
                                                                       type="checkbox">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 offset-2">
                                                    <div class="from-submit-btn">
                                                        <button class="submit-btn" type="submit">{{__('Save')}}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End  -->
            </div>
        </div>
    </div>
@endsection
