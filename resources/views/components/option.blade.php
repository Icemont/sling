@props(['value', 'name', 'selected'])
<option value="{{ $value }}"{{ $value == $selected ? ' selected' : '' }}{{ $attributes->isNotEmpty() ? ' ' : '' }}{{ $attributes }}>{{ $name }}</option>