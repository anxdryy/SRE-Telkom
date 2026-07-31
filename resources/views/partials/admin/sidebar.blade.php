<div id="admin-sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full transform bg-[#104334] px-6 py-8 transition-transform duration-200 md:translate-x-0">
    <div class="mb-10 flex items-center">
        <img src="{{ asset('images/logo2.png') }}" alt="SRE Logo" class="h-14">
    </div>
    <nav class="space-y-1 font-redhat text-sm font-medium">
        @php
            $adminNavLinks = [
                ['route' => 'departments.index', 'prefix' => 'departments.', 'label' => 'Departments', 'icon' => 'fa-building'],
                ['route' => 'members.index', 'prefix' => 'members.', 'label' => 'Members', 'icon' => 'fa-users'],
                ['route' => 'categories.index', 'prefix' => 'categories.', 'label' => 'Categories', 'icon' => 'fa-tags'],
                ['route' => 'programs.index', 'prefix' => 'programs.', 'label' => 'Programs', 'icon' => 'fa-folder-open'],
                ['route' => 'works.index', 'prefix' => 'works.', 'label' => 'Works', 'icon' => 'fa-suitcase'],
                ['route' => 'alumni.index', 'prefix' => 'alumni.', 'label' => 'Alumni', 'icon' => 'fa-user-graduate'],
            ];
        @endphp
        @foreach($adminNavLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors {{ request()->routeIs($link['prefix'].'*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                <i class="fas {{ $link['icon'] }} w-4"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
