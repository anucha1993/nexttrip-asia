@props(['image','alt'=>null,'title','count'])
<a href="#" class="group relative rounded-2xl overflow-hidden border border-amber-100 bg-white hover:shadow-md transition">
    <figure class="aspect-[4/3] w-full overflow-hidden relative">
    <img loading="lazy" decoding="async" src="{{ $image }}" alt="{{ $alt ?? $title }}" 
         srcset="{{ $image }}&w=400 400w, {{ $image }}&w=600 600w, {{ $image }}&w=800 800w" 
         sizes="(max-width:640px) 100vw, (max-width:1024px) 50vw, 25vw" 
         class="w-full h-full object-cover transition duration-700 group-hover:scale-105" width="600" height="450" />
        <span class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/15 to-transparent"></span>
        <figcaption class="absolute bottom-2 left-3 right-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white drop-shadow">{{ $title }}</h3>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-white/25 backdrop-blur text-white font-medium">{{ $count }}</span>
        </figcaption>
    </figure>
</a>
