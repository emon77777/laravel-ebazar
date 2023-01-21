<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Report')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if(Request::is('admin/stock_report'))active @endif" id="stock-report-tab" data-bs-toggle="tab" data-bs-target="#stock-report" type="button"
                role="tab" aria-controls="stock-report" aria-selected="false"
                @if(url()->full()!=route('backend.stock_report')) onclick="location.href='{{route('backend.stock_report')}}'" @endif
        >{{__('Stock Report')}}
        </button>
        <button class="nav-link @if(Request::is('admin/customer_report'))active @endif" id="customer-report-tab" data-bs-toggle="tab" data-bs-target="#customer-report"
                type="button" role="tab" aria-controls="customer-report" aria-selected="false"
                @if(url()->full()!=route('backend.customer_report')) onclick="location.href='{{route('backend.customer_report')}}'" @endif
        >{{__('Customer Report')}}
        </button>
        <!-- <button class="nav-link @if(Request::is('admin/seller_report'))active @endif" id="seller-report-tab" data-bs-toggle="tab" data-bs-target="#seller-report"
                type="button" role="tab" aria-controls="seller-report" aria-selected="false"
                @if(url()->full()!=route('backend.seller_report')) onclick="location.href='{{route('backend.seller_report')}}'" @endif
        >{{__('Seller Report')}}
        </button> -->
    </div>
    <!-- Tab Manu End -->
</div>