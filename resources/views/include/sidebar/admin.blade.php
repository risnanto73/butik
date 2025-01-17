<li class="sidebar-title">Menu</li>

<li class="sidebar-item {{ request()->routeIs('admin.index') ? 'active' : '' }} ">
    <a href="{{ route('admin.index') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Beranda</span>
    </a>
</li>

<li class="sidebar-title">Produk</li>

<li class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} ">
    <a href="{{ route('admin.categories.index') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Kategori</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
    <a href="{{ route('admin.product.index') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Produk</span>
    </a>
</li>

{{-- <li class="sidebar-item ">
    <a href="index.html" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Artikel</span>
    </a>
</li> --}}

{{-- logout --}}
<li class="sidebar-item">
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="sidebar-link">
            <i class="bi bi-grid-fill"></i>
            <span>Logout</span>
        </button>
    </form>
</li>
