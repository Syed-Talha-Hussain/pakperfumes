<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Limit') }}</label>
        <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" placeholder="{{ __('Limit') }}">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Background color') }}</label>
                {{ Form::customColor('background_color', Arr::get($attributes, 'background_color', '#fff')) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Card color') }}</label>
                {{ Form::customColor('card_color', Arr::get($attributes, 'card_color', '#fcf6f4')) }}
            </div>
        </div>
    </div>
</section>
