<li class="nav-item">
    <a href="{{ $menu->url }}" class="nav-link @if(Str::of(url()->current())->contains($menu->url)) active @endif">
        <i class="{{ $menu->icon }} nav-icon"></i>
        <p>{{ $menu->label }}</p>
    </a>
</li>
