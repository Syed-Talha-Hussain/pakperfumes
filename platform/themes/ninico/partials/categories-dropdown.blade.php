@php
    $groupedCategories = $categories->groupBy('parent_id');

    $currentCategories = $groupedCategories->get(0);
@endphp

@if($currentCategories)
    <div class="cat-menu__category p-relative">
        @if(Theme::get('hasCategoriesDropdown', true))
            <a class="tp-cat-toggle js-tp-cat-toggle" href="javascript:" role="button">
                <i class="fal fa-bars"></i> {{ __('Categories') }}
            </a>
        @else
            <a class="tp-cat-toggle">
                <i class="fal fa-bars"></i> {{ __('Categories') }}
            </a>
        @endif
        <div class="category-menu category-menu-off">
            <ul class="cat-menu__list">
                @foreach ($currentCategories as $category)
                    @php
                        $hasChildren = $groupedCategories->has($category->id);
                    @endphp
                    <li @class(['menu-item-has-children' => $hasChildren])>
                        <a href="{{ route('public.single', $category->url) }}">
                            @if ($categoryImage = $category->icon_image)
                                <img src="{{ RvMedia::getImageUrl($categoryImage) }}" alt="{{ $category->name }}" width="18" height="18">
                            @elseif ($categoryIcon = $category->icon)
                                <i class="{{ $categoryIcon }}"></i>
                            @endif
                            {{ $category->name }}
                        </a>
                        @if($hasChildren && $currentCategories = $groupedCategories->get($category->id))
                            <ul class="submenu">
                                @foreach($currentCategories as $childCategory)
                                    <li><a href="{{ route('public.single', $childCategory->url ) }}">{{ $childCategory->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
