<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 

                                  
@php
    // ดึงประเทศ
    $country_data = $country->find($id);
    $countryName  = $country_data->country_name_th ?? '';

    // ถ้ามีโมเดลแพ็กเกจให้ใช้ (เผื่อคุณตั้งชื่อ $package หรือ $pkg)
    $pkg   = $package ?? ($pkg ?? null);
    $name  = $pkg->name ?? "แพ็กเกจเที่ยวด้วยตัวเอง {$countryName}";
    $cover = $pkg->cover_url ?? 'https://nexttripholiday.b-cdn.net/og/package-default.jpg';

    // pagination (กัน duplicate)
    $page = max((int) request('page', 1), 1);
    $canonical = $page > 1 ? url()->current().'?page='.$page : url()->current();
@endphp

{{-- ======= SEO HEAD ======= --}}
@section('title', "Next Trip Holiday แพ็กเกจทัวร์ | เที่ยวด้วยตัวเอง {$countryName}" . ($page>1 ? " (หน้า {$page})" : ''))
@section('meta_description', "แพ็กเกจเที่ยวด้วยตัวเอง {$countryName} คัดสรรโรงแรมและเส้นทางคุ้มค่า จองง่าย อัปเดตราคาและตารางเดินทางสม่ำเสมอ บริการโดยทีมงานมืออาชีพ")

<link rel="canonical" href="{{ $canonical }}"/>
<meta name="robots" content="index, follow"/>

{{-- Open Graph --}}
<meta property="og:type" content="website"/>
<meta property="og:title" content="{{ $name }}"/>
<meta property="og:description" content="แพ็กเกจเที่ยวด้วยตัวเอง {{ $countryName }} จองง่าย บริการครบ อยู่กับคุณทุกขั้นตอนการเดินทาง"/>
<meta property="og:url" content="{{ $canonical }}"/>
<meta property="og:site_name" content="Next Trip Holiday"/>
<meta property="og:image" content="{{ $cover }}"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:image:alt" content="{{ $name }}"/>

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ $name }}"/>
<meta name="twitter:description" content="แพ็กเกจเที่ยวด้วยตัวเอง {{ $countryName }} จองง่าย บริการครบ"/>
<meta name="twitter:image" content="{{ $cover }}"/>

{{-- ======= JSON-LD ======= --}}
{{-- Breadcrumb --}}
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"หน้าหลัก","item":"https://nexttripholiday.com/"},
    {"@type":"ListItem","position":2,"name":"แพ็กเกจทัวร์","item":"https://nexttripholiday.com/package/"},
    {"@type":"ListItem","position":3,"name":"{{ $countryName }}","item":"{{ $canonical }}"}
  ]
}
</script>

{{-- ถ้ามีข้อมูลแพ็กเกจ ให้ระบุ Product/Offer แบบสั้น ๆ --}}
@if($pkg ?? false)
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Product",
  "name":"{{ $name }}",
  "image":["{{ $cover }}"],
  "description":"แพ็กเกจเที่ยวด้วยตัวเอง {{ $countryName }}",
  "brand":{"@type":"Organization","name":"Next Trip Holiday"},
  "url":"{{ $canonical }}",
  @if(isset($pkg->sku)) "sku":"{{ $pkg->sku }}", @endif
  "offers":{
    "@type":"Offer",
    "url":"{{ $canonical }}",
    @if(isset($pkg->price))
    "price":"{{ number_format((float)$pkg->price, 2, '.', '') }}",
    "priceCurrency":"THB",
    @endif
    "availability":"https://schema.org/InStock"
  }
}
</script>
@endif


    @include("frontend.layout.inc_header")
	<title>แพคเกจทัวร์ ,เที่ยวด้วยตนเอง</title>
</head>

<body>
    <h1 class="sr-only">{{ $name }}</h1>

    @include("frontend.layout.inc_topmenu")
    <section id="packagepage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>

                                <li class="breadcrumb-item active" aria-current="page">แพ็คเกจทัวร์ทั้งหมด</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($row as $r)
                        <div class="col-6 col-lg-4">
                            <div class="newslistgroup hoverstyle">
                                <figure>
                                    <a href="{{url('package-detail/'.$r->id)}}">
                                        <img src="{{asset($r->img)}}" alt="">
                                    </a>
                                </figure>
                                <div class="detail">
                                    <h3> <a href="{{url('package-detail/'.$r->id)}}">{{$r->package}} </a></h3>
                                    <h4><span>ราคาเริ่มต้น</span> {{$r->price}} บาท</h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sticky-top">
                        <div class="boxfaqlist">
                            <div class="titletopic">
                                <h2>แพ็คเกจทัวร์</h2>
                            </div>
                            <ul class="favelist">
                                <li @if($id == 0) class="active" @endif><a href="{{url('package/0')}}">แพ็คเกจทัวร์ทั้งหมด</a></li>
                                @foreach($country as $c => $cou)
                                    <li @if($id == $cou->id)class="active" @endif><a href="{{url('package/'.$cou->id)}}">ทัวร์{{$cou->country_name_th}} </a></li>
                                @endforeach 
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="pagination_bot">
                        <nav class="pagination-container">
                            <div class="pagination">
                                <?php $page = $row->currentPage();
                                      $total_page = $row->lastPage();
                                      $older = $page+1;    
                                      $newer = $page-1;  
                                ?>
                                @if($page != $newer && $page != 1)
                                    <a class="pagination-newer" href="?page={{$newer}}"><i class="fas fa-angle-left"></i></a>
                                @endif
                                <span class="pagination-inner">
                                    @if($total_page > 1)
                                        <?php for($i=1; $i<=$total_page; $i++){ ?> 
                                            <a @if($i == $page) class="pagination-active" @endif href="?page={{$i}}">{{$i}}</a>
                                        <?php } ?>
                                    @endif
                                </span>
                                @if($page != $older && $page != $total_page)
                                    <a class="pagination-older" href="?page={{$older}}"><i class="fas fa-angle-right"></i></a>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>