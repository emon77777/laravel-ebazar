<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ maanAppearance('keywords') }}" />
    <meta name="description" content="{{ maanAppearance('meta_desc') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Twitter Card Data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@yield('meta_url')">
    <meta name="twitter:title" content="@yield('meta_title','My Bazar')">
    <meta name="twitter:description" content="@yield('meta_description',maanAppearance('meta_desc'))">
    <meta name="twitter:creator" content="Maan Theme">
    <meta name="twitter:image" content="{{ asset('uploads/products/meta_image') }}/@yield('meta_image')">
    <meta name="twitter:data1" content="@yield('meta_price')">
    <meta name="twitter:label1" content="Price">
    <meta name="twitter:data2" content="@yield('meta_color')">
    <meta name="twitter:label2" content="Color">

    <!-- Open Graph Data -->
    <meta property="og:title" content="@yield('meta_title','My Bazar')"/>
    <meta property="og:type" content="eCommerce"/>
    <meta property="og:image" content="{{ asset('uploads/products/meta_image') }}/@yield('meta_image')"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:url" content="@yield('meta_url')"/>
    <meta property="og:description" content="@yield('meta_description',maanAppearance('meta_desc'))"/>

    <title>@yield('title')</title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">
    <!-- All Device Favicon -->
    <link rel="icon" href="{{ asset('uploads') }}/{{ maanAppearance('favicon') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <!-- Swiper -->
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper.min.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <!-- RateIt -->
    <link rel="stylesheet" href="{{ asset('frontend/rateit/rateit.css') }}">
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('frontend/css/normalize.css') }}">
    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('frontend/css/default.css') }}">
    <!-- uniBox -->
    <link rel="stylesheet" href="{{ asset('frontend/uniBox/css/unibox.min.css') }}">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('frontend/jquery-ui/jquery-ui.css') }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!-- My Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/my-custom.css') }}">
</head>

<body>

<div id="main-wrapper">
    <!-- Facebook share button SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0" nonce="iH4fRLBO"></script>
    <!-- Facebook share button SDK -->
    <header>
    @include('frontend.includes.top-bar')
    <!-- Main Header Start -->
        <div class="main-header">
            @include('frontend.includes.mid-bar')
            @include('frontend.includes.menu-bar')
        </div>
        <!-- Main Header End -->
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('frontend.includes.info-footer')
        @include('frontend.includes.main-footer')
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('frontend/js/vendor/jquery-3.6.0.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('frontend/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Touch Punch -->
<script src="{{ asset('frontend/jquery-ui/jquery.ui.touch-punch.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>
<!-- Popper -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }}"></script>
<!-- Swiper -->
<script src="{{ asset('frontend/js/vendor/swiper.min.js') }}"></script>
<!-- Slick -->
<script src="{{ asset('frontend/js/vendor/slick.min.js') }}"></script>
<!-- Counter Up -->
<script src="{{ asset('frontend/js/vendor/countdown.js') }}"></script>
<!-- uniBox -->
<script src="{{ asset('frontend/uniBox/js/unibox.min.js') }}"></script>
<!-- Nice Select -->
<script src="{{ asset('frontend/js/vendor/nice-select.min.js') }}"></script>
<!-- SweetAlert -->
<script src="{{ asset('frontend/js/vendor/sweetalert.min.js') }}"></script>
<!-- RateIt -->
<script src="{{ asset('frontend/rateit/jquery.rateit.min.js') }}"></script>
<!-- Index -->
<script src="{{ asset('frontend/js/index.js') }}"></script>
<script>
    "use strict";

    var xhr = new XMLHttpRequest();

    function buyNow(id){
        var csrf = "{{ csrf_token() }}";
        var qty = $('.input-number').val();
        var color = $('input[name="color"]:checked').val();
        var size = $('input[name="size"]:checked').val();
        $.ajax({
            url: "{{ route('customer.addToCart') }}",
            data: {_token:csrf,id:id,qty:qty,color:color,size:size},
            method: "POST"
        }).done(function(e){
            $("#cart-count").text(e.count);
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
            $(location).attr("href","{{ url('cart') }}");
        })
    }

    function addToCart(id){
        var csrf = "{{ csrf_token() }}";
        var qty = $('.input-number').val();
        var color = $('input[name="color"]:checked').val();
        var size = $('input[name="size"]:checked').val();
        $.ajax({
            url: "{{ route('customer.addToCart') }}",
            data: {_token:csrf,id:id,qty:qty,color:color,size:size},
            method: "POST"
        }).done(function(e){
            $("#cart-count").text(e.count);
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
        })
    }

    function removeFromCart(key,id){
        swal({
            title: "{{ __('Really!?') }}",
            text: "{{ __('Are you sure you want remove this form cart?') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((whileDelete)=>{
            if(whileDelete){
                var csrf = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('customer.removeFromCart') }}",
                    data: {_token:csrf,key:key,id:id},
                    type: "POST"
                }).done(function(e){
                    swal("{{ __('Poof! Your item has been removed!') }}", {
                        icon: "success",
                    }).then(value => {
                        $("#grand-total").text(e.subTotal);
                        $("#cart-count").text(e.count);
                        $("#cart-row-"+key).remove();
                        if(e.carts=='')
                        {
                            
						$(".checkout-btn").hide();
                        }
                    });
                })
            }else{
                swal("{{ __('Bravo! Your item is safe.') }}");
            }
        })
    }

    function updateCart(elem){
        var key = elem.data('key');
        var id = elem.data('id');
        var qty = elem.val();

        if(qty == 0){
            xhr.abort();
        }

        if(isNaN(qty)){
            qty = elem.closest('tr').find('.qty').val();
            if(elem.val() === '+'){
                qty = parseInt(qty) + 1;
            }else{
                qty = parseInt(qty) - 1;
            }
        }
        var csrf = "{{ csrf_token() }}";

        if(xhr !== 'undefined'){
            xhr.abort(); //stop existing ajax request if new request has been sent to server
        }
        if(qty > 0){
            xhr = $.ajax({
                url: "{{ route('customer.updateCart') }}",
                data: {_token:csrf,key:key,id:id,qty:qty},
                method: "POST",
                beforeSend:function(){
                    $(".checkout-btn a").css('pointer-events','none');
                }
            }).done(function(e){
                console.log(e.subTotal);
                $("#grand-total").text(e.subTotal);
                console.log(elem.closest('tr').find('.total'));
                elem.closest('tr').find('.total').text(e.productTotal);
                $("#cart-count").text(e.count);
                $(".checkout-btn a").css('pointer-events','all');
            })
        }
    }

    function addToWishlist(id){
        if("{{auth()->guard('customer')->check()}}"){
            var csrf = "{{ csrf_token() }}"
            $.ajax({
                url: "{{ route('customer.addToWishlist') }}",
                data: {_token:csrf,id:id},
                method: "POST"
            }).done(function(e){
                $("#wishlist-count").text(e.count);
                swal("{{ __('Great!') }}", e.name+" {{ __('added to your wishlist') }}",e.status);
            });
        }else{
            swal("{{ __('Please!') }}","{{ __('Login to add product to your wishlist') }}","warning");
        }
    }

    function wishToCart(id){
        var csrf = "{{ @csrf_token() }}";
        $.ajax({
            url: "{{ route('customer.wishToCart') }}",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cart-count").text(e.count);
            $("#wishlist-count").text(e.wishCount);
            $("#wish-"+id).remove();
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
        })
    }

    function removeFromWishlist(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('customer.removeFromWishlist') }}",
            data: {_token:csrf,id:id},
            type: "POST"
        }).done(function(e){
            console.log($(this));
            $("#wish-"+id).remove();
            $("#wishlist-count").text(e.count);
            swal("{{ __('Hash!') }}",e.name+"{{ __(' is removed from your wishlist!') }}","warning");
        });
    }

    function changeCurrency(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('frontend.change-currency') }}",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cur-symbol").text(e.symbol);
            $("#cur-title").text(e.name);
            location.reload();
        })
    }

    function ajaxFilter(page,selector,id){
        var csrf = "{{ csrf_token() }}";
        var category = $('input[name="category"]:checked').val();
        var brand = [];
        var seller = [];
        var color = [];
        var size = [];
        var sorting = $("#sorting").val();
        var min = $("#price-check-b").val();
        var max = $("#price-check-c").val();

        $('.brand-check:checked').each(function(){
            brand.push($(this).val())
        })
        $('.color-check:checked').each(function(){
            color.push($(this).val())
        })
        $('.size-check:checked').each(function(){
            size.push($(this).val())
        })
        $('.seller-check:checked').each(function(){
            seller.push($(this).val())
        })

        if(xhr !== 'undefined'){
            xhr.abort(); //stop existing ajax request if new request has been sent to server
        }

        xhr = $.ajax({
            url: "{{ route('frontend.ajax-filter') }}",
            data: {_token:csrf,category:category,color:color,size:size,brand:brand,seller:seller,min:min,max:max,sorting:sorting,page:page},
            type: 'post',
            beforeSend: function(){
                $("#product-loader").show();
            },
        }).done(function(e){
            $(".breadcrumb-manu h3").text($('input[name="category"]:checked').data('name'));
            $("#product-area").html(e);
            var url = "{{url()->current()}}"+"?page="+page;
            window.history.pushState("", "", url);
            $("#product-loader").hide()
            $("#sorting").change(function(){
                ajaxFilter();
            })
        })
    }

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var page = url.split('page=')[1];
        window.history.pushState("", "", url);
        ajaxFilter(page);
    })

    function dealOfTheWeek(tab){
        $.ajax({
            url: "{{ route('deal-of-the-week') }}",
            data: {_token:"{{csrf_token()}}",tab:tab},
            type: "POST"
        }).done(function(e){
            $("#"+tab).html(e);
        })
    }

    $(".brand-check").change(function(){
        ajaxFilter();
    })

    $(".seller-check").change(function(){
        ajaxFilter();
    });

    $(".category-check").change(function(){
        ajaxFilter();
    });

    $(".color-check").change(function(){
        ajaxFilter();
    });

    $(".size-check").change(function(){
        ajaxFilter();
    });

    $(".price-check").change(function(){
        ajaxFilter();
    });

    $("#sorting").change(function(){
        ajaxFilter();
    })

</script>
<script>
    "use strict";

    var boxes = [];

    sxQuery(document).ready(function() {

        var settings = {
            // REQUIRED
            suggestUrl: '{{ route('frontend.suggest',['query'=>'']) }}', // the URL that provides the data for the suggest
            ivfImagePath: 'https://yourserver.com/images/ivf/', // the base path for instant visual feedback images

            // OPTIONAL
            instantVisualFeedback: 'all', // where the instant visual feedback should be shown, 'top', 'bottom', 'all', or 'none', default: 'all'
            throttleTime: 100, // the number of milliseconds before the suggest is triggered after finished input, default: 300ms
            extraHtml: undefined, // extra HTML code that is shown in each search suggest
            highlight: true, // whether matched words should be highlighted, default: true
            queryVisualizationHeadline: '', // A headline for the image visualization, default: empty
            animationSpeed: 200, // speed of the animations, default: 300ms
            callbacks: {
                enter: function(text,link){console.log('enter callback: '+text);}, // callback on what should happen when enter is pressed, default: undefined, meaning the link will be followed
                enterResult: function(text,link){window.location.replace(link);}, // callback on what should happen when enter is pressed on a result or a suggest is clicked
            },
            placeholder: 'Search for something',
            minChars: 3, // minimum number of characters before the suggests shows, default: 3
            suggestOrder: [], // the order of the suggests
            suggestSelectionOrder: [], // the order of how they should be selected
            noSuggests: '<b>{{ __('We haven\'t found anything for you') }}, <u>{{ __('sooorrryyy') }}</u></b>',
            emptyQuerySuggests: {
                "suggests":{
                    "Products":[
                            @foreach(uniBoxSuggestions() as $suggestion)
                        {"name":"{{$suggestion->name}}","image":"{{ asset('uploads/products/galleries').'/'.$suggestion->images->first()->image }}","id":"{{ $suggestion->id }}}","link":"{{ route('product',$suggestion->slug) }}"},
                        @endforeach
                    ]
                }
            },
            //maxWidth: 400 // the maximum width of the suggest box, default: as wide as the input box
        };

        // apply the settings to an input that should get the unibox
        // apply to multiple boxes
        boxes = sxQuery(".s").unibox(settings);
    });
</script>

@if(Session::has('success'))
    <script>
        swal("{{ __('Subscribed!') }}","{{ Session::get('success') }}","success");
    </script>
@endif

@if($errors->has('email'))
    <script>
        swal("Error","{{ $errors->first('email') }}","error");
    </script>
@endif

@stack('script')
@yield('script')

</body>

</html>
