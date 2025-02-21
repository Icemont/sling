@props(['errors', 'title' => __('There are errors in the form')])

@if ($errors->any())
<div class="alert alert-danger">
    <h4 class="alert-title">{{ $title }}:</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif