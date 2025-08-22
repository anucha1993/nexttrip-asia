<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

   @php
    /** @var \App\Models\Backend\CountryModel|null $country_data */
    $country_data = \App\Models\Backend\CountryModel::find($country_search);
    $countryName  = $country_data->country_name_th ?? 'ทัวร์ต่างประเทศ';

    // รองรับเลขหน้า (กัน Duplicate จาก ?page=2 เป็นต้น)
    $page = max((int) request('page', 1), 1);
    $canonical = $page > 1 ? url()->current().'?page='.$page : url()->current();

    // รูปแชร์ (มี slug ใช้ได้ยิ่งดี; ถ้าไม่มี จะ fallback เป็นภาพ default)
    $countrySlug = $country_data->slug ?? Str::slug($countryName, '-');
    $ogImage = "https://nexttripholiday.b-cdn.net/og/country/{$countrySlug}.jpg";
@endphp

{{-- ======= SEO: ทัวร์ต่างประเทศ/ประเทศ ======= --}}
@section('title', "Next Trip Holiday ทัวร์ต่างประเทศ | {$countryName}".($page>1?" (หน้า {$page})":""))
@section('meta_description', "แพ็กเกจทัวร์{$countryName} ราคาคุ้ม อัปเดตรายสัปดาห์ เดินทางสบาย โรงแรมดี ไกด์ดูแลตลอดทริป จองกับ Next Trip Holiday มั่นใจได้")

{{-- ไม่ต้องใช้ meta keywords แล้ว (Google ไม่ใช้) --}}
<link rel="canonical" href="{{ $canonical }}"/>
<meta name="robots" content="index, follow"/>

{{-- Open Graph --}}
<meta property="og:type" content="website"/>
<meta property="og:title" content="Next Trip Holiday ทัวร์ต่างประเทศ | {{ $countryName }}{{ $page>1 ? " (หน้า {$page})" : "" }}"/>
<meta property="og:description" content="แพ็กเกจทัวร์{{ $countryName }} ราคาคุ้ม อัปเดตรายสัปดาห์ เดินทางสบาย โรงแรมดี ไกด์ดูแลตลอดทริป"/>
<meta property="og:url" content="{{ $canonical }}"/>
<meta property="og:site_name" content="Next Trip Holiday"/>
<meta property="og:image" content="{{ $ogImage }}"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:image:alt" content="ทัวร์{{ $countryName }} - Next Trip Holiday"/>

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="Next Trip Holiday ทัวร์ต่างประเทศ | {{ $countryName }}{{ $page>1 ? " (หน้า {$page})" : "" }}"/>
<meta name="twitter:description" content="แพ็กเกจทัวร์{{ $countryName }} ราคาคุ้ม อัปเดตรายสัปดาห์ เดินทางสบาย โรงแรมดี ไกด์ดูแลตลอดทริป"/>
<meta name="twitter:image" content="{{ $ogImage }}"/>

{{-- JSON-LD: Breadcrumb แบบสั้น --}}
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"หน้าหลัก","item":"https://nexttripholiday.com/"},
    {"@type":"ListItem","position":2,"name":"ทัวร์ต่างประเทศ","item":"https://nexttripholiday.com/abroad/"},
    {"@type":"ListItem","position":3,"name":"{{ $countryName }}","item":"{{ $canonical }}"}
  ]
}
</script>


    @include("frontend.layout.inc_header")
  

    
</head>

<body>
    @include("frontend.layout.inc_topmenu")

    <style>
/* ===== Card Layout ===== */
.tour-card-container{
  display:grid;
  grid-template-areas:
    "img info"
    "period period"
    "btn btn";
  grid-template-columns: 340px 1fr;
  gap:20px;
  padding:16px;
  border:1px solid #eef1f4;
  border-radius:14px;
  background:#fff;
  box-shadow:0 2px 10px rgba(0,0,0,.04);
  margin-bottom:18px;
}
.tour-card-image-section{ grid-area: img; }
.tour-card-details-section{ grid-area: info; }
.tour-period-section{ grid-area: period; }
.btn-details{ grid-area: btn; }

/* Image Section */
.tour-card-image-section{
  position:relative; border-radius:12px; overflow:hidden;
background:#f6f7f9;
}
.tour-image{ width:100%; height:100%; object-fit:cover; transition:.3s; }
.tour-card-image-section:hover .tour-image{ transform:scale(1.05); }

/* Price Tags */
.tour-price-tag, .tour-special-price-tag{
  position:absolute; right:10px; bottom:10px;
  background:#fff; border-radius:10px; padding:8px 10px;
  border:1px solid #eef1f4; box-shadow:0 2px 6px rgba(0,0,0,.06);
}
.tour-price-tag b{ color:#ef6c00; }
.tour-special-price-tag span{ color:#ef4444; font-size:12px; }
.tour-special-price-tag b{ color:#ef4444; }

/* Wishlist Button */
.wishlist-btn{
  position:absolute; right:10px; top:10px;
  width:36px; height:36px; border-radius:50%;
  background:#fff; border:1px solid #eef1f4;
  color:#ff5171; display:grid; place-items:center;
}

/* SOLD OUT Overlay */
.tour-sold-out-overlay{
  position:absolute; inset:0; background:rgba(0,0,0,.45);
  display:flex; flex-direction:column; justify-content:center; align-items:center;
  color:#fff; gap:10px;
}

/* หัวข้อทัวร์ – สวย เรียบ อ่านง่าย */
.tour-title{
  margin: 2px 0 10px;
  line-height: 1.35;
  font-size: 20px;          /* ปรับตามใจ 18–22 ก็สวย */
  font-weight: 700;
  color: #111827;           /* เทาเกือบดำ */
  display: -webkit-box;     /* ตัดบรรทัดไม่เกิน 2 บรรทัด */
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  word-break: break-word;   /* ช่วยตัดคำไทย/อังกฤษ */
  overflow-wrap: anywhere;
}

.tour-title a{
  color: inherit;           /* ใช้สีเดียวกับหัวข้อ */
  text-decoration: none;    /* เอาเส้นใต้เริ่มต้นออก */
}

/* Hover/Focus ให้รู้สึกเป็นลิงก์ แต่ยังดูเรียบ */
.tour-title a:hover{
  color: #f15a22;           /* ส้มตามธีม */
  text-decoration: underline;
  text-underline-offset: 3px;
}

.tour-title a:focus-visible{
  outline: 2px solid #f59e0b;   /* วงโฟกัสเพื่อการเข้าถึง */
  outline-offset: 2px;
}

/* ป้องกันสีลิงก์ visited เป็นม่วง */
.tour-title a:visited{
  color: inherit;
}

.tour-info-list{ list-style:none; padding:0; margin:0; }
.tour-info-list li{ font-size:14px; margin-bottom:6px; color:#4b5563; }
.tour-description{ font-size:14px; color:#6b7280; }

/* หัวข้อ */
.period-header{
  font-size:15px; font-weight:700; margin:0 0 8px; color:#111;
}

/* คอนเทนเนอร์รวมทุกเดือน */
.period-rows{
  display:flex; flex-direction:column; gap:10px;
}

/* 1 แถวของเดือน */
.period-row{
  display:grid;
  grid-template-columns: auto 1fr;
  align-items:start;
  gap:14px;
  padding:2px 0 2px;
  border-bottom:1px solid #eef1f4;
}

/* ป้ายเดือน */
.month-badge{
  display:inline-flex; align-items:center; justify-content:center;
  padding:6px 10px; min-width:60px;
  background:#ffedd5; color:#ef4422; /* โทนแดงอ่อน */
  font-weight:700; border-radius:6px;
}

/* กล่องช่วงวันที่ */
.date-list{
  display:flex; flex-wrap:wrap; gap:8px 12px;
}

/* date-chip = บล็อกราคา/วันที่ */
.date-chip{
  min-width:70px;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  padding:6px 8px;
  border-radius:6px;
  background:#fff; border:1px solid #f3f4f6;
  text-align:center;
}

/* ราคาอยู่ด้านบน */
.chip-price{
  font-size:11px; color:#ef4422; font-weight:700; line-height:1.2;
}

/* วันที่อยู่ด้านล่าง */
.chip-date{
  font-size:12px; color:#6b7280; line-height:1.2;
}

/* Responsive */
@media(max-width:640px){
  .date-chip{ min-width:60px; padding:5px; }
  .chip-price{ font-size:11px; }
  .chip-date{ font-size:11px; }
}


.tour-card-footer{
  display:flex;
  align-items:center;
  justify-content:space-between; 
  margin-top:12px;
  padding-top:12px;     /* มีแค่ด้านบน */
  border-top:1px solid #f3f4f6;
}

/* ราคาอยู่ซ้าย */
.footer-price{
  font-size:16px;
  color:#ef6c00;
  font-weight:700;
}

/* ปุ่มอยู่ขวาสุด */
.btn-details{
  margin-left:auto;      /* ดันไปขวาสุด */
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:10px 20px;
  background:#ef6c00;
  color:#fff;
  font-weight:700;
  border-radius:10px;
  text-decoration:none;
  transition:.2s;
}
.btn-details:hover{ filter:brightness(.95); }

.tour-card-container{
  display:grid;
  grid-template-areas:
    "img info"
    "period period"
    "footer footer";
  grid-template-columns: 340px 1fr;
  padding:16px 0 16px 16px;   /* ← ตัด padding ขวาออก */
}

.tour-card-footer{
  grid-area:footer;
  padding-right:16px;  /* ให้ footer handle เอง */
}

/* รายการข้อมูลสั้น ๆ */
.tour-info-list{
  list-style:none; padding:0; margin:0 0 8px;
  display:grid; grid-template-columns:1fr; gap:6px;
}
.tour-info-list li{ display:flex; align-items:center; gap:8px; font-size:14px; color:#4b5563; }
.tour-icon{ color:#ef6c00; }

/* โรงแรม + สายการบิน */
.detail-inline{ flex-wrap:wrap; }
.detail-inline .dot-sep{ width:4px; height:4px; border-radius:50%; background:#d1d5db; margin:0 6px; }

/* ชิปกิจกรรม */
.feature-chips{ display:flex; flex-wrap:wrap; gap:8px; margin:4px 0 10px; }
.chip{
  display:inline-flex; align-items:center; gap:6px;
  font-size:12px; color:#ef6c00; background:#fff7ed;
  border:1px solid #ffedd5; border-radius:10px; padding:6px 10px; font-weight:700;
}

/* คำอธิบายใต้รายละเอียด */
.tour-description-block{ color:#6b7280; font-size:14px; }

/* footer ปุ่มชิดขวาสุด (คุณมีอยู่แล้ว — เผื่อย้ำ) */
.tour-card-footer{ display:flex; align-items:center; justify-content:space-between; margin-top:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
.btn-details{ margin-left:auto; }

/* ===== Collapsible Box ===== */
.period-collapsible{
  max-height: 180px;           /* ความสูงโหมด "ย่อ" */
  overflow: hidden;
  position: relative;
}
.period-collapsible::after{
  content:"";
  position:absolute; left:0; right:0; bottom:0;
  height:40px;
  background: linear-gradient(to bottom, rgba(255,255,255,0), #fff);
}
.period-collapsible.expanded{ max-height: none; }
.period-collapsible.expanded::after{ display:none; }
.period-collapsible.no-overflow::after{ display:none; }

/* Toggle button row (align right) */
.period-toggle-row{
  display:flex; justify-content:flex-end;
  margin-top:8px;
}
.period-toggle-btn{
  background:transparent;
  border:none;
  cursor:pointer;
  color:#ef6c0073;
  font-weight:500;      /* ลดความหนา */
  font-size:13px;       /* ลดขนาดตัวอักษร */
  display:inline-flex;
  align-items:center;
  gap:4px;
  padding:2px 6px;      /* เพิ่ม padding เล็กน้อย */
}
.period-toggle-btn:hover{ text-decoration: underline; }

/* ===== Existing period layout (keep / adjust as needed) ===== */
.period-rows{ display:flex; flex-direction:column; gap:10px; }
.period-row{
  display:grid; grid-template-columns:auto 1fr; gap:14px;
  align-items:start; padding:4px 0 10px; border-bottom:1px solid #eef1f4;
}
.month-badge{
  display:inline-flex; align-items:center; justify-content:center;
  padding:6px 10px; min-width:60px;
  background:#fee2e2; color:#dc2626; font-weight:700; border-radius:6px;
}
.date-list{ display:flex; flex-wrap:wrap; gap:8px 12px; }
.date-chip{
  min-width:70px; display:flex; flex-direction:column; align-items:center;
  padding:6px 8px; border-radius:6px; background:#fff; border:1px solid #f3f4f6; text-align:center;
}

.chip-date{ font-size:12px; color:#6b7280; line-height:1.2; }

@media (max-width:640px){
  .period-collapsible{ max-height: 160px; }
}





    </style>

<script>
// คำนวณความสูงของ N แถวแรก แล้วตั้งเป็น max-height (collapsed)
function setCollapsedHeights(){
  document.querySelectorAll('.period-collapsible').forEach(box=>{
    const rows = box.querySelectorAll('.period-row');
    const n = parseInt(box.dataset.collapsedRows || '2', 10);
    if (rows.length <= n){            // ไม่เกิน 2 แถว → ไม่ต้องมีปุ่ม/ไม่ต้องย่อ
      const toggleRow = box.nextElementSibling;
      if (toggleRow && toggleRow.classList.contains('period-toggle-row')) toggleRow.style.display = 'none';
      box.classList.add('no-overflow');
      return;
    }
    let h = 0;
    for (let i=0; i<n && i<rows.length; i++){ h += rows[i].offsetHeight; }
    const gap = parseFloat(getComputedStyle(box.querySelector('.period-rows')).rowGap || '10');
    h += gap;                  // เผื่อช่องว่างระหว่างแถว
    box.style.maxHeight = h + 'px';
    box.dataset.collapsedHeight = String(h);   // เก็บไว้ใช้ตอนย่อกลับ
  });
}

// สลับ expand/collapse
document.addEventListener('click', (e)=>{
  const btn = e.target.closest('.period-toggle-btn');
  if(!btn) return;
  const id = btn.dataset.target;
  const box = document.getElementById(id);
  if(!box) return;

  const expanded = box.classList.toggle('expanded');
  const label = btn.querySelector('.label');
  const icon  = btn.querySelector('i');

  if (expanded){
    box.style.maxHeight = 'none';
    if(label) label.textContent = 'ย่อช่วงเวลา';
    if(icon){ icon.classList.remove('bi-chevron-down'); icon.classList.add('bi-chevron-up'); }
  }else{
    const h = box.dataset.collapsedHeight ? parseFloat(box.dataset.collapsedHeight) : 0;
    if (h>0) box.style.maxHeight = h + 'px';
    if(label) label.textContent = 'ดูช่วงเวลาทั้งหมด';
    if(icon){ icon.classList.add('bi-chevron-down'); icon.classList.remove('bi-chevron-up'); }
  }
});

document.addEventListener('DOMContentLoaded', setCollapsedHeights);
// ถ้าโหลดการ์ดเพิ่มแบบ AJAX ให้เรียก setCollapsedHeights() หลัง append เสมอ
</script>




    <section id="protourpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        @if($banner)
                            <img src="{{asset($banner)}}" alt="">
                        @else
                            <img src="{{asset('frontend/images/oversea.webp')}}" alt="">
                        @endif
                        
                        <div class="categoryslidegroup" id="hide_slide">
                            <div class="categoryslide_list owl-carousel owl-theme" id="slide_country">

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="socialshare">
                @php
                    $urlSharer = url()->current();
                    $lineUrl = "https://social-plugins.line.me/lineit/share?url=".$urlSharer;
                    $facebookUrl = "https://www.facebook.com/sharer.php?u=".$urlSharer;
                    $twitterUrl = "https://twitter.com/intent/tweet?url={$urlSharer}";
                @endphp
                <span>แชร์</span>
                <ul>
                    <li><a href="{{url($lineUrl)}}" target="_blank">
                            <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="{{url($facebookUrl)}}" target="_blank">
                            <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="{{url($twitterUrl)}}" target="_blank" id="shareFB">
                            <img src="{{asset('frontend/images/twitter_share.svg')}}" alt="">
                        </a></li>
                    <li class="copylink"><a href="javascript:void(0);" id="copyButton"><i class="fi fi-rr-link-alt"></i></a></li>
                </ul>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                               
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item"><a href="{{url('/search-tour')}}">ทัวร์ต่างประเทศ </a></li>

                                <li class="breadcrumb-item active" aria-current="page"><a href="{{@$country_data->country_name_en}}">ทัวร์{{@$country_data->country_name_th}}</a></li>
                                {{--<div class="bannercaption">
                                    {!! @$banner_detail !!} 
                                    --}}
                                  <div class="bannercaption alert-banner" id="alertBanner">
  <div class="alert-content">
    {!! @$banner_detail !!}
  </div>
  <button class="alert-close" onclick="document.getElementById('alertBanner').style.display='none'">
    &times;
  </button>
</div>
<style>
    .alert-banner {
  position: relative;
  background: #ef6c001a;   /* พื้นหลังโทนเหลืองอ่อน */
  border: 1px solid #ffcc80;
  border-radius: 6px;
  padding: 12px 40px 12px 16px;
  font-size: 14px;
  line-height: 1.6;
  color: #5d4037;
  margin: 12px 0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.alert-banner a {
  color: #ef6c00;
  font-weight: 500;
  text-decoration: underline;
}

.alert-close {
  position: absolute;
  top: 8px;
  right: 12px;
  background: none;
  border: none;
  font-size: 20px;
  color: #ef6c00;
  cursor: pointer;
  font-weight: bold;
  line-height: 1;
}
.alert-close:hover {
  color: #d84315;
}

</style>

                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            {{-- @include("frontend.layout.inc_sidefilter_tour") --}}
                            <section id="sortfilter">
                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                    <div class="boxfilter shadow-lg" style="border: 1px solid #ef6c0049; border-radius: 5px;">
                                        <div class="row">
                                            <div class="col-8 col-lg-9">
                                                <div class="titletopic">
                                                    <h2>ตัวกรองที่เลือก</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_select_date"></ul>
                                                    <ul id="show_keyword"></ul>
                                                    <ul id="show_code"></ul>
                                                    <ul id="show_select"></ul>
                                                </div>
                                            </div>
                                            <div class="col-4 col-lg-3 text-end">
                                                <a href="javascript:void(0)" onClick="clear_filter()" class="refreshde" >ล้างค่า</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="boxfilter mt-3 shadow-lg " style="border: 1px solid #ef6c0049; border-radius: 5px;">
                                            <div id="hide_date">
                                                <div class="titletopic">
                                                    <h2>ช่วงวันเดินทาง</h2>
                                                </div>
                                                <div class="col-lg-12"  style="margin-top:20px;">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                                <input type="text" class="form-control" name="daterange" id="hide_date_select" />
                                                                <input type="hidden" name="start_date" id="s_date" />
                                                                <input type="hidden" name="end_date" id="e_date" />
                                                                <div class="form-control"   id="show_date_calen" onClick="show_datepicker()" ></div>
                                                                <div class="form-control"  id="show_end_calen" onClick="show_datepicker()" ></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="hide_month">
                                                <div class="titletopic" id="month-topic">
                                                    <h2>ช่วงเดือน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_month"></ul>
                                                </div> 
                                            </div>
                                            <div id="hide_holiday">  
                                                <div class="titletopic" id="holiday-topic" >
                                                    <h2>วันหยุด</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_holiday"></ul>
                                                </div>   
                                            </div>
                                            <div class="titletopic" id="country-topic" hidden>
                                                <h2>ประเทศ</h2>
                                            </div>
                                            <div class="filtermenu" hidden>
                                                <div class="input-group mb-3" id="country_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาชื่อประเทศ"  id="find_country"  aria-label="air"
                                                        aria-describedby="button-addon2" onKeyUp="find_country()">
                                                </div>
                                                <ul id="show_country"></ul>
                                            </div>   
                                            <div class="titletopic" id="city-topic">
                                                <h2>เมือง</h2>
                                            </div>
                                            <div class="filtermenu">
                                                @if($isWin || $isMac)
                                                <div class="input-group mb-3" id="city_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาชื่อเมือง"  id="find_city"  aria-label="air"
                                                        aria-describedby="button-addon2" onKeyUp="find_city()">
                                                </div>
                                                @endif
                                                <ul id="show_city"></ul>
                                            </div>   
                                            <div class="titletopic" id="amupur-topic" hidden>
                                                <h2>อำเภอ</h2>
                                            </div>
                                            <div class="filtermenu" hidden>
                                                <ul id="show_amupur"></ul>
                                            </div>   
                                            <div class="titletopic" id="price-topic">
                                                <h2>ช่วงราคา</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_price"></ul>
                                            </div>   
                                            <div class="titletopic" id="day-topic">
                                                <h2>เลือกจำนวนวัน</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_day"></ul>
                                            </div>   
                                            <div class="titletopic" id="airline-topic">
                                                <h2>สายการบิน</h2>
                                            </div>
                                            <div class="filtermenu">
                                                @if($isWin || $isMac)
                                                <div class="input-group mb-3" id="airline_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาสายการบิน"  id="find_airline"  aria-label="air"
                                                        aria-describedby="button-addon2" onKeyUp="find_airline()">
                                                </div>
                                                @endif
                                                <ul id="show_airline"></ul>
                                            </div>   
                                            <div class="titletopic" id="rating-topic">
                                                <h2>ระดับดาวที่พัก</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_rating"></ul>
                                            </div>  
                                    </div> 
                                </div>
                                
                                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                    <button class="btn btnfilter" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                        aria-controls="offcanvasBottom">ตัวกรอง</button>
                            
                                    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                                        aria-labelledby="offcanvasBottomLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="offcanvasBottomLabel">กรองการค้นหา <a href="javascript:void(0)" onClick="clear_filter()" class="refreshde">ล้างค่า</a> </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <ul id="show_select_date_mb"></ul>
                                        <ul id="show_keyword_mb"></ul>
                                        <ul id="show_code_mb"></ul>
                                        <ul id="show_select_mb"></ul>
                                        <div class="offcanvas-body small">
                                            <div class="boxfilter">
                                                <div id="hide_date_mb">
                                                    <div class="titletopic">
                                                        <h2>ช่วงวันเดินทาง</h2>
                                                    </div>
                                                    <div class="col-lg-12"  style="margin-top:20px;">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                                    <input type="text" class="form-control" name="daterange" id="hide_date_select_mb" @if(@$start_search && @$end_search) value="{{date('m/d/Y',strtotime(@$start_search))}} - {{date('m/d/Y',strtotime(@$end_search))}}" @else value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}"  @endif/>
                                                                    <input type="hidden" name="start_date" id="s_date_mb" />
                                                                    <input type="hidden" name="end_date" id="e_date_mb" />
                                                                    <div class="form-control"   id="show_date_calen_mb" onClick="show_datepicker_mb()" ></div>
                                                                    <div class="form-control"  id="show_end_calen_mb" onClick="show_datepicker_mb()" ></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="hide_month_mb">
                                                    <div class="titletopic">
                                                        <h2>ช่วงเดือน</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_month_mb"></ul>
                                                    </div>  
                                                </div>
                                                <div id="hide_holiday_mb">  
                                                    <div class="titletopic">
                                                        <h2>วันหยุด</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_holiday_mb"></ul>
                                                    </div>   
                                                </div>
                                                <div class="titletopic" hidden>
                                                    <h2>ประเทศ</h2>
                                                </div>
                                                <div class="filtermenu" hidden>
                                                    <ul id="show_country_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>เมือง</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    @if($isAndroid || $isIPhone || $isIPad)
                                                    <div class="input-group mb-3" id="city_input">
                                                        <input type="text" class="form-control" placeholder="ค้นหาชื่อเมือง"  id="find_city"  aria-label="air"
                                                            aria-describedby="button-addon2" onKeyUp="find_city()">
                                                    </div>
                                                    @endif
                                                    <ul id="show_city_mb"></ul>
                                                </div>   
                                                <div class="titletopic" hidden> 
                                                    <h2>อำเภอ</h2>
                                                </div>
                                                <div class="filtermenu" hidden>
                                                    <ul id="show_amupur_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>ช่วงราคา</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_price_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>เลือกจำนวนวัน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_day_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>สายการบิน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    @if($isAndroid || $isIPhone || $isIPad)
                                                    <div class="input-group mb-3" id="airline_input">
                                                        <input type="text" class="form-control" placeholder="ค้นหาสายการบิน"  id="find_airline"  aria-label="air"
                                                            aria-describedby="button-addon2" onKeyUp="find_airline()">
                                                    </div>
                                                    @endif
                                                    <ul id="show_airline_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>ระดับดาวที่พัก</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_rating_mb"></ul>
                                                </div> 
                                            </div>
                                            <a href="javascript:void(0);" class="btn btnonmb" data-bs-dismiss="offcanvas" aria-label="Close">แสดงผลการกรอง</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example" id="orderby_data1" name="orderby_data" onChange="OrderByData(this.value)">
                                    <option value="0" >เรียงตาม </option>
                                    <option value="1">ราคาถูกที่สุด</option>
                                    <option value="2">ดูมากที่สุด</option>
                                    <option value="3">ลดราคา</option>
                                    <option value="4">มีโปรโมชั่น</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 g-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <div id="btnContainer">
                                    <button class="btn active" onClick="gridView()">
                                        <i class="bi bi-view-list list_img imgactive"></i>
                                        <i class="bi bi-view-list list_img  imgnonactive" style="color:#f15a22;"></i>
                                    </button>
                                    <button class="btn" onClick="listView()">
                                        <i class="bi bi-list-task grid_img imgnonactive" style="color:#f15a22;"></i>
                                        <i class="bi bi-list-task grid_img imgactive"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                    <div class="boxfilter" >
                        <div class="row" id="show_box_mb" >
                            <div class="col-8 col-lg-9">
                                <div class="titletopic">
                                    <h2>ตัวกรองที่เลือก</h2>
                                    <ul id="show_select_date_all"></ul>
                                    <ul id="show_keyword_all"></ul>
                                    <ul id="show_code_all"></ul>
                                    <ul id="show_select_all"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1> </h1>
                                <p id="show_total"></p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example" id="orderby_data2" name="orderby_data" onChange="OrderByData(this.value)">
                                            <option value="0" >เรียงตาม </option>
                                            <option value="1">ราคาถูกที่สุด</option>
                                            <option value="2">ดูมากที่สุด</option>
                                            <option value="3">ลดราคา</option>
                                            <option value="4">มีโปรโมชั่น</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <div id="btnContainer">
                                            <button class="btn active" onClick="gridView()">
                                                <i class="bi bi-view-list list_img imgactive"></i>
                                                <i class="bi bi-view-list list_img  imgnonactive"
                                                    style="color:#f15a22;"></i>
                                            </button>
                                            <button class="btn" onClick="listView()">
                                                <i class="bi bi-list-task grid_img imgnonactive"
                                                    style="color:#f15a22;"></i>
                                                <i class="bi bi-list-task grid_img imgactive"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
               
                    <div class="row">
                        <div class="col">
                            <div class="table-grid">
                                <div class="row">
                                    <div class="col" id="show_tour"></div>
                                </div>
                            </div>
                            {{-- grid view --}}
                            <div class="table-list">
                                <div class="showtourontable  table-responsive-xl">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>โปรแกรม</th>
                                                <th>เมนูย่อย</th>
                                                <th>จำนวนวัน</th>
                                                <th>ช่วงเดือน</th>
                                                <th>สายการบิน</th>
                                                <th>ราคา</th>
                                                <th>โรงแรม</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_grid"></tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- end grid view --}}
                            <div class="row mt-4 mb-4">
                                <div class="col">
                                    <div class="pagination_bot">
                                        <nav class="pagination-container">
                                            <button class="btn btn-submit d-none" id="btn-showmore" onClick="show_tour()">ดูเพิ่มเติม</button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include("frontend.layout.inc_footer")
   
    <script>
        var oversea_id = {{isset($country_search)?$country_search:0}};
        var price_search = {{isset($price_search)?$price_search:0}};
        var keyword_search = {{isset($keyword_search)?$keyword_search:0}};
        var code_id = {{isset($code_id)?$code_id:0}};
        <?php 
            echo isset($start_search)?"var start_search = '$start_search' ; ":"var start_search = 0 ;";
            echo isset($end_search)?"var end_search = '$end_search' ; ":"var end_search = 0 ;";
            echo isset($tag_name)?"var tag_name = '$tag_name' ; ":"var tag_name = 0 ;";
        ?>
        var str_start = {{isset($str_start)?$str_start:0}};
        var str_end = {{isset($str_end)?$str_end:0}} ;
        var travel_search = {{isset($travel_search)?json_encode($travel_search):0}};
        var tour_code = {{isset($tour_code)?json_encode($tour_code):0}};
        var isWin = {{isset($isWin)?json_encode($isWin):0}};
        var isMac = {{isset($isMac)?json_encode($isMac):0}};
        var isAndroid = {{isset($isAndroid)?json_encode($isAndroid):0}};
        var isIPhone = {{isset($isIPhone)?json_encode($isIPhone):0}};
        var isIPad = {{isset($isIPad)?json_encode($isIPad):0}};
        var tag_search = {{isset($tag_search)?$tag_search:0}};
    </script>
    <script src="/script-filter.js?v={{ filemtime(public_path('script-filter.js')) }}"> </script> 
    <script src="/data-filter.js"> </script> 
    <script>
        $(document).ready(function () {
            $('.categoryslide_list').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 2,
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 3,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 7,
                        slideBy: 1
                    }
                }
            })
        });

        document.addEventListener("DOMContentLoaded", function() {
            var copyButton = document.getElementById('copyButton');

            copyButton.addEventListener('click', function() {

                var input = document.createElement('input');
                input.value = '{{ url()->current() }}';

                document.body.appendChild(input);

                // เลือกข้อความใน input
                input.select();
                input.setSelectionRange(0, 99999); /* For mobile devices */
                
                // คัดลอกข้อความ
                document.execCommand('copy');

                document.body.removeChild(input);

                alert('URL ถูกคัดลอกแล้ว: ' + input.value);
            });
        });
    </script>
    
 

</body>

</html>