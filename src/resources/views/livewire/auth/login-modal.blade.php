<div>
    @if($show)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="bg-white p-4 w-96">
                <input wire:model="email" class="border w-full mb-2" placeholder="email">
                <input wire:model="password" type="password" class="border w-full mb-2">

                <button wire:click="login" class="bg-blue-500 text-white px-3 py-2">
                    Login
                </button>
            </div>
        </div>
    @endif
</div>