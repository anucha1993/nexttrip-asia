<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   {{-- ======= HEAD: รับจัดกรุ๊ปทัวร์ ======= --}}
@section('title', 'Next Trip Holiday รับจัดกรุ๊ปทัวร์ | กรุ๊ปเหมาบริษัท ทัวร์ส่วนตัว ทัวร์ศึกษาดูงาน')
@section('meta_description', 'บริการรับจัดกรุ๊ปทัวร์ส่วนตัว กรุ๊ปเหมาบริษัท และศึกษาดูงาน ทั้งในและต่างประเทศ ออกแบบโปรแกรมตามงบและความต้องการ ดูแลครบตั้งแต่ตั๋วเครื่องบิน โรงแรม ไกด์ และรถบัส')

{{-- แนะนำให้ลบ meta keywords (ไม่จำเป็นสำหรับ Google) --}}
<link rel="canonical" href="https://nexttripholiday.com/organizetour/"/>
<meta name="robots" content="index, follow"/>

{{-- Open Graph --}}
<meta property="og:type" content="website"/>
<meta property="og:title" content="Next Trip Holiday รับจัดกรุ๊ปทัวร์ | กรุ๊ปเหมาบริษัท ทัวร์ส่วนตัว ทัวร์ศึกษาดูงาน"/>
<meta property="og:description" content="บริการรับจัดกรุ๊ปทัวร์ครบวงจร ออกแบบโปรแกรมตามงบและความต้องการ ดูแลตั้งแต่ตั๋วเครื่องบิน โรงแรม ไกด์ และรถบัส"/>
<meta property="og:url" content="https://nexttripholiday.com/organizetour/"/>
<meta property="og:site_name" content="Next Trip Holiday"/>
<meta property="og:image" content="https://nexttripholiday.b-cdn.net/og/organizetour.jpg"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:image:alt" content="รับจัดกรุ๊ปทัวร์ Next Trip Holiday"/>

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="Next Trip Holiday รับจัดกรุ๊ปทัวร์ | กรุ๊ปเหมาบริษัท ทัวร์ส่วนตัว ทัวร์ศึกษาดูงาน"/>
<meta name="twitter:description" content="ออกแบบทัวร์ตามงบและความต้องการ ดูแลงานครบวงจรโดยทีมมืออาชีพ"/>
<meta name="twitter:image" content="https://nexttripholiday.b-cdn.net/og/organizetour.jpg"/>

{{-- JSON-LD: Breadcrumb + Service (สั้น ๆ) --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"หน้าหลัก","item":"https://nexttripholiday.com/"},
    {"@type":"ListItem","position":2,"name":"รับจัดกรุ๊ปทัวร์","item":"https://nexttripholiday.com/organizetour/"}
  ]
}
</script>
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Service",
  "name":"รับจัดกรุ๊ปทัวร์ (กรุ๊ปเหมาบริษัท/ทัวร์ส่วนตัว/ศึกษาดูงาน)",
  "serviceType":"Custom Group Tour",
  "provider":{
    "@type":"Organization",
    "name":"Next Trip Holiday",
    "url":"https://nexttripholiday.com/",
    "logo":"https://nexttripholiday.b-cdn.net/brand/logo-512.png"
  },
  "areaServed":[
    {"@type":"Country","name":"Thailand"},
    {"@type":"Place","name":"Asia"}
  ],
  "url":"https://nexttripholiday.com/organizetour/",
  "description":"บริการรับจัดกรุ๊ปทัวร์ครบวงจร ออกแบบโปรแกรมตามงบและความต้องการ ดูแลตลอดทริป"
}
</script>


    @include("frontend.layout.inc_header")
    <?php  $pageName="organize";?>
</head>

<body>
    <h1 class="sr-only">รับจัดกรุ๊ปทัวร์ กรุ๊ปเหมาบริษัท ทัวร์ส่วนตัว และศึกษาดูงาน</h1>
    @include("frontend.layout.inc_topmenu")
    <section id="organizepage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <img src="{{asset($banner->img)}}" alt="">
                        </div>
                        <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <img src="{{asset($banner->img)}}" alt="">
                        </div>
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col contentde text-center">
                    {!! $content->detail !!}
                </div>
            </div>
            
        </div>
        <div class="container">
        <div class="row mt-5 g-0">
            @foreach ($list as  $l)
                @if($l->id == 1 || $l->id == 2)
                <div class="col-lg-6">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-4 coved">
                            <img src="{{asset($l->img)}}" alt="" class="radLeafds">
                        </div>
                        <div class="col-md-6 col-lg-8 ogbg">
                            <img src="{{asset('frontend/images/whyicon'.$l->id.'.svg')}}" alt="">
                            <h3>{{$l->list}}</h3>
                            {!! $l->detail !!}
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-6">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-8 bluebg ordadrl swap_order2">
                            <img src="{{asset('frontend/images/whyicon'.$l->id.'.svg')}}" alt="">
                            <h3>{{$l->list}}</h3>
                            {!! $l->detail !!}
                        </div>
                        <div class="col-md-6 col-lg-4 coved swap_order">
                            <img src="{{asset($l->img)}}" alt="">
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
            </div>
            <div class="row mt-5">
                <div class="col contentde text-center">
                    {!! $content->text_center !!}
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6 col-lg-6 hoverstyle">
                    <figure>
                        <a href="#">
                            <img src="{{asset($content->img_left)}}" class="img-fluid" alt="">
                        </a>
                    </figure>
                    <div class="whitebox">
                        {!! $content->text_left !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 hoverstyle">
                    <figure>
                        <a href="#">
                            <img src="{{asset($content->img_right)}}" class="img-fluid" alt="">
                        </a>
                    </figure>
                    <div class="whitebox">
                        {!! $content->text_right !!}
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col contentde text-center">
                    <span class="orgtext bigtxt"> 4 ขั้นตอน </span> จัดกรุ๊ปเหมา ฉบับเร่งด่วน
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6 col-lg-3 text-center">
                    <div class="boxstep hoverstyle">
                        <figure><a href="#"><img src="{{asset('frontend/images/step1.svg')}}" alt=""></a></figure>
                    </div>
                    <div class="titletopic mt-3">
                        <h2>แจ้งประเทศ</h2>
                        <p>เส้นทางที่ต้องการเดินทาง</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3 text-center">
                    <div class="boxstep hoverstyle">
                        <figure><a href="#"><img src="{{asset('frontend/images/step2.svg')}}" alt=""></a></figure>
                    </div>
                    <div class="titletopic mt-3">
                        <h2>แจ้งวัน</h2>
                        <p>เวลา ที่สะดวกเดินทาง</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3 text-center">
                    <div class="boxstep hoverstyle">
                        <figure><a href="#"><img src="{{asset('frontend/images/step3.svg')}}" alt=""></a></figure>
                    </div>
                    <div class="titletopic mt-3">
                        <h2>แจ้งงบประมาณ</h2>
                        <p>ราคาที่คุณต้องการ</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3 text-center">
                    <div class="boxstep hoverstyle">
                        <figure><a href="#"><img src="{{asset('frontend/images/step4.svg')}}" alt=""></a></figure>
                    </div>
                    <div class="titletopic mt-3">
                        <h2>แจ้งจำนวน</h2>
                        <p>ผู้เดินทางในทริป</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col titletopic text-center">
                    <h2>ตัวอย่างภาพความประทับใจ กรุ๊ปเหมาส่วนตัว กรุ๊ป Incentive</h2>
                </div>
            </div>
            <div class="row mt-5">
                @foreach ($row as $r)
                <?php  $gallery = App\Models\Backend\GroupGalleryModel::where('group_id',$r->id)->orderBy('id','desc')->get(); ?>
                    <div class="col-6 col-lg-4 hoverstyle mb-3  text-center ">
                        <figure>
                            @foreach ($gallery as $a => $g)
                                <a href="#" data-fancybox="gallery" data-src="{{asset($g->img)}}"  >
                                    @if($a == 0) <img src="{{asset($g->img)}}" class="img-fluid" alt=""> @endif
                                </a>
                            @endforeach
                        </figure>
                        <div class="titletopic mt-2">
                            <h3>{{$r->name}}</h3>
                        </div>
                        @foreach ($gallery as $a => $g)
                            <a href="#" class="bbtxt" data-fancybox="gallery" data-src="{{asset($g->img)}}"  data-caption="{{$r->name}}">
                                @if($a == 0) ดูแกลเลอรี่ @endif
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>