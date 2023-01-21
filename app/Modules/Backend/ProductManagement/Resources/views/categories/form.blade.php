<div class="row">
    <div class="col-lg-3">
        <p>{{__('Name')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="@if($category->name){{$category->name}}@else{{ old('name') }}@endif"
                   required placeholder="Name"
                   autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Parent Category')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group overflow-visible">
            <select name="category_id" class="parent form-select form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                <option value="">{{ __('Select parent') }}</option>
                <option value="" selected>{{ __('Root') }}</option>
                @foreach($categories as $key => $cat)
                    <option value="{{$cat->id}}"
                            @if($cat->id==$category->category_id) selected @endif >{{$cat->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Slug')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                   name="slug"
                   value="@if($category->slug){{$category->slug}}@else{{ old('slug') }}@endif"
                   required placeholder="Slug"
                   autofocus>

            @error('slug'))
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{('Ordering Number')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="sm-title-group">
            <div class="input-group oder-input">
                <input name="order" min="0" max="1000" type="number"
                       class="form-control {{ $errors->has('order') ? ' is-invalid' : '' }}"
                       placeholder="Order Level"
                       value="@if($category->order){{$category->order}}@else{{ old('order') }}@endif" required>
                @if ($errors->has('order'))
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('order') }}</strong>
            </span>
                @endif
            </div>
            <span class="sm-text">{{__('Higher number has high priority')}}</span>
        </div>
    </div>

    <div class="col-lg-3">
        <p>{{__('Banner(200x200)')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="banner" type="file" class="form-control{{ $errors->has('banner') ? ' is-invalid' : '' }}"
                   name="banner" accept="image/*"
                   autofocus @if(Request::is('admin/categories/create','seller/categories/create'))required @endif>

            @if ($errors->has('banner'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('banner') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Image(32x32)')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group file-upload overflow-visible">
            <label class="file-title">Browse</label>
            <input id="icon" type="file"
                   class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}"
                   name="icon" accept="image/*"
                   autofocus @if(Request::is('admin/categories/create','seller/categories/create'))required @endif>

            @if ($errors->has('icon'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('icon') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta Title')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="meta_title" type="text" required
                   class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                   value="@if($category->meta_title){{$category->meta_title}}@else{{ old('meta_title') }}@endif"
                   placeholder="Meta Title">
            @if ($errors->has('meta_title'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('meta_title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Meta description')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea name="meta_description"
                      class="form-control">@if($category->meta_description){{$category->meta_description}}@else{{ old('meta_description') }}@endif</textarea>
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Commission Rate')}}</p>
    </div>
    <div class="col-lg-7">
        <div class="input-group commission-group overflow-visible">
            <input type="number" min="0" step="0.1" max="100" name="commission_rate" class="commission-input"
                   placeholder="Commission Rate"
                   value="@if($category->commission_rate){{$category->commission_rate}}@else{{ old('commission_rate')??0 }}@endif" required>
            @error('commission_rate')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
            <span class="commission-persent">%</span>

        </div>
    </div>

</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(".parent").select2();
                // validate form on keyup and submit
                $("#categoryForm").validate();

            });
        })(jQuery);

    </script>
@endpush
