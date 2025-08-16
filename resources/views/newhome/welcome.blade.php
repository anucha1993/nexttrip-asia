@extends('newhome.layouts.app')

@section('title', 'จองทัวร์ ราคาพิเศษ | Tour Booking')
@section('meta_description',
    'จองแพ็คเกจทัวร์ในประเทศและต่างประเทศ ราคาพิเศษ อัปเดตทุกสัปดาห์
    คัดสรรโดยผู้เชี่ยวชาญด้านท่องเที่ยว')

@section('content')


 {{-- <section class="relative h-[60vh] max-h-[60vh] overflow-hidden"> --}}
    <section class="relative isolate overflow-hidden h-[60vh] max-h-[60vh]">
  {{-- แทร็คสไลด์ --}}
  <div id="hero" class="h-full w-full">
    <div id="heroTrack"
         class="flex h-full w-full snap-x snap-mandatory overflow-x-auto scroll-smooth no-scrollbar">

      @foreach ($slide as $s)
        <div class="relative h-full w-full shrink-0 snap-center">
          <picture>
            <source media="(min-width:1024px)" srcset="https://nexttripholiday.b-cdn.net/{{ $s->img }}">
            <img
              src="https://nexttripholiday.b-cdn.net/{{ $s->img_mobile }}"
              alt="slide- {!! $s->detail !!}"
              class="absolute inset-0 h-full w-full object-cover object-center" />
          </picture>

          {{-- เลเยอร์ทับมืด --}}
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent"></div>

          {{-- คำบรรยายจาก backend (จะอยู่มุมล่างซ้าย) --}}
          @if(!empty($s->detail))
            <div class="absolute bottom-4 left-4 right-4 z-10 text-white drop-shadow text-center">
              {!! $s->detail !!}
            </div>
          @endif
        </div>
      @endforeach
    </div>

    {{-- ปุ่มเลื่อนซ้าย/ขวา --}}
    <button type="button" data-dir="-1"
            class="absolute left-2 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/40 p-2 text-white hover:bg-black/60">
      <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
    </button>
    <button type="button" data-dir="1"
            class="absolute right-2 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/40 p-2 text-white hover:bg-black/60">
      <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M8.59 16.59 13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
    </button>
  </div>

  {{-- คอนเทนต์กลาง (หัวข้อ + ฟอร์มค้นหา) --}}

  

  <div class="pointer-events-none absolute inset-0 grid place-items-center px-3">
      <div class="rounded-2xl bg-white/10 backdrop-blur-sm backdrop-saturate-150
              ring-1 ring-white/20 shadow-xl p-4 sm:p-5">
    <div class="pointer-events-auto w-full max-w-6xl text-center text-white">
      <h1 class="text-3xl font-bold sm:text-5xl">สำรวจโลกกว้างกับเรา</h1>
      <p class="mt-2 mb-4 text-white/85">ดีลทัวร์ต่างประเทศประจำสัปดาห์ อัปเดตราคาเรียลไทม์</p>
 <!-- ฟอร์มค้นหา (ไม่มีค่า default ของวัน) -->

 <div class="relative">

       
      </div>

        <form action="{{ url('search-tour') }}" method="GET" id="searchFormLite" class="mx-auto w-full max-w-3xl">
            @csrf
          <div class="rounded-2xl bg-white/15 backdrop-blur-md ring-1 ring-white/30 shadow-lg p-3 sm:p-4
                      grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-3 text-white">

            <!-- คำค้น -->
            <div class="relative sm:col-span-6">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 opacity-90 text-slate-200">
                <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M11 4a7 7 0 105.29 12.29l3.7 3.7 1.42-1.42-3.7-3.7A7 7 0 0011 4z" fill="currentColor"/></svg>
              </span>
               <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
          <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M11 4a7 7 0 105.29 12.29l3.7 3.7 1.42-1.42-3.7-3.7A7 7 0 0011 4z" fill="currentColor"/></svg>
        </span>
        <input id="mb_search" type="text" placeholder="ประเทศ, เมือง, สถานที่ท่องเที่ยว"  name="search_data" 
             class="h-12 w-full rounded-lg border border-white/30 bg-white/10 pl-10 pr-3 text-sm placeholder-white/70
                            focus:border-white focus:ring-2 focus:ring-white focus:outline-none" />
        <div id="mb_livesearch" class="absolute z-50 mt-2 w-full hidden" style="z-index: 999999"></div>
        <div id="mb_famus"     class="absolute z-40 mt-2 w-full hidden" style="z-index: 999999"></div>
            </div>

            <!-- วันที่ (ช่วงเดียว; ไม่มี default; ถ้าไม่เลือกจะไม่ส่งค่า) -->
            <div class="relative sm:col-span-6">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 opacity-90 text-slate-200">
                <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M7 2h10a3 3 0 013 3v14a3 3 0 01-3 3H7a3 3 0 01-3-3V5a3 3 0 013-3zm2 6h6v2H9V8z" fill="currentColor"/></svg>
              </span>
              <input id="date_range" type="text" readonly
                     placeholder="ช่วงวันที่ (ไม่จำเป็น)"
                     class="h-12 w-full rounded-lg border border-white/30 bg-white/10 pl-10 pr-3 text-sm text-white/90 placeholder-white/70
                            focus:border-white focus:ring-2 focus:ring-white focus:outline-none" />
              <!-- ค่าที่จะส่งจริง -->
              <input type="hidden" id="start_date" name="start_date">
              <input type="hidden" id="end_date"   name="end_date">
            </div>

            <!-- ช่วงราคา -->
            <div class="sm:col-span-6">
              <select name="price"
                      class="h-12 w-full appearance-none rounded-lg border border-white/30 bg-white/10 px-3 text-sm
                             focus:border-white focus:ring-2 focus:ring-white focus:outline-none text-white/90">
                <option value="">ช่วงราคา</option>
                <option value="1" class="text-gray-900">ต่ำกว่า 10,000</option>
                <option value="2" class="text-gray-900">10,001–20,000</option>
                <option value="3" class="text-gray-900">20,001–30,000</option>
                <option value="4" class="text-gray-900">30,001–50,000</option>
                <option value="5" class="text-gray-900">50,001–80,000</option>
                <option value="6" class="text-gray-900">80,001 ขึ้นไป</option>
              </select>
            </div>

            <!-- รหัสทัวร์ -->
            <div class="sm:col-span-3">
              <input type="text" name="code_tour" placeholder="รหัสทัวร์"
                     class="h-12 w-full rounded-lg border border-white/30 bg-white/10 px-3 text-sm placeholder-white/70
                            focus:border-white focus:ring-2 focus:ring-white focus:outline-none" />
            </div>

            <!-- ปุ่มค้นหา -->
            <div class="sm:col-span-3">
              <button type="submit"
                      class="h-12 w-full rounded-lg bg-orange-500 text-sm font-semibold text-white
                             hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-white/80">
                ค้นหาทัวร์
              </button>
            </div>
          </div>
        </form>

    </div>
    </div>
  </div>
</section>
<style>
    /* ป๊อปอัปผลลัพธ์: ลอยบนสุดจริง ๆ ไม่โดน hero/overflow บัง */
.nt-pop{
  position: fixed;
  z-index: 2147483647 !important;
  background:#fff;
  border:1px solid rgba(0,0,0,.08);
  border-radius:12px;
  box-shadow:0 10px 30px rgba(0,0,0,.10);
  max-height:clamp(260px,60vh,520px);
  overflow:auto;
  padding:6px;
}

.nt-ul{ list-style:none; margin:0; padding:0; }
.nt-ul li+li{ border-top:1px solid #f1f5f9; }

.js-pick{
  display:flex; align-items:center; gap:10px; width:100%;
  text-align:left; padding:10px 12px; border-radius:10px; cursor:pointer;
}
.js-pick:hover{ background:#f8fafc; }

.nt-chip{ display:inline-flex; align-items:center; gap:8px; padding:8px 12px;
  border-radius:999px; border:1px solid #e5e7eb; background:#fff; cursor:pointer; }
.nt-chip:hover{ background:#f8fafc; }

.nt-sec{ padding:8px 6px; }
.nt-sec h6{ margin:4px 8px 6px; font:600 13px/1 ui-sans-serif,system-ui; color:#475569; }

</style>
<script>
(() => {
  const el = id => document.getElementById(id);
  const norm = s => (s||'').toString().trim();
  const contains = (a,b) => norm(a).toLowerCase().includes(norm(b).toLowerCase());
  const esc = s => (s||'').toString().replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
  const escapeReg = s => (s||'').replace(/[.*+?^${}()|[\]\\]/g,'\\$&');
  const host = 'https://nexttripholiday.b-cdn.net/';
  const typeMap = {country:'ประเทศ', city:'เมือง', province:'จังหวัด', district:'อำเภอ/เขต', keyword:'คำค้น'};

  /* ---------- 0) เคลียร์ id ซ้ำ (ถ้ามีหลุดมา) ---------- */
  ['mb_livesearch','mb_famus','nav_livesearch','nav_famus'].forEach(id=>{
    const nodes = Array.from(document.querySelectorAll('#'+id));
    nodes.slice(1).forEach(n=>n.remove());
  });

  /* ---------- 1) สร้างดัชนี ---------- */
  function buildIndex(){
    const out=[];
    (window.country||[]).forEach(c=>out.push({
      type:'country',
      label: c.country_name_th || '',
      icon:  c.img_icon ? host + c.img_icon : '',
      keywords:[c.country_name_th,c.country_name_en,c.code].filter(Boolean).join(' ')
    }));
    (window.city||[]).forEach(ci=>out.push({ type:'city', label:ci.city_name_th||'', icon:'', keywords:ci.city_name_th||'' }));
    (window.province||[]).forEach(p=>out.push({ type:'province', label:p.name_th||'', icon:'', keywords:p.name_th||'' }));
    (window.amupur||[]).forEach(a=>out.push({ type:'district', label:a.name_th||'', icon:'', keywords:a.name_th||'' }));
    (window.keyword_famus||[]).forEach(k=>out.push({ type:'keyword', label:k.keyword||'', icon:'', keywords:k.keyword||'' }));
    return out;
  }
  const INDEX = buildIndex();

  /* ---------- 2) เรนเดอร์รายการผลลัพธ์ (เป็นปุ่มกด ใส่ค่า input ไม่ลิงก์) ---------- */
  function makeItemHTML(it, q){
    const hl = esc(it.label).replace(new RegExp('('+escapeReg(q)+')','ig'),'<mark class="bg-yellow-200">$1</mark>');
    return `
      <li>
        <button type="button" class="js-pick"
                data-label="${esc(it.label)}">
          ${it.icon ? `<img src="${it.icon}" class="h-[16px] w-[24px] object-cover rounded-sm" alt="">`
                    : `<span class="inline-block h-2 w-2 rounded-full bg-slate-300"></span>`}
          <span class="text-slate-800 text-sm">${hl}</span>
          <span class="ml-auto text-[11px] text-slate-400">${typeMap[it.type]||''}</span>
        </button>
      </li>`;
  }

  function renderList(boxId, items, q){
    const box = el(boxId); if(!box) return;
    if(!items.length){ box.classList.add('hidden'); box.innerHTML=''; return; }
    box.classList.remove('hidden'); box.classList.add('nt-pop');
    box.innerHTML = `<ul class="nt-ul">${items.map(it=>makeItemHTML(it,q)).join('')}</ul>`;
    placePop(box, el(box.dataset.input || ''));
  }

  /* ---------- 3) เรนเดอร์ “ยอดนิยม/คำค้นฮิต” เป็นชิป (ปุ่ม) ---------- */
  function renderFamous(listId, fameId){
    const box = el(fameId || listId); if(!box) return;
    const fameCountries = (window.country_famus||[]).map(c=>`
      <button type="button" class="nt-chip js-pick" data-label="ทัวร์${esc(c.country_name_th||'')}">
        ${c.img_icon ? `<img src="${host+c.img_icon}" class="h-[16px] w-[24px] object-cover rounded-sm" alt="">` : ''}
        <span>ทัวร์${esc(c.country_name_th||'')}</span>
      </button>`).join('');

    const fameKeywords = (window.keyword_famus||[]).map(k=>`
      <button type="button" class="nt-chip js-pick" data-label="${esc(k.keyword||'')}">${esc(k.keyword||'')}</button>`
    ).join('');

    box.classList.remove('hidden'); box.classList.add('nt-pop');
    box.innerHTML = `
      <div class="nt-sec">
        <h6>ประเทศยอดนิยม</h6>
        <div class="flex flex-wrap gap-2">${fameCountries || '-'}</div>
      </div>
      <div class="nt-sec">
        <h6>คำค้นยอดฮิต</h6>
        <div class="flex flex-wrap gap-2">${fameKeywords || '-'}</div>
      </div>`;
    placePop(box, el(box.dataset.input || ''));
  }

  /* ---------- 4) เสิร์ช ---------- */
  function doSearch(inputId, listId, fameId){
    const input = el(inputId); if(!input) return;
    const q = norm(input.value);
    if(!q){ renderList(listId, [], ''); renderFamous(listId, fameId); return; }
    fameId && el(fameId)?.classList.add('hidden');
    const res = INDEX.filter(it => contains(it.label,q) || contains(it.keywords,q)).slice(0,12);
    renderList(listId, res, q);
  }

  /* ---------- 5) วางตำแหน่งป๊อปอัป (fixed ไม่โดน overflow คลิป) ---------- */
  function placePop(pop, input){
    if(!pop || !input) return;
    const r = input.getBoundingClientRect();
    pop.style.left  = r.left + 'px';
    pop.style.top   = (r.bottom + 6) + 'px';
    pop.style.width = r.width + 'px';
  }

  /* ---------- 6) เลือกค่า → ใส่ลง input แล้วปิดกล่อง ---------- */
  function commitPick(input, text){
    input.value = text;
    input.dispatchEvent(new Event('input',{bubbles:true}));
    input.dispatchEvent(new Event('change',{bubbles:true}));
    // ปิดกล่องของ input นั้น ๆ
    document.querySelectorAll('.nt-pop').forEach(p=>{
      if(p.dataset.input === input.id) p.classList.add('hidden');
    });
    input.focus();
  }

  // ใช้ mousedown (capture) กัน blur
  document.addEventListener('mousedown', (e)=>{
    const btn = e.target.closest('.js-pick');
    if(!btn) return;
    e.preventDefault();
    const wrap = btn.closest('.nt-pop');
    const input = wrap && el(wrap.dataset.input || '');
    if(input) commitPick(input, btn.dataset.label || btn.textContent.trim());
  }, true);

  // คลิกนอก → ปิด
  document.addEventListener('click', (e)=>{
    document.querySelectorAll('.nt-pop').forEach(pop=>{
      const input = el(pop.dataset.input || '');
      if(!pop.contains(e.target) && input && !input.contains(e.target)){
        pop.classList.add('hidden');
      }
    });
  });

  // เลื่อน/ย่อหน้าจอ → จัดตำแหน่งใหม่
  const syncAll = () => {
    document.querySelectorAll('.nt-pop:not(.hidden)').forEach(pop=>{
      placePop(pop, el(pop.dataset.input || ''));
    });
  };
  window.addEventListener('scroll', syncAll, {passive:true});
  window.addEventListener('resize', syncAll);

  /* ---------- 7) ผูกกับช่องค้นหา (mobile + desktop ถ้ามี) ---------- */
  function attachLiveSearch(inputId, listId, fameId){
    const inp = el(inputId); if(!inp) return;
    const list = el(listId), fame = fameId ? el(fameId) : null;

    // ย้ายกล่องไป <body> + ใส่ data-input ให้รู้ว่าเป็นของใคร
    [list, fame].forEach(box=>{
      if(!box) return;
      box.dataset.input = inputId;
      document.body.appendChild(box);      // สำคัญ: กันโดน hero/overflow คลิป
      box.classList.add('nt-pop');         // style ลอยบนสุด
      box.classList.add('hidden');
    });

    inp.setAttribute('autocomplete','off');
    inp.addEventListener('input', ()=>doSearch(inputId, listId, fameId));
    inp.addEventListener('focus', ()=>{ if(!norm(inp.value)) renderFamous(listId, fameId); else doSearch(inputId, listId, fameId); });
  }

  // ผูก mobile (จำเป็น)
  attachLiveSearch('mb_search','mb_livesearch','mb_famus');
  // ถ้ามี desktop ให้ปลดคอมเมนต์ 2 บรรทัดนี้
  // attachLiveSearch('nav_search','nav_livesearch','nav_famus');

})();
</script>

<!-- Litepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const isDesktop  = window.matchMedia('(min-width: 768px)').matches;
  const input      = document.getElementById('date_range');
  const startInput = document.getElementById('start_date');
  const endInput   = document.getElementById('end_date');
  const form       = document.getElementById('searchFormLite');

  // ไม่ตั้งค่าเริ่มต้นให้ช่วงวันที่
  const picker = new Litepicker({
    element: input,
    singleMode: false,        // เลือกช่วงวัน
    autoApply: true,          // เลือกแล้วใส่ค่าให้ทันที
    numberOfMonths:  isDesktop ? 2 : 1,
    numberOfColumns: isDesktop ? 2 : 1,
    // ไม่กำหนด minDate เพื่อไม่ให้บังคับวันปัจจุบัน
    format: 'DD/MM/YYYY',
    setup: (inst) => {
      inst.on('selected', (d1, d2) => {
        const fmt = (d) => d ? d.format('YYYY-MM-DD') : '';
        startInput.value = fmt(d1);
        endInput.value   = fmt(d2);
      });
      // บางเวอร์ชันมีอีเวนต์ clear
      inst.on && inst.on('clear:selection', () => {
        input.value = '';
        startInput.value = '';
        endInput.value = '';
      });
    }
  });

  // ถ้าไม่เลือกวัน ให้ "ไม่ส่ง" start_date/end_date (เบราเซอร์จะไม่แนบฟิลด์นี้ไป)
  form.addEventListener('submit', () => {
    if (!startInput.value || !endInput.value) {
      startInput.disabled = true;
      endInput.disabled   = true;
    }
  });

  // ปรับจำนวนเดือนเมื่อขนาดจอเปลี่ยน
  window.addEventListener('resize', () => {
    const desktopNow = window.matchMedia('(min-width: 768px)').matches;
    picker.setOptions({
      numberOfMonths:  desktopNow ? 2 : 1,
      numberOfColumns: desktopNow ? 2 : 1
    });
  });
});


  // ฟังก์ชันเรียกจากเมนูมือถือ (ถ้าใช้)
  function closeMobileMenu(){
    const panel = document.getElementById('mobileMenu');
    const backdrop = document.getElementById('backdrop');
    panel?.classList.add('-translate-x-full');
    backdrop?.classList.add('hidden');
    document.documentElement.classList.remove('overflow-hidden');
  }
</script>


{{-- ซ่อนสกอร์บาร์แนวนอนของสไลด์ (เล็กมาก ไม่ใช้ lib) --}}
<style>
  .no-scrollbar::-webkit-scrollbar{display:none;}
  .no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
</style>

<script>
(() => {
  const track = document.getElementById('heroTrack');
  const prev  = document.querySelector('#hero [data-dir="-1"]');
  const next  = document.querySelector('#hero [data-dir="1"]');
  const step  = () => track.clientWidth;

  const go = dir => track.scrollBy({ left: dir * step(), behavior: 'smooth' });
  prev.addEventListener('click', () => go(-1));
  next.addEventListener('click', () => go(1));
})();
</script>






    <!-- แพ็คเกจทัวร์แนะนำในต่างแดน (เด่นขึ้น) -->
    <section class="relative py-12">
        <!-- พื้นหลังไล่สี + แสงเบลอ -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-orange-50 via-white to-sky-50"></div>
        <div
            class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_left,rgba(240,116,47,0.12),transparent_55%),radial-gradient(ellipse_at_bottom_right,rgba(56,189,248,0.12),transparent_60%)]">
        </div>

        <div class="mx-auto max-w-7xl px-4">
            <!-- หัวข้อ -->
            <div class="mb-6 flex items-center gap-3">
                <span
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow ring-1 ring-black/5">
                    <!-- icon pin -->
                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
                        <path fill="currentColor"
                            d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 119.5 9 2.5 2.5 0 0112 11.5z" />
                    </svg>
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900">
                    ประเทศยอดนิยม
                </h2>
            </div>

            <!-- กริดการ์ด -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($country as $co)
                    @php
                        $tour_count = App\Models\Backend\TourModel::where(
                            'country_id',
                            'like',
                            '%"' . @$co->id . '"%',
                        )->count();
                    @endphp

                    <a href="https://nexttripholiday.com/clients-review/{{ @$co->id ?? 0 }}/0"
                        class="group relative block rounded-[26px] bg-gradient-to-br from-orange-200/40 via-rose-200/30 to-amber-200/40 p-[1px] hover:shadow-xl hover:shadow-orange-100/60 transition">

                        <!-- การ์ดด้านใน -->
                        <div
                            class="relative overflow-hidden rounded-[24px] bg-white ring-1 ring-black/5 transition-transform duration-300 group-hover:-translate-y-0.5">
                            <!-- รูป -->
                            <div class="relative aspect-[4/3] lg:aspect-[3/2] overflow-hidden">
                                <img src="https://nexttripholiday.b-cdn.net/{{ @$co->img_banner }}"
                                    alt="{{ @$co->country_name_th }}" loading="lazy"
                                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">
                                <!-- gradient ซ้อนบนรูป -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent">
                                </div>

                                <!-- ชิปมุมบน (ซ้าย: ไอคอนประเทศ/ท่องเที่ยว) -->
                                <div class="absolute left-3 top-3 flex items-center gap-2">
                                    <span
                                        class="inline-grid h-9 w-9 place-items-center rounded-lg bg-white/90 backdrop-blur-sm ring-1 ring-black/5 shadow">
                                        <!-- airplane -->
                                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]" fill="none"
                                            stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 12.75l-6.364 6.364a.75.75 0 001.06 1.06L12 13.06l6.803 7.115a.75.75 0 001.198-.905l-7.5-18a.75.75 0 00-1.386 0l-7.5 18a.75.75 0 001.198.905L10.5 12.75z" />
                                        </svg>
                                    </span>
                                </div>

                                <!-- ชิปมุมบนขวา: จำนวนโปรแกรม -->
                                <div
                                    class="absolute right-3 top-3 rounded-full bg-orange-500/80 px-3 py-1 text-xs font-semibold text-white ring-1 ring-black/5 shadow">
                                    {{ number_format($tour_count) }} โปรแกรม
                                </div>

                                <!-- ข้อความล่าง -->
                                <div class="absolute inset-x-0 bottom-0 p-4 md:p-5 text-white">
                                    <div class="flex items-end justify-between gap-3">
                                        <div>
                                            <div class="text-lg md:text-xl font-extrabold drop-shadow-sm">
                                                {{ @$co->country_name_th }}</div>
                                            <div class="mt-0.5 text-[13px] md:text-sm text-white/85 font-medium">
                                                สำรวจแพ็คเกจยอดนิยม พร้อมดีลพิเศษ
                                            </div>
                                        </div>
                                        <span
                                            class="hidden md:inline-flex items-center gap-1 rounded-full bg-blue-900/80 px-3 py-1 text-sm font-semibold ring-1 ring-white/20 backdrop-blur-sm">
                                            ดูแพ็คเกจ
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h14m-7-7l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- โปรโมชั่นแพ็คเกจทัวร์  https://www.nexttripholiday.com/promotiontour/0/0-->
    <!-- โปรโมชั่นแพ็คเกจทัวร์ (Infinite Loop) -->
    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex items-baseline justify-between gap-4">
                <h2 class="text-2xl font-extrabold text-orange-500">โปรโมชั่นแพ็คเกจทัวร์</h2>

                <a href="https://www.nexttripholiday.com/promotiontour/0/0"
                    class="inline-flex items-center gap-2 text-[#ef4444] font-semibold hover:gap-3 transition-all">
                    ดูเพิ่มเติม
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="relative mt-6 overflow-hidden group">
                <div class="flex gap-6 animate-marquee group-hover:[animation-play-state:paused]">
                    @foreach ($ads as $ad)
                        <a href="https://www.nexttripholiday.com/promotiontour/0/0"
                            class="shrink-0 w-[300px] sm:w-[380px] lg:w-[460px] xl:w-[520px]
                block overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm hover:shadow-md transition">
                            <div class="relative aspect-[2/1] overflow-hidden"> <!-- เตี้ยลง -->
                                <img src="https://nexttripholiday.b-cdn.net/{{ $ad->img }}" alt="promotion"
                                    class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-[1.02]">
                            </div>
                        </a>
                    @endforeach

                    {{-- duplicate set for infinite loop --}}
                    @foreach ($ads as $ad)
                        <a href="https://www.nexttripholiday.com/promotiontour/0/0" aria-hidden="true"
                            class="shrink-0 w-[300px] sm:w-[380px] lg:w-[460px] xl:w-[520px]
                block overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm">
                            <div class="relative aspect-[2/1] overflow-hidden">
                                <img src="https://nexttripholiday.b-cdn.net/{{ $ad->img }}" alt=""
                                    class="absolute inset-0 h-full w-full object-cover object-center">
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CSS keyframes -->
    <style>
        /* งูกินหาง: มี 2 ชุดเรียงต่อกันในแทร็คเดียว เลื่อนไป -50% เท่าความกว้างของ 1 ชุดพอดี */
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 28s linear infinite;
            /* ปรับความเร็วได้ */
            will-change: transform;
        }

        /* เคารพผู้ใช้ที่ไม่ต้องการแอนิเมชัน */
        @media (prefers-reduced-motion: reduce) {
            .animate-marquee {
                animation: none;
            }
        }
    </style>





    {{-- ==================== เลือกทัวร์ที่ใช่ในสไตล์คุณ (Tailwind + Backend) ==================== --}}
    <section class="bg-[#f5f7ef] py-10">
        <div class="mx-auto max-w-7xl px-4">
            <h2 class="text-2xl sm:text-[28px] font-extrabold text-slate-900">
                เลือกทัวร์ที่ใช่ในสไตล์คุณ
            </h2>

            @php
                // ----- Data ที่ใช้ซ้ำ -----
                $month = [
                    '',
                    'ม.ค.',
                    'ก.พ.',
                    'มี.ค.',
                    'เม.ย.',
                    'พ.ค.',
                    'มิ.ย.',
                    'ก.ค.',
                    'ส.ค.',
                    'ก.ย.',
                    'ต.ค.',
                    'พ.ย.',
                    'ธ.ค.',
                ];

                // ประเภททัวร์
                $tour_type = App\Models\Backend\TourTypeModel::where([
                    'status' => 'on',
                    'deleted_at' => null,
                ])
                    ->orderBy('id', 'asc')
                    ->get();

                // ทัวร์ลดราคา (อิงโค้ดเดิม)
                $tour_price = App\Models\Backend\TourModel::where([
                    'tb_tour.status' => 'on',
                    'tb_tour.deleted_at' => null,
                ])
                    ->where('tb_tour.special_price', '>', 0)
                    ->leftJoin('tb_tour_period', 'tb_tour.id', '=', 'tb_tour_period.tour_id')
                    ->where('tb_tour_period.status_display', 'on')
                    ->where('tb_tour_period.count', '>', 0)
                    ->whereDate('tb_tour_period.start_date', '>=', now())
                    ->whereNull('tb_tour_period.deleted_at')
                    ->where('tb_tour_period.status_period', '!=', 3)
                    ->orderBy('tb_tour_period.start_date', 'asc')
                    ->groupBy('tb_tour_period.tour_id')
                    ->select('tb_tour.*')
                    ->orderBy('tb_tour.special_price', 'desc')
                    ->limit(4)
                    ->get();

                // ถ้า controller ไม่ส่ง $tour_views มา ให้ fallback เป็น popular (เรียงตาม views / สร้างตามที่คุณใช้จริง)
                if (!isset($tour_views)) {
                    $tour_views = App\Models\Backend\TourModel::where(['status' => 'on', 'deleted_at' => null])
                        ->orderBy('views', 'desc')
                        ->limit(4)
                        ->get();
                }

                // ฟังก์ชันช่วยแปลงช่วงเดือน จาก period ทั้งหมด
                $formatTravelWindow = function ($periods) use ($month) {
                    if ($periods->isEmpty()) {
                        return null;
                    }
                    $first = $periods->first();
                    $last = $periods->last();
                    return $month[date('n', strtotime($first->start_date))] .
                        ' ' .
                        date('Y', strtotime($first->start_date)) .
                        ' – ' .
                        $month[date('n', strtotime($last->start_date))] .
                        ' ' .
                        date('Y', strtotime($last->start_date));
                };
            @endphp

            {{-- ---------- Tabs ---------- --}}
            <div class="mt-4 overflow-x-auto">
                <div class="flex items-center gap-3 min-w-max" role="tablist">
                    <button role="tab" aria-selected="true" data-tab-target="hot"
                        class="px-4 py-2 rounded-full text-[15px] font-semibold bg-[#f0742f] text-white shadow">
                        ทัวร์สนใจมากที่สุด
                    </button>

                    @foreach ($tour_type as $tt)
                        <button role="tab" aria-selected="false" data-tab-target="type-{{ $tt->id }}"
                            class="px-4 py-2 rounded-full text-[15px] font-semibold bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50">
                            {{ $tt->type_name }}
                        </button>
                    @endforeach

                    <button role="tab" aria-selected="false" data-tab-target="sale"
                        class="px-4 py-2 rounded-full text-[15px] font-semibold bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50">
                        ทัวร์ที่ลดราคา
                    </button>
                </div>
            </div>

            {{-- ---------- Panels ---------- --}}
            <div class="mt-6 space-y-6">

                {{-- ========== Panel: Hot ========== --}}
                <div data-tab-panel="hot">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($tour_views as $tour)
                            @php
                                $country = \App\Models\Backend\CountryModel::whereIn(
                                    'id',
                                    json_decode(@$tour->country_id, true) ?: [],
                                )->first();
                                $airline = \App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                                $periodsAll = \App\Models\Backend\TourPeriodModel::where([
                                    'tour_id' => @$tour->id,
                                    'status_display' => 'on',
                                ])
                                    ->whereDate('start_date', '>=', now())
                                    ->whereNull('deleted_at')
                                    ->orderBy('start_date', 'asc')
                                    ->get();

                                $window = $formatTravelWindow($periodsAll);
                                $code = @$tour->code1_check ? @$tour->code1 : @$tour->code;
                                $hasSale = (int) @$tour->special_price > 0;
                                $priceAfter = $hasSale
                                    ? (int) $tour->price - (int) $tour->special_price
                                    : (int) $tour->price;
                            @endphp

                            {{-- Card --}}
                            <article class="group bg-white overflow-hidden rounded-2xl shadow-sm ring-1 ring-black/5">
                                <div class="relative">
                                    <div class="relative aspect-[1/1] overflow-hidden">
                                        <a href="https://nexttripholiday.com/tour/{{ $tour->slug }}" target="_blank">
                                            <img src="https://nexttripholiday.b-cdn.net/{{ @$tour->image }}"
                                                alt="{{ $tour->name }}"
                                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                        </a>
                                    </div>


                                </div>

                                <div class="p-5">
                                    <div class="text-[#f0742f] text-sm font-semibold">{{ $tour->num_day }}</div>
                                    <h3 class="mt-1 text-lg font-extrabold leading-snug text-slate-900">
                                        <a href="{{ url('tour/' . $tour->slug) }}"
                                            target="_blank">{{ $tour->name }}</a>
                                    </h3>

                                    <ul class="mt-3 space-y-2 text-[13px] text-slate-600">
                                        <li class="flex items-center gap-2">
                                            <!-- airplane (outline) -->
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500"
                                                fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 12.75l-6.364 6.364a.75.75 0 001.06 1.06L12 13.06l6.803 7.115a.75.75 0 001.198-.905l-7.5-18a.75.75 0 00-1.386 0l-7.5 18a.75.75 0 001.198.905L10.5 12.75z" />
                                            </svg>
                                            สายการบิน <img src="https://nexttripholiday.b-cdn.net/{{ @$airline->image }}"
                                                alt="{{ @$airline->name }}">

                                        </li>
                                        <li class="flex items-center gap-2">
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                <path fill="currentColor"
                                                    d="M19 4H5a2 2 0 00-2 2v13l4-4h12a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                            </svg>
                                            {{ $window ?? 'กำหนดการเดินทางอัปเดต' }}
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                <path fill="currentColor"
                                                    d="M17 3H7a2 2 0 00-2 2v14l7-3 7 3V5a2 2 0 00-2-2z" />
                                            </svg>
                                            รหัสทัวร์ {{ $code }}
                                        </li>
                                    </ul>

                                    <div class="mt-4 flex items-end justify-between">
                                        <span class="text-slate-500 text-sm">เริ่มต้น</span>
                                        <div class="text-right">
                                            @if ($hasSale)
                                                <div class="text-xs text-slate-400 line-through">ปกติ
                                                    {{ number_format($tour->price, 0) }} THB</div>
                                            @endif
                                            <div class="text-[20px] font-extrabold tracking-tight text-rose-600">
                                                {{ number_format($priceAfter, 0) }} THB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- ========== Panel: แต่ละประเภท ========== --}}
                @foreach ($tour_type as $tt)
                    @php
                        $toursByType = App\Models\Backend\TourModel::where([
                            'type_id' => $tt->id,
                            'status' => 'on',
                            'deleted_at' => null,
                        ])
                            ->orderBy('price', 'asc')
                            ->limit(4)
                            ->get();
                    @endphp

                    <div class="hidden" data-tab-panel="type-{{ $tt->id }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @forelse($toursByType as $tour)
                                @php
                                    $country = \App\Models\Backend\CountryModel::whereIn(
                                        'id',
                                        json_decode(@$tour->country_id, true) ?: [],
                                    )->first();
                                    $airline = \App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                                    $periodsAll = \App\Models\Backend\TourPeriodModel::where([
                                        'tour_id' => @$tour->id,
                                        'status_display' => 'on',
                                    ])
                                        ->whereDate('start_date', '>=', now())
                                        ->whereNull('deleted_at')
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                                    $window = $formatTravelWindow($periodsAll);
                                    $code = @$tour->code1_check ? @$tour->code1 : @$tour->code;
                                    $hasSale = (int) @$tour->special_price > 0;
                                    $priceAfter = $hasSale
                                        ? (int) $tour->price - (int) $tour->special_price
                                        : (int) $tour->price;
                                @endphp

                                {{-- ใช้การ์ดเดียวกับด้านบน --}}
                                <article class="group bg-white overflow-hidden rounded-2xl shadow-sm ring-1 ring-black/5">
                                    <div class="relative">
                                        <div class="relative aspect-[1/1] overflow-hidden">
                                            <a href="https://nexttripholiday.com/tour/{{ $tour->slug }}"
                                                target="_blank">
                                                <img src="https://nexttripholiday.b-cdn.net/{{ @$tour->image }}"
                                                    alt="{{ $tour->name }}"
                                                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                            </a>
                                        </div>

                                    </div>
                                    <div class="p-5">
                                        <div class="text-[#f0742f] text-sm font-semibold">{{ $tour->num_day }}</div>
                                        <h3 class="mt-1 text-lg font-extrabold leading-snug text-slate-900">
                                            <a href="https://nexttripholiday.com/tour/{{ $tour->slug }}"
                                                target="_blank">{{ $tour->name }}</a>
                                        </h3>
                                        <ul class="mt-3 space-y-2 text-[13px] text-slate-600">
                                            <li class="flex items-center gap-2">
                                                <!-- airplane (outline) -->
                                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500"
                                                    fill="none" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.5 12.75l-6.364 6.364a.75.75 0 001.06 1.06L12 13.06l6.803 7.115a.75.75 0 001.198-.905l-7.5-18a.75.75 0 00-1.386 0l-7.5 18a.75.75 0 001.198.905L10.5 12.75z" />
                                                </svg>
                                                สายการบิน <img
                                                    src="https://nexttripholiday.b-cdn.net/{{ @$airline->image }}"
                                                    alt="{{ @$airline->name }}">
                                            </li>



                                            <li class="flex items-center gap-2">
                                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                    <path fill="currentColor"
                                                        d="M19 4H5a2 2 0 00-2 2v13l4-4h12a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                                </svg>
                                                {{ $window ?? 'กำหนดการเดินทางอัปเดต' }}
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                    <path fill="currentColor"
                                                        d="M17 3H7a2 2 0 00-2 2v14l7-3 7 3V5a2 2 0 00-2-2z" />
                                                </svg>
                                                รหัสทัวร์ {{ $code }}
                                            </li>
                                        </ul>
                                        <div class="mt-4 flex items-end justify-between">
                                            <span class="text-slate-500 text-sm">เริ่มต้น</span>
                                            <div class="text-right">
                                                @if ($hasSale)
                                                    <div class="text-xs text-slate-400 line-through">ปกติ
                                                        {{ number_format($tour->price, 0) }} THB</div>
                                                @endif
                                                <div class="text-[20px] font-extrabold tracking-tight text-rose-600">
                                                    {{ number_format($priceAfter, 0) }} THB
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div
                                    class="col-span-full rounded-2xl bg-white p-10 text-center ring-1 ring-black/5 text-slate-500">
                                    ยังไม่มีแพ็กเกจในหมวดนี้
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach

                {{-- ========== Panel: Sale ========== --}}
                <div class="hidden" data-tab-panel="sale">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($tour_price as $tour)
                            @php
                                $country = \App\Models\Backend\CountryModel::whereIn(
                                    'id',
                                    json_decode(@$tour->country_id, true) ?: [],
                                )->first();
                                $airline = \App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                                $periodsAll = \App\Models\Backend\TourPeriodModel::where([
                                    'tour_id' => @$tour->id,
                                    'status_display' => 'on',
                                ])
                                    ->whereDate('start_date', '>=', now())
                                    ->whereNull('deleted_at')
                                    ->orderBy('start_date', 'asc')
                                    ->get();
                                $window = $formatTravelWindow($periodsAll);
                                $code = @$tour->code1_check ? @$tour->code1 : @$tour->code;
                                $hasSale = (int) @$tour->special_price > 0;
                                $priceAfter = $hasSale
                                    ? (int) $tour->price - (int) $tour->special_price
                                    : (int) $tour->price;
                            @endphp

                            {{-- Card --}}
                            <article class="group bg-white overflow-hidden rounded-2xl shadow-sm ring-1 ring-black/5">
                                <div class="relative">
                                    <div class="relative aspect-[1/1] overflow-hidden">
                                        <a href="https://nexttripholiday.com/tour/{{ $tour->slug }}" target="_blank">
                                            <img src="https://nexttripholiday.b-cdn.net/{{ @$tour->image }}"
                                                alt="{{ $tour->name }}"
                                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                        </a>
                                    </div>

                                </div>
                                <div class="p-5">
                                    <div class="text-[#f0742f] text-sm font-semibold">{{ $tour->num_day }}</div>
                                    <h3 class="mt-1 text-lg font-extrabold leading-snug text-slate-900">
                                        <a href="https://nexttripholiday.com/tour/{{ $tour->slug }}"
                                            target="_blank">{{ $tour->name }}</a>
                                    </h3>
                                    <ul class="mt-3 space-y-2 text-[13px] text-slate-600">
                                        <li class="flex items-center gap-2">
                                            <!-- airplane (outline) -->
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500"
                                                fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 12.75l-6.364 6.364a.75.75 0 001.06 1.06L12 13.06l6.803 7.115a.75.75 0 001.198-.905l-7.5-18a.75.75 0 00-1.386 0l-7.5 18a.75.75 0 001.198.905L10.5 12.75z" />
                                            </svg>
                                            สายการบิน <img src="https://nexttripholiday.b-cdn.net/{{ @$airline->image }}"
                                                alt="{{ @$airline->name }}">
                                        </li>

                                        <li class="flex items-center gap-2">
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                <path fill="currentColor"
                                                    d="M19 4H5a2 2 0 00-2 2v13l4-4h12a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                            </svg>
                                            {{ $window ?? 'กำหนดการเดินทางอัปเดต' }}
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] text-slate-500">
                                                <path fill="currentColor"
                                                    d="M17 3H7a2 2 0 00-2 2v14l7-3 7 3V5a2 2 0 00-2-2z" />
                                            </svg>
                                            รหัสทัวร์ {{ @$tour->code1_check ? @$tour->code1 : @$tour->code }}
                                        </li>
                                    </ul>
                                    <div class="mt-4 flex items-end justify-between">
                                        <span class="text-slate-500 text-sm">เริ่มต้น</span>
                                        <div class="text-right">
                                            @if ($hasSale)
                                                <div class="text-xs text-slate-400 line-through">ปกติ
                                                    {{ number_format($tour->price, 0) }} THB</div>
                                            @endif
                                            <div class="text-[20px] font-extrabold tracking-tight text-rose-600">
                                                {{ number_format($priceAfter, 0) }} THB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Popular Tours -->
    <section id="popular" class="mx-auto max-w-7xl px-4 pt-14 pb-20">
        <div class="flex items-end justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800">แพ็คเกจยอดนิยม</h2>
            <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-700">ดูทั้งหมด →</a>
        </div>
        @php
            $baseParams = 'auto=compress&fit=crop&q=60&fm=webp&w=600';
            $tours = [
                [
                    'title' => 'ญี่ปุ่น ฟูจิ',
                    'duration' => '5 วัน 3 คืน',
                    'price' => 'เริ่ม 32,900',
                    'image' => "https://images.unsplash.com/photo-1506744038136-46273834b3fb?$baseParams",
                    'availability' => 'เปิด 6 ที่',
                ],
                [
                    'title' => 'เกาหลี โซล',
                    'duration' => '4 วัน 3 คืน',
                    'price' => 'เริ่ม 18,500',
                    'image' =>
                        'https://plus.unsplash.com/premium_photo-1661886323367-fc6579695eba?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8S29yZWElMkMlMjBTZW91bHxlbnwwfHwwfHx8MA%3D%3D',
                    'availability' => 'เหลือ 4 ที่',
                ],
                [
                    'title' => 'จีน พรีเมียม',
                    'duration' => '6 วัน 4 คืน',
                    'price' => 'เริ่ม 29,900',
                    'image' =>
                        'https://images.unsplash.com/photo-1507904309054-5d475df55c14?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fEhvbmclMjBLb25nfGVufDB8fDB8fHww',
                    'availability' => 'รับเพิ่ม',
                ],
            ];
        @endphp
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($tours as $tour)
                <x-tour-card :image="$tour['image']" :title="$tour['title']" :duration="$tour['duration']" :price="$tour['price']" :availability="$tour['availability']" />
            @endforeach
        </div>
    </section>
 --}}




    {{-- 
    <!-- Tour Categories (booking intent) -->
    <section id="categories" class="mx-auto max-w-7xl px-4 pb-24">
        <h2 class="text-2xl font-bold text-slate-800 mb-8">เลือกสไตล์ทัวร์ของคุณ</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 text-sm">
            @foreach ([['ทะเล & พักผ่อน', 'beach', 'ทัวร์ทะเล ดำน้ำ พักรีสอร์ท'], ['ธรรมชาติ & ภูเขา', 'mountain', 'เดินป่า ซากุระ ใบไม้เปลี่ยนสี'], ['ช้อปปิ้ง & เมือง', 'city', 'ช้อปปิ้ง เอาต์เล็ท เมืองใหญ่'], ['อาหาร & วัฒนธรรม', 'food', 'ลิ้มรสท้องถิ่น เวิร์คช็อปวัฒนธรรม']] as $c)
                <a href="#"
                    class="group rounded-2xl border border-slate-200 p-5 bg-white hover:shadow-md transition flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        <span
                            class="h-9 w-9 rounded-full bg-orange-50 grid place-content-center text-orange-600 text-xs font-semibold ring-1 ring-orange-600/20">{{ strtoupper(substr($c[1], 0, 2)) }}</span>
                        <h3 class="font-semibold text-slate-800 group-hover:text-orange-600">{{ $c[0] }}</h3>
                    </div>
                    <p class="text-slate-500 text-xs leading-relaxed flex-1">{{ $c[2] }}</p>
                    <span class="mt-4 inline-flex items-center gap-1 text-orange-600 text-xs font-medium">ดูแพ็คเกจ <svg
                            class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 5l7 7-7 7" />
                        </svg></span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Booking Steps (improved layout) -->
    <section id="steps" class="bg-gradient-to-b from-amber-50/40 to-white">
        <div class="mx-auto max-w-7xl px-4 py-20">
            <h2 class="text-2xl font-bold text-slate-800 text-center mb-12">ขั้นตอนการจองง่ายๆ 4 ขั้น</h2>
            <div class="grid gap-5 md:grid-cols-4">
                @foreach ([['ส่งคำค้นหา', 'กรอกปลายทาง งบประมาณ หรือเลือกแพ็คเกจที่สนใจ'], ['รับใบเสนอราคา', 'ทีมงานสรุปรายการ โปรแกรม และราคาโปรโมชัน'], ['ยืนยัน & ชำระ', 'ชำระด้วยช่องทางที่สะดวก อัปเดตสถานะเรียลไทม์'], ['เตรียมเดินทาง', 'รับเอกสารการเดินทาง eVoucher / รายละเอียดไกด์']] as $i => $s)
                    <div
                        class="relative rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-6 flex flex-col overflow-hidden group">
                        <span
                            class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-orange-50 ring-1 ring-orange-500/10"></span>
                        <div class="flex items-center gap-3 mb-3 relative">
                            <span
                                class="h-9 w-9 rounded-full bg-orange-600 text-white text-sm font-semibold grid place-content-center shadow">{{ $i + 1 }}</span>
                            <h3 class="font-semibold text-slate-800 group-hover:text-orange-600 transition">
                                {{ $s[0] }}</h3>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed flex-1">{{ $s[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- removed stray closing tags from previous template experiment --> --}}

    <!-- Upcoming Departures Table -->
    {{-- <section id="departures" class="mx-auto max-w-7xl px-4 pt-8 pb-28">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800">รอบเดินทางใกล้เต็ม</h2>
            <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-700">ดูรอบทั้งหมด →</a>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold w-[40%]">แพ็คเกจ</th>
                        <th class="px-3 py-3 text-left font-semibold">เดินทาง</th>
                        <th class="px-3 py-3 text-center font-semibold w-24">ที่ว่าง</th>
                        <th class="px-3 py-3 text-right font-semibold w-28">ราคา</th>
                        <th class="px-4 py-3 w-32"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ([['ญี่ปุ่น ฟูจิ ซากุระ', '15 เม.ย. 68', '6', '32,900'], ['เกาหลี โซล ใบไม้ผลิ', '22 เม.ย. 68', '4', '18,500'], ['จีน พรีเมียม เซี่ยงไฮ้', '3 พ.ค. 68', '8', '29,900'], ['เวียดนาม ฮาลองเบย์', '10 พ.ค. 68', '5', '16,900']] as $d)
                        <tr class="hover:bg-amber-50/40 transition">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $d[0] }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $d[1] }}</td>
                            <td class="px-3 py-3 text-center">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 text-[11px] font-semibold h-7 w-12 ring-1 ring-emerald-500/20">{{ $d[2] }}</span>
                            </td>
                            <td class="px-3 py-3 text-right text-orange-700 font-semibold">{{ $d[3] }} ฿</td>
                            <td class="px-4 py-3 text-right"><a href="#"
                                    class="inline-flex items-center text-orange-600 text-xs font-medium hover:text-orange-700">ดูรายละเอียด
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 5l7 7-7 7" />
                                    </svg></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section> --}}

    <!-- Destinations -->
    {{-- <section id="destinations" class="bg-gradient-to-b from-white to-amber-50/40">
        <div class="mx-auto max-w-7xl px-4 py-16">
            <div class="flex items-end justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-800">ปลายทางยอดฮิต</h2>
                <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-700">สำรวจทั้งหมด →</a>
            </div>
            @php
                $destinations = [
                    [
                        'title' => 'ญี่ปุ่น',
                        'count' => '1745 โปรแกรม',
                        'image' =>
                            'https://images.unsplash.com/photo-1688616128916-9c4f4a612e33?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fFRvcmlpJTIwU2hyaW5lJTJDJTIwSmFwYW58ZW58MHx8MHx8fDA%3D',
                        'alt' => 'ศาลเจ้าโทริอิ ญี่ปุ่น',
                    ],
                    [
                        'title' => 'เวียดนาม',
                        'count' => '794 โปรแกรม',
                        'image' =>
                            'https://images.unsplash.com/photo-1528181304800-259b08848526?auto=format&fit=crop&w=600&q=70',
                        'alt' => 'ฮาลองเบย์ เวียดนาม',
                    ],
                    [
                        'title' => 'จีน',
                        'count' => '3179 โปรแกรม',
                        'image' =>
                            'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=600&q=70',
                        'alt' => 'เสาหินอุทยานจางเจียเจี้ย จีน',
                    ],
                    [
                        'title' => 'ฮ่องกง',
                        'count' => '681 โปรแกรม',
                        'image' =>
                            'https://images.unsplash.com/photo-1508009603885-50cf7c579365?auto=format&fit=crop&w=600&q=70',
                        'alt' => 'สกายไลน์ฮ่องกงยามค่ำ',
                    ],
                ];
            @endphp
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($destinations as $d)
                    <x-destination-card :image="$d['image']" :alt="$d['alt']" :title="$d['title']" :count="$d['count']" />
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Promo Banner -->
    <section id="promo" class="bg-gradient-to-r from-orange-600 to-orange-700 text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 md:py-20 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold leading-tight">ระวัง !! กลุ่มมิจฉาชีพขายทัวร์และบริการอื่นๆ</h2>
                <p class="mt-4 text-white/90 max-w-prose">โดยแอบอ้างใช้ชื่อบริษัทเน็กซ์ ทริป ฮอลิเดย์
                    กรุณาชำระค่าบริการผ่านธนาคารชื่อบัญชีบริษัท "เน็กซ์ ทริป ฮอลิเดย์ จำกัด" เท่านั้น</p>

            </div>
            <ul class="space-y-4 text-sm" aria-label="benefits">
                <li class="flex items-start gap-3"><span
                        class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/15"><svg
                            class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></span><span>ที่นั่งจำนวนจำกัด เฉพาะเส้นทางยอดนิยม</span></li>
                <li class="flex items-start gap-3"><span
                        class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/15"><svg
                            class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></span><span>ยกเลิกฟรีภายใน 24 ชม.</span></li>
                <li class="flex items-start gap-3"><span
                        class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/15"><svg
                            class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></span><span>บริการผู้เชี่ยวชาญตลอดการเดินทาง</span></li>
            </ul>
        </div>
    </section>

    <!-- Why Us -->
    <!-- Why Us -->
    @php
        $why = [
            [
                'title' => 'ทัวร์คุณภาพ',
                'desc' => 'เราบริการทัวร์คุณภาพมากมาย เพื่อให้ลูกค้าประทับใจในทุกทริป',
                'icon' => 'plane',
            ],
            ['title' => 'เที่ยวครบ คุ้ม', 'desc' => 'เที่ยวครบตามโปรแกรม คุ้มค่าทุกบาททุกสตางค์', 'icon' => 'list'],
            ['title' => 'เชื่อถือได้', 'desc' => 'ประสบการณ์มากกว่า 15 ปี กับวงการท่องเที่ยว', 'icon' => 'shield'],
            ['title' => 'ส่วนลดพิเศษ', 'desc' => 'รับส่วนลด/โปรพิเศษ อัปเดตทุกวัน', 'icon' => 'discount'],
        ];
    @endphp

    <section id="why" class="mx-auto max-w-7xl px-4 py-16">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-orange-500">ทำไมลูกค้าเลือกเรา</h2>
            <p class="mt-4 text-slate-600">โครงสร้างบริการครบวงจร คัดกรองคุณภาพคู่ค้า และระบบดูแลลูกค้าหลังการขาย</p>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($why as $w)
                <div
                    class="group rounded-2xl border border-slate-200 p-6 bg-white/70 backdrop-blur-sm hover:shadow-md transition">
                    <div class="flex items-start gap-4">
                        <!-- Icon bubble -->
                        <span
                            class="relative grid h-12 w-12 place-items-center rounded-xl
                       bg-gradient-to-br from-orange-50 to-amber-100
                       ring-1 ring-orange-200/70 shadow-sm
                       group-hover:scale-105 transition">
                            @switch($w['icon'])
                                @case('plane')
                                    <!-- airplane -->
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-orange-600" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 12.75l-6.364 6.364a.75.75 0 001.06 1.06L12 13.06l6.803 7.115a.75.75 0 001.198-.905l-7.5-18a.75.75 0 00-1.386 0l-7.5 18a.75.75 0 001.198.905L10.5 12.75z" />
                                    </svg>
                                @break

                                @case('list')
                                    <!-- checklist -->
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-orange-600" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" d="M4 7h8M4 12h8M4 17h8" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14 7l2 2 4-4M14 12l2 2 4-4M14 17l2 2 4-4" />
                                    </svg>
                                @break

                                @case('shield')
                                    <!-- shield check -->
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-orange-600" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linejoin="round" d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12l2 2 4-4" />
                                    </svg>
                                @break

                                @case('discount')
                                    <!-- discount / percent tag -->
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-orange-600" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linejoin="round"
                                            d="M3 8a2 2 0 012-2h8l3 3v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                        <path stroke-linecap="round" d="M8 14l6-6" />
                                        <circle cx="7" cy="9" r="1.3" fill="currentColor" />
                                        <circle cx="13" cy="15" r="1.3" fill="currentColor" />
                                    </svg>
                                @break
                            @endswitch
                        </span>

                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">{{ $w['title'] }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $w['desc'] }}</p>
                        </div>
                    </div>

                    <!-- subtle divider -->
                    <div class="mt-4 h-px w-full bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- Booking CTA -->
    <section id="booking" class="mx-auto max-w-7xl px-4 pb-20">
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-50 via-white to-sky-50 ring-1 ring-slate-200 p-10 md:p-16 flex flex-col items-center text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-orange-500 max-w-2xl">พร้อมเริ่มการเดินทางครั้งใหม่แล้วหรือยัง?
            </h2>
            <p class="mt-4 text-blue-900 max-w-xl">ค้นหาทริป หรือเลือกจากแพ็คเกจยอดนิยมแล้วจองทันที</p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="https://nexttripholiday.com/search-tour"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-600 px-8 py-3 text-white text-sm font-semibold shadow hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">ค้นหาทัวร์ที่ใช่</a>
                <a href="https://www.nexttripholiday.com/package/0"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-8 py-3 text-sm font-semibold text-orange-700 ring-1 ring-slate-200 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-orange-500">ดูแพ็คเกจ</a>
            </div>
        </div>
    </section>


    {{-- <!-- Reviews -->
    <section id="reviews" class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800">เสียงจากลูกค้าจริง</h2>
                <p class="mt-4 text-slate-600">บางส่วนของประสบการณ์ที่น่าประทับใจ</p>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @php $reviews = [['title' => 'รีวิวทัวร์ ฮ่องกง', 'text' => 'ไกด์ดูแลดี บริการครบ ราคาโปรคุ้มมาก', 'author' => 'สุธิดา', 'image' => 'https://plus.unsplash.com/premium_photo-1661887277173-f996f36b8fb2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8SG9uZyUyMEtvbmd8ZW58MHx8MHx8fDA%3D', 'rating' => 5], ['title' => 'รีวิวทัวร์ ญี่ปุ่น ซากุระ', 'text' => 'สวยทุกที่ อาหารจัดเต็ม บินตรงตรงเวลา', 'author' => 'ปพิชญา', 'image' => 'https://media.istockphoto.com/id/155356833/photo/pink-cherry-blossoms.webp?a=1&b=1&s=612x612&w=0&k=20&c=_YkO9giMDrhFN4ifm5P-aeRYDHNQ9fOi0X0In4UECes=', 'rating' => 5], ['title' => 'รีวิวทัวร์ เวียดนาม', 'text' => 'สถานที่สวย อากาศดี ทีมงานมืออาชีพ', 'author' => 'รัฐศักดิ์', 'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=70', 'rating' => 4.8]]; @endphp
                @foreach ($reviews as $rev)
                    <x-review-card :title="$rev['title']" :text="$rev['text']" :author="$rev['author']" :image="$rev['image']"
                        :rating="$rev['rating']" />
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Reviews (ใหม่) -->
    <section id="reviews" class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-5">
            <div class="flex items-end justify-between gap-4">
                <div class="text-center md:text-left max-w-2xl">
                    <h2 class="text-2xl md:text-3xl font-bold text-orange-500">เสียงจากลูกค้าจริง</h2>
                    <p class="mt-2 text-slate-600">บางส่วนของประสบการณ์ที่น่าประทับใจ</p>
                </div>

                <a href="{{ url('clients-review/0/0') }}"
                    class="hidden md:inline-flex items-center gap-2 text-orange-600 font-semibold hover:gap-3 transition-all">
                    ดูรีวิวทั้งหมด
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- แทร็ครีวิวเลื่อนซ้าย/ขวา -->
            <div class="relative mt-6">
                <!-- ปุ่มเลื่อน -->
                <button id="revPrev"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 hidden md:grid h-10 w-10 place-items-center rounded-full bg-white/90 ring-1 ring-slate-200 shadow hover:bg-white">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="revNext"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 hidden md:grid h-10 w-10 place-items-center rounded-full bg-white/90 ring-1 ring-slate-200 shadow hover:bg-white">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- แถวรีวิว -->
                <div id="revTrack"
                    class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 md:pb-4
                  [scrollbar-width:none] [-ms-overflow-style:none]">
                    <!-- ซ่อนสกอร์บาร์บน WebKit -->
                    <style>
                        #revTrack::-webkit-scrollbar {
                            display: none
                        }

                        .line-clamp-3 {
                            display: -webkit-box;
                            -webkit-box-orient: vertical;
                            -webkit-line-clamp: 3;
                            overflow: hidden
                        }
                    </style>

                    @foreach ($review as $re)
                        @php
                            $countries = \App\Models\Backend\CountryModel::whereIn(
                                'id',
                                json_decode($re->country_id, true) ?? [],
                            )->get();
                            $rating = $re->rating ?? 5;
                        @endphp

                        <!-- การ์ดรีวิว -->
                        <article
                            class="rev-card snap-start shrink-0 w-[280px] sm:w-[320px] md:w-[360px] lg:w-[380px]
                          bg-white overflow-hidden rounded-2xl ring-1 ring-slate-200 shadow-sm">
                            <a href="https://nexttripholiday.com/clients-review/0/0" class="block group">
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <img src="https://nexttripholiday.b-cdn.net/{{ $re->img }}"
                                        alt="{{ $re->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                </div>

                                <div class="p-5">
                                    <!-- ดาว -->
                                    <div class="flex items-center gap-[2px] text-amber-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg viewBox="0 0 24 24"
                                                class="h-[18px] w-[18px] {{ $i <= round($rating) ? 'fill-current' : 'fill-slate-300 text-slate-300' }}">
                                                <path
                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        @endfor
                                    </div>

                                    <h3 class="mt-2 font-semibold text-slate-800">{{ $re->title }}</h3>
                                    <p class="mt-1 text-sm text-slate-600 line-clamp-3">
                                        {!! strip_tags($re->detail) !!}
                                    </p>

                                    <div class="mt-4 flex items-center gap-3">
                                        <img src="https://nexttripholiday.b-cdn.net/{{ $re->profile }}"
                                            class="h-9 w-9 rounded-full object-cover ring-1 ring-slate-200"
                                            alt="">
                                        <div class="leading-tight">
                                            <div class="font-medium text-slate-800">{{ $re->name }}</div>
                                            <div class="text-xs text-slate-500">ทริป{{ $re->trip }}</div>
                                        </div>
                                    </div>

                                    @if ($countries->count())
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @foreach ($countries as $c)
                                                <a href="{{ url('clients-review/' . $c->id . '/0') }}"
                                                    class="text-xs px-2 py-1 rounded-full bg-orange-500 text-white hover:bg-slate-200">
                                                    #{{ $c->country_name_th }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- ปุ่มดูทั้งหมด (มือถือ) -->
            <div class="mt-6 md:hidden text-center">
                <a href="https://nexttripholiday.com/clients-review/0/0"
                    class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-3 text-white text-sm font-semibold shadow hover:bg-orange-700">
                    ดูรีวิวทั้งหมด
                </a>
            </div>

        </div>
    </section>

    <!-- JS: ปุ่มซ้าย/ขวา สำหรับเลื่อนแถวรีวิว -->
    <script>
        (function() {
            const track = document.getElementById('revTrack');
            if (!track) return;

            const prevBtn = document.getElementById('revPrev');
            const nextBtn = document.getElementById('revNext');

            function step() {
                const card = track.querySelector('.rev-card');
                if (!card) return 320; // fallback
                const style = getComputedStyle(track);
                const gap = parseInt(style.columnGap || style.gap || 24, 10);
                return card.getBoundingClientRect().width + gap;
            }

            prevBtn?.addEventListener('click', () =>
                track.scrollBy({
                    left: -step(),
                    behavior: 'smooth'
                })
            );
            nextBtn?.addEventListener('click', () =>
                track.scrollBy({
                    left: step(),
                    behavior: 'smooth'
                })
            );

            // แสดง/ซ่อนปุ่มอัตโนมัติเมื่อสุดขอบ
            function toggleArrows() {
                if (!prevBtn || !nextBtn) return;
                const maxScrollLeft = track.scrollWidth - track.clientWidth - 1;
                prevBtn.style.visibility = track.scrollLeft <= 0 ? 'hidden' : 'visible';
                nextBtn.style.visibility = track.scrollLeft >= maxScrollLeft ? 'hidden' : 'visible';
            }
            track.addEventListener('scroll', toggleArrows, {
                passive: true
            });
            window.addEventListener('resize', toggleArrows);
            toggleArrows();
        })();
    </script>

    <!-- Clients / Trusted by -->
    <section id="clients" class="py-16">
        <div class="mx-auto max-w-7xl px-4">
            <h2 class="text-center text-2xl md:text-3xl font-bold text-blue-800">
                ลูกค้าที่ไว้วางใจเรา <span class="text-orange-600">Next Trip Holiday</span>
            </h2>

            <!-- Marquee container -->
            <div class="relative mt-8 group overflow-hidden">
                <!-- edge fades -->
                <div class="pointer-events-none absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-white to-transparent">
                </div>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-white to-transparent">
                </div>

                <!-- track: duplicate 2 รอบเพื่อวิ่งต่อเนื่อง -->
                <div
                    class="flex items-center gap-10 animate-logo-marquee group-hover:[animation-play-state:paused] [--speed:28s]">
                    @foreach ($customer as $cus)
                        <a href="https://nexttripholiday.b-cdn.net/{{ $cus->id }}" class="shrink-0"
                            title="{{ $cus->title ?? 'ลูกค้า' }}">
                            <img src="https://nexttripholiday.b-cdn.net/{{ $cus->logo }}"
                                alt="https://nexttripholiday.b-cdn.net/{{ $cus->title ?? 'ลูกค้า' }}" loading="lazy"
                                class="h-12 sm:h-14 md:h-16 w-auto object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition">
                        </a>
                    @endforeach

                    {{-- สำเนาชุดที่ 2 เพื่อให้เลื่อนต่อเนื่องไร้รอยต่อ --}}
                    @foreach ($customer as $cus)
                        <a href="https://nexttripholiday.b-cdn.net/{{ $cus->id }}" aria-hidden="true"
                            class="shrink-0">
                            <img src="https://nexttripholiday.b-cdn.net/{{ $cus->logo }}" alt=""
                                loading="lazy"
                                class="h-12 sm:h-14 md:h-16 w-auto object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition">
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- ปุ่มดูทั้งหมด (ถ้าต้องการ) -->
            <div class="mt-8 text-center">
                <a href="https://nexttripholiday.com/clients-review/0/0"
                    class="inline-flex items-center gap-2 text-orange-600 font-semibold hover:gap-3 transition-all">
                    ดูผลงานลูกค้าทั้งหมด
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <style>
        /* งูกินหาง: มี 2 ชุดโลโก้เรียงต่อกัน เลื่อน -50% เท่าความกว้างชุดแรกพอดี */
        @keyframes logo-marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-logo-marquee {
            animation: logo-marquee var(--speed, 28s) linear infinite;
            will-change: transform;
        }

        /* เคารพผู้ใช้ที่ปิดแอนิเมชัน: ให้เลื่อนเองด้วยการรูดแทน */
        @media (prefers-reduced-motion: reduce) {
            .animate-logo-marquee {
                animation: none;
            }
        }
    </style>



    {{-- <!-- Newsletter -->
    <section id="subscribe" class="bg-gradient-to-r from-amber-500 via-orange-600 to-orange-700 text-white">
        <div class="mx-auto max-w-5xl px-4 py-14 md:py-16 text-center">
            <h2 class="text-2xl md:text-3xl font-bold">รับดีลพิเศษก่อนใคร</h2>
            <p class="mt-3 text-white/90 max-w-2xl mx-auto">สมัครรับข่าวสารโปรโมชันและแพ็คเกจใหม่ อัปเดตรายสัปดาห์
                (ยกเลิกได้ทุกเมื่อ)</p>
            <form class="mt-8 max-w-md mx-auto flex flex-col sm:flex-row gap-3" action="#" method="POST">
                <input type="email" required placeholder="อีเมลของคุณ"
                    class="flex-1 rounded-full border-1 px-5 py-3 text-sm text-white text-slate-700 focus:ring-2 focus:ring-offset-2 focus:ring-white/70" />
                <button
                    class="rounded-full bg-black/30 hover:bg-black/40 px-8 py-3 text-sm  font-semibold backdrop-blur focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/70">สมัคร</button>
            </form>
            <p class="mt-4 text-xs text-white/70">เราไม่ส่งสแปม และไม่ขายข้อมูลส่วนบุคคล</p>
        </div>
    </section> --}}

    @php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => 'TourBooking',
            'url' => 'https://example.com',
            'description' => 'แพลตฟอร์มจองทัวร์คุณภาพ ในและต่างประเทศ',
            'image' => 'https://images.unsplash.com/photo-1499002238440-d264edd596ec?auto=format&fit=crop&w=1600&q=60',
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'reviewCount' => '12540',
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'TH',
            ],
            'sameAs' => ['https://www.facebook.com/', 'https://www.instagram.com/'],
        ];
    @endphp


    <script>
        // Tabs toggle (vanilla JS)
        (function() {
            const tabs = document.querySelectorAll('[role="tab"]');
            const panels = document.querySelectorAll('[data-tab-panel]');

            function activate(id, btn) {
                // reset
                tabs.forEach(t => {
                    t.setAttribute('aria-selected', 'false');
                    t.classList.remove('bg-[#f0742f]', 'text-white', 'shadow');
                    t.classList.add('bg-white', 'text-slate-700', 'ring-1', 'ring-slate-200');
                });
                panels.forEach(p => p.classList.add('hidden'));

                // set active
                btn.setAttribute('aria-selected', 'true');
                btn.classList.add('bg-[#f0742f]', 'text-white', 'shadow');
                btn.classList.remove('bg-white', 'text-slate-700', 'ring-1', 'ring-slate-200');
                const panel = document.querySelector(`[data-tab-panel="${id}"]`);
                panel && panel.classList.remove('hidden');
            }

            tabs.forEach(btn => {
                btn.addEventListener('click', () => {
                    activate(btn.getAttribute('data-tab-target'), btn);
                });
            });
        })();
    </script>

    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

<!-- Removed old delayed background script; hero now uses direct media panel for clarity & aesthetics -->
