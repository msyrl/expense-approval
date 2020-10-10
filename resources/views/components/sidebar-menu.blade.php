<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($menus as $menu) <x-nav-item :menu="$menu" /> @endforeach

        <x-nav-item-logout />
    </ul>
</nav>
