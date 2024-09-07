@if ($errors->has($fieldName))
    <span class="helper-text" data-error="wrong" data-success="right">
        <strong>{{ $errors->first($fieldName) }}</strong>
    </span>
@endif
