<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Bienvenido al panel de control de tu tenant!') }}

                    <form method="POST" action="{{ route('tenant.store') }}" class="mt-4">
                        @csrf
                        <div>
                            <x-input-label for="id" class="mt-4 mb-2" :value="__('Url del Tenant')" />

                            <div class="flex items-center mt-1">
                                <b class="mr-3">https://</b>
                                <x-text-input id="id" class="flex mt-1" type="text" name="id" :value="old('id')" required autofocus />
                                <b class="ml-3">.locahost:8083</b>
                            </div>
                            
                            <x-input-error :messages="$errors->get('id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-primary-button class="">
                                {{ __('Crear Tenant') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4">
                        {{ __('Tenants Creados') }}
                    </h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Id') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Link') }}
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">{{ __('Editar') }}</span>
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">{{ __('Mantenimiento') }}</span>
                                </th>
                            
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">{{ __('Eliminar') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $tenant->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="http://{{ $tenant->domains->first()->domain }}:8083" target="new" class="text-indigo-600 hover:text-indigo-900">http://{{ $tenant->domains->first()->domain }}:8083</a>
                                </td>
                                <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">{{ __('Editar') }}</a>
                                </td>
                                <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if( $tenant->maintenance_mode )
                                    <a href="{{ route('tenant.restore', $tenant) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Restaurar') }}</a>
                                    @else
                                    <a href="{{ route('tenant.maintenance', $tenant) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Mantenimiento') }}</a>
                                    @endif
                                </td>
                                <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form method="POST" action="{{ route('tenant.destroy', $tenant) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>