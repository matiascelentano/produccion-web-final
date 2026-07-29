@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="flex flex-col gap-3 p-2 sm:p-3 md:flex-row md:gap-6 md:p-6">

        {{-- Overlay + panel deslizable desde abajo (mobile) --}}
        <div
            id="mobile-filters-overlay"
            class="fixed inset-0 z-40 hidden bg-black/50 md:hidden"
            onclick="toggleMobileFilters()"
        ></div>

        <div
            id="mobile-filters-panel"
            class="fixed inset-x-0 bottom-0 z-50 max-h-[80vh] translate-y-full overflow-y-auto rounded-t-2xl border border-gray-200 bg-white p-4 shadow-2xl transition-transform duration-300 ease-out md:hidden"
        >
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Filtros</h3>
                <button type="button" onclick="toggleMobileFilters()" class="rounded-full p-1 text-gray-500 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Categorías</h3>
                    <button type="button" onclick="clearFilters(this.form)" class="text-sm font-medium text-indigo-600">Limpiar</button>
                </div>
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="category" value="{{ $category->slug }}"
                            @checked(request('category') === $category->slug)
                            data-selected="{{ request('category') === $category->slug ? 'true' : 'false' }}"
                            onclick="toggleFilter(this)">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach

                <div>
                    <h3 class="mt-4 mb-2 font-semibold">Marcas</h3>
                    @foreach ($brands as $brand)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="brand" value="{{ $brand->slug }}"
                                @checked(request('brand') === $brand->slug)
                                data-selected="{{ request('brand') === $brand->slug ? 'true' : 'false' }}"
                                onclick="toggleFilter(this)">
                            <span>{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </form>
        </div>

        {{-- Sidebar de filtros (desktop) --}}
        <aside class="hidden md:block w-64 shrink-0">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Categorías</h3>
                    <button type="button" onclick="clearFilters(this.form)" class="text-sm font-medium text-indigo-600">Limpiar</button>
                </div>
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="category" value="{{ $category->slug }}"
                               @checked(request('category') === $category->slug)
                               data-selected="{{ request('category') === $category->slug ? 'true' : 'false' }}"
                               onclick="toggleFilter(this)">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach

                <div>
                    <h3 class="mt-4 mb-2 font-semibold">Marcas</h3>
                    @foreach ($brands as $brand)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="brand" value="{{ $brand->slug }}"
                                   @checked(request('brand') === $brand->slug)
                                   data-selected="{{ request('brand') === $brand->slug ? 'true' : 'false' }}"
                                   onclick="toggleFilter(this)">
                            <span>{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </form>
        </aside>

        {{-- Listado --}}
        <div class="flex-1 min-w-0">
            <div class="mb-3 flex flex-col gap-2 md:mb-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-gray-600">{{ $products->total() }} productos encontrados</p>

                <div class="flex items-center gap-2">
                    <button type="button" id="mobile-filters-toggle" class="inline-flex w-auto items-center justify-between rounded-lg border border-indigo-600 bg-indigo-600 text-sm font-semibold text-white shadow-sm p-2 m-0 md:hidden"
                        onclick="toggleMobileFilters()" aria-expanded="false">
                        <span>Filtros</span>
                        <span class="text-base">☰</span>
                    </button>
                    <form method="GET" action="{{ route('products.index') }}" class="w-full md:w-auto">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                        <select name="sort" onchange="this.form.submit()" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm md:w-auto">
                            <option value="">Más recientes</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Menor precio</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Mayor precio</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>Más antiguos</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-500">No se encontraron productos con esos filtros.</p>
            @endif

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleMobileFilters() {
            const panel = document.getElementById('mobile-filters-panel');
            const overlay = document.getElementById('mobile-filters-overlay');

            if (!panel || !overlay) return;

            const isOpening = panel.classList.contains('translate-y-full');

            if (isOpening) {
                overlay.classList.remove('hidden');
                requestAnimationFrame(() => {
                    panel.classList.remove('translate-y-full');
                });
                document.body.classList.add('overflow-hidden');
            } else {
                panel.classList.add('translate-y-full');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        function toggleFilter(input) {
            const inputs = document.querySelectorAll('input[type="radio"][name="' + input.name + '"]');
            const alreadySelected = input.checked && input.dataset.selected === 'true';

            inputs.forEach((radio) => {
                radio.dataset.selected = 'false';
            });

            if (alreadySelected) {
                input.checked = false;
                input.dataset.selected = 'false';
                input.form.submit();
                return;
            }

            input.dataset.selected = 'true';
            input.form.submit();
        }

        function clearFilters(form) {
            form.querySelectorAll('input[type="radio"][name="category"], input[type="radio"][name="brand"]').forEach((radio) => {
                radio.checked = false;
                radio.dataset.selected = 'false';
            });

            form.submit();
        }
    </script>
@endsection