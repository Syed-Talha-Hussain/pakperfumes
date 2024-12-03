<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" class="form-control" value="{{ Arr::get($attributes, 'title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" class="form-control" value="{{ Arr::get($attributes, 'subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Choose teams') }}</label>
    <select class="select-full" name="team_ids" multiple>
        @foreach($teams as $key => $value)
            <option @selected(in_array($key, $teamIds)) value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
