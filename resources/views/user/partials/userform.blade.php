<!-- <style>
    .form-group{
        margin:10px;
    }
</style> -->
<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('home.name')</label>
            <div class="col-md-8">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('home.email')</label>
            <div class="col-md-8">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('home.password')</label>

            <div class="col-md-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('home.confirm') @lang('home.password')</label>

            <div class="col-md-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

      
        <div class="form-group row">
            <label for="branch-form" class="col-md-4 col-form-label text-md-right">@lang('home.role')</label>
            <div class="col-md-8">
                <select id="multicategory" class="multi-select muticat" name="roles[]" multiple="multiple">
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <script>
                    $(document).ready(function() {
                        $('#multicategory').multiselect();
                    });
                </script>
                @error('roles')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="branch-form" class="col-md-4 col-form-label text-md-right">@lang('home.status')</label>

            <div class="col-md-8">
                <select name="status" class="form-control" id="status">
                    <option selected value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        @include('user.partials.userprofileprofile')
    </div>
</div>