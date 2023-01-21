@extends('backend.layouts.app')
@section('title','Product - ')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/css/image-uploader.min.css')}}">
@endpush
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-product" aria-labelledby="add-product-tab">
                @if(auth()->user()->can('create_products') || auth()->user()->hasRole('super-admin'))
                <form id="productForm" class="add-brand-form" action="@auth('admin'){{route('backend.products.store')}}@elseauth('seller'){{route('seller.products.store')}}@endauth" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @include('productmanagement::products.form')
                </form>
                @endif
            </div>
        </div>
@endsection
@push('js')
    <script src="{{asset('backend/js/image-uploader.min.js')}}"></script>
            <script>
                $(function() {
                    "use strict";
                    $(document).ready(function(){

                        $('.input-images').imageUploader({
                            imagesInputName: 'images',
                            preloadedInputName: 'old_images',
                            maxSize: 1024 * 10240,
                            maxFiles: 4
                        });
                    });
                });
            </script>
@endpush
