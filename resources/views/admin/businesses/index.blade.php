<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ __('Business Management') }}
        </h1>
    </x-slot>

    <div class="card overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-neutral-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-neutral-500">Business Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-neutral-500">Owner</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-neutral-500">Category</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-neutral-500">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($businesses as $biz)
                <tr>
                    <td class="px-6 py-4 font-bold text-sm">{{ $biz->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $biz->owner->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $biz->category }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border
                            {{ $biz->status === 'active' ? 'bg-success-50 text-success-600 border-success-100' : 'bg-neutral-50 text-neutral-500 border-neutral-200' }}">
                            {{ $biz->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.businesses.show', $biz) }}" class="text-primary-600 font-bold text-xs uppercase hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t">
            {{ $businesses->links() }}
        </div>
    </div>
</x-app-layout>
