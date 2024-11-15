{{-- partials/category-radio.blade.php --}}

<div style="margin-left: {{ $prefix ? '20px' : '0px' }};">
    <label>
        <input type="radio" name="category_id" value="{{ $category->id }}" required>
        {{ $prefix }}{{ $category->category_name }}
    </label>
</div>

@if ($category->subCategories)
    @foreach ($category->subCategories as $subCategory)
        @include('partials.category-radio', ['category' => $subCategory, 'prefix' => $prefix . '-- '])
    @endforeach
@endif
