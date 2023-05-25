<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{Route::currentRouteName() == 'admin.dashboard'?'active':''}}" aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('admin.posts.index')}}" class="nav-link @if (Route::currentRouteName() == 'admin.posts.index') active @endif">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Posts
            </a>
        </li>


        <li class="nav-item">
            <a href="{{route('admin.categories.index')}}" class="nav-link @if (Route::currentRouteName() == 'admin.categories.index') active @endif">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Categories
            </a>
        </li>


        <li class="nav-item">
            <a href="{{route('admin.tags.index')}}" class="nav-link @if (Route::currentRouteName() == 'admin.tags.index') active @endif">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Tag
            </a>
        </li>

    </ul>
</div>
