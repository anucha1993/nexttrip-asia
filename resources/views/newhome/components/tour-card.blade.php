@props(['image' => null,'title','duration','price','availability'=>null])
<div class="group relative flex flex-col rounded-xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-md transition">
    <div class="aspect-[4/3] overflow-hidden relative">
        <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $title }}" 
             srcset="{{ $image }}&w=400 400w, {{ $image }}&w=600 600w, {{ $image }}&w=800 800w" 
             sizes="(max-width:640px) 100vw, (max-width:1024px) 50vw, 33vw" 
             class="w-full h-full object-cover transform transition duration-700 group-hover:scale-105" width="600" height="450" />
        <span class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></span>
        @if($availability)
            <span class="absolute top-2 left-2 rounded-full bg-white/90 backdrop-blur px-2 py-0.5 text-[10px] font-semibold text-emerald-600 ring-1 ring-emerald-500/20">{{ $availability }}</span>
        @endif
        <span class="absolute bottom-2 left-3 text-white font-medium drop-shadow">{{ $title }}</span>
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <p class="text-sm text-slate-500 mb-2">{{ $duration }}</p>
        <p class="text-orange-700 font-semibold mb-4">{{ $price }} ฿</p>
        <a href="#booking" class="mt-auto inline-flex items-center gap-1 text-sm font-medium text-orange-600 hover:text-orange-700">รายละเอียด <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 5l7 7-7 7"/></svg></a>
    </div>
</div>
