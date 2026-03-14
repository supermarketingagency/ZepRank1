<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-google text-neutral-900">
            {{ $business->name }}
        </h1>
    </x-slot>

    <div class="space-y-8 animate-slide-up">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Business Info -->
                <div class="card p-8">
                    <h3 class="text-lg font-google font-bold mb-6">Profile Details</h3>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black uppercase text-neutral-400">Owner</p>
                            <p class="font-medium">{{ $business->owner->name }}</p>
                            <p class="text-xs text-neutral-500">{{ $business->owner->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-neutral-400">Status</p>
                            <form action="{{ route('admin.businesses.status', $business) }}" method="POST" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-sm border-neutral-200 rounded-lg py-1 pl-3 pr-8">
                                    <option value="trial" {{ $business->status === 'trial' ? 'selected' : '' }}>Trial</option>
                                    <option value="active" {{ $business->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ $business->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="cancelled" {{ $business->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Branches -->
                <div class="card overflow-hidden">
                    <div class="px-8 py-5 border-b bg-neutral-50">
                        <h3 class="font-google font-bold">Branches ({{ $business->branches->count() }})</h3>
                    </div>
                    <table class="w-full text-left">
                        <tbody class="divide-y">
                            @foreach($business->branches as $branch)
                            <tr>
                                <td class="px-8 py-4">
                                    <p class="font-bold text-sm">{{ $branch->name }}</p>
                                    <p class="text-xs text-neutral-500">{{ $branch->address }}</p>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <span class="text-xs font-medium text-neutral-400">{{ $branch->google_review_url ? 'Connected' : 'Missing Link' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Subscription -->
                <div class="card p-8">
                    <h3 class="text-lg font-google font-bold mb-6">Subscription</h3>
                    @if($business->subscription)
                        <div class="space-y-4">
                            <div class="p-4 bg-primary-50 rounded-2xl border border-primary-100">
                                <p class="text-[10px] font-black uppercase text-primary-600">Active Plan</p>
                                <p class="text-xl font-google font-bold text-primary-900">{{ $business->subscription->plan->name }}</p>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-500">Tokens Left</span>
                                <span class="font-bold">{{ number_format($business->subscription->ai_tokens_remaining) }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-neutral-500 italic">No active subscription found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
