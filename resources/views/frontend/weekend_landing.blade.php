<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>


    @section('title', 'Next Trip Holiday ทัวร์ตามเทศกาล | ' . $data->holiday)
    @section('meta_description',
        'จองแพ็คเกจทัวร์ในประเทศและต่างประเทศ ราคาพิเศษ อัปเดตทุกสัปดาห์
        คัดสรรโดยผู้เชี่ยวชาญด้านท่องเที่ยว')
        <meta name="keywords"
            content="ทัวร์ญี่ปุ่น, ทัวร์เกาหลี, ทัวร์ตามเทศกาล,ทัวร์ไต้หวัน, ทัวร์ต่างประเทศ, ทัวร์ในประเทศ, แพ็กเกจทัวร์ราคาถูก, เที่ยวกับบริษัททัวร์, Next Trip Holiday">
        <!-- ✅ Open Graph สำหรับ Facebook, LINE -->
        <meta property="og:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday" />
        <meta property="og:description"
            content="จองทัวร์กับบริษัททัวร์ชั้นนำ บินตรง โรงแรมดี เที่ยวสนุก ปลอดภัย ไกด์ดูแลตลอดทริป" />
        <meta property="og:url" content="https://www.nexttripholiday.com" />
        <meta property="og:type" content="website" />
        <!-- ✅ Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก ทัวร์ในประเทศ | Next Trip Holiday" />
        <meta name="twitter:description" content="โปรโมชั่นทัวร์ต่างประเทศ เดินทางง่าย บริการคุณภาพ จองเลย!" />


        @include('frontend.layout.inc_header')
        <?php $pageName = 'weekend'; ?>
    </head>

    <body>
        @include('frontend.layout.inc_topmenu')
        <section id="weekendpage" class="wrapperPages">
            <div class="container-fluid g-0 overflow-hidden">
                <div class="row">
                    <div class="col">
                        <div class="bannereach-left">
                            <img src="{{ asset(@$data->img_banner) }}" alt="">
                            <div class="bannercaption">
                                <h1>ทัวร์{{ @$data->holiday }}</h1>
                                {!! $data->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="socialshare">
                    <span>แชร์</span>
                    <ul>
                        @php
                            $contact = App\Models\Backend\ContactModel::find(1);
                            $urlSharer = url('weekend-landing/' . $calen_id);
                            $lineUrl = 'https://social-plugins.line.me/lineit/share?url=' . $urlSharer;
                            $facebookUrl = 'https://www.facebook.com/sharer.php?u=' . $urlSharer;
                            $twitterUrl = "https://twitter.com/intent/tweet?url={$urlSharer}";
                        @endphp
                        <li><a href="{{ url($lineUrl) }}" target="_blank">
                                <img src="{{ asset('frontend/images/line_share.svg') }}" alt="">
                            </a></li>
                        <li><a href="{{ url($facebookUrl) }}" target="_blank">
                                <img src="{{ asset('frontend/images/facebook_share.svg') }}" alt="">
                            </a></li>
                        <li><a href="{{ url($twitterUrl) }}" target="_blank">
                                <img src="{{ asset('frontend/images/twitter_share.svg') }}" alt="">
                            </a></li>
                    </ul>
                </div>
                <div class="row mt-5">
                    <div class="col contentde">
                        {!! $data->detail !!}
                    </div>
                </div>
            </div>
            <div class="calendarDate mt-5 mb-5">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="titletopic text-center">
                                @php
                                    $start_date = \App\Helpers\Helper::DayMonthYearthai($data->start_date);
                                    $end_date = \App\Helpers\Helper::DayMonthYearthai($data->end_date);

                                    $start = \Carbon\Carbon::createFromFormat('Y-m-d', $data->start_date);
                                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $data->end_date);

                                    $period_date = \Carbon\CarbonPeriod::create($start, $end);
                                @endphp
                                <h2>ปฏิทิน{{ @$data->holiday }} {{ @$start_date }} - {{ @$end_date }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="weekslider owl-carousel owl-theme">
                                @foreach ($period_date as $per_date)
                                    <div class="item">
                                        <div class="datecalendarshow text-center">
                                            <span
                                                class="month">{{ \App\Helpers\Helper::Monththai($per_date->format('Y-m-d')) }}
                                            </span>
                                            <h2> {{ @$per_date->format('d') }} </h2>
                                            <span
                                                class="day">วัน{{ \App\Helpers\Helper::Daythai($per_date->format('Y-m-d')) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hotcountry_weekend">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="titletopic text-center">
                                <h2>ทัวร์{{ @$data->holiday }} เส้นทางยอดนิยม</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" id="popular_country"></div>


                    <div class="hilight mt-2 toursmainshowGroup  ">
                        <div class="readMore">
                            <div class="readMoreWrapper">
                                <div class="readMoreText2">
                                    <ul>
                                        <li class="readMoreItem text-center">ดูเพิ่มเติม</li>
                                    </ul>
                                </div>
         
                            </div><a class="readMoreBtn2" id="togglePopular"><i class="fi fi-rr-angle-small-down"></i></a><span
                                class="readLessBtnText" style="display: none;">Read Less</span><span
                                class="readMoreBtnText" style="display: none;">Read More </span>
                        </div>
                    </div>

                    {{-- <div class="text-center mt-3 readMore readMoreWrapper toursmainshowGroup">

                        <a class="readMoreBtn2" id="togglePopular"><i class="fi fi-rr-angle-small-down"></i></a>

                    </div> --}}

                </div>
            </div>
            <style>
                .nt-hide {
                    display: none !important;
                }

                .nt-arrowbtn {
                    background: transparent;
                    border: 0;
                    cursor: pointer;
                    padding: 6px;
                }

                .nt-arrow-down {
                    display: inline-block;
                    width: 24px;
                    height: 24px;
                    border-left: 2px solid rgba(255, 255, 255, .6);
                    border-bottom: 2px solid rgba(255, 255, 255, .6);
                    transform: rotate(-45deg);
                    opacity: .7;
                    transition: transform .25s, opacity .25s;
                }

                .nt-arrowbtn:hover .nt-arrow-down {
                    opacity: 1;
                }

                #togglePopular.expanded .nt-arrow-down {
                    transform: rotate(135deg);
                }

                /* === Trip-like card === */
                .tripcard {
                    display: flex;
                    align-items: flex-start;
                    gap: 14px;
                    padding: 18px;
                    border-radius: 16px;
                    background: #fff;
                    border: 1px solid #e9eef3;
                    box-shadow: 0 1px 0 rgba(16, 24, 40, .02);
                    transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background-color .18s ease;
                    height: 100%;
                }

                .tripcard:hover {
                    background: #ffffff;
                    border-color: #ffd9c6;
                    /* โทนส้มอ่อน */
                    box-shadow: 0 10px 28px rgba(240, 116, 47, .10);
                    transform: translateY(-2px);
                }

                /* ไอคอน/ธงซ้าย */
                .tripcard-icon {
                    width: 46px;
                    height: 46px;
                    border-radius: 12px;
                    background: linear-gradient(180deg, #fff7f1, #fff);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 1px solid #ffe3d2;
                    flex: 0 0 auto;
                }

                .tripcard-icon img {
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    object-fit: cover;
                    display: block;
                    box-shadow: 0 0 0 1px #fff;
                }

                /* เนื้อหา */
                .tripcard-body {
                    min-width: 0;
                }

                .tripcard-title {
                    font-weight: 700;
                    color: #0f172a;
                    line-height: 1.25;
                    margin-top: 2px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .tripcard-sub {
                    margin-top: 4px;
                    font-size: .875rem;
                    color: #4b5563;
                    /* slate-600 */
                }

                /* CTA ขวา */
                .tripcard-cta {
                    margin-left: auto;
                    font-size: 22px;
                    line-height: 1;
                    color: #94a3b8;
                    /* slate-400 */
                    display: flex;
                    align-items: center;
                    transition: color .18s ease, transform .18s ease;
                }

                .tripcard:hover .tripcard-cta {
                    color: #f97316;
                    transform: translateX(2px);
                }

                /* spacing ระหว่างการ์ด */
                #popular_country .col-12 {
                    margin-bottom: 16px;
                }
            </style>


            <div class="reccommend_week mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="titletopic text-center">
                                <h2>โปรแกรมทัวร์{{ @$data->holiday }}แนะนำ</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <div class="recweekslide owl-carousel owl-theme" id="show_recomand">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-lg-4 col-xl-3">
                        <div class="row">
                            <div class="col-5 col-lg-12">
                                <section id="sortfilter">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <div class="boxfilter">
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
                                                    <a href="javascript:void(0)" onclick="clear_filter()"
                                                        class="refreshde">ล้างค่า</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="boxfilter mt-3">
                                            <div hidden>
                                                <div id="hide_date">
                                                    <div class="titletopic" hidden>
                                                        <h2>ช่วงวันเดินทาง</h2>
                                                    </div>
                                                    <div class="col-lg-12" style="margin-top:20px;" hidden>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon1"><i
                                                                            class="bi bi-calendar"></i></span>
                                                                    <input type="text" class="form-control"
                                                                        name="daterange" id="hide_date_select" />
                                                                    <input type="hidden" name="start_date"
                                                                        id="s_date" />
                                                                    <input type="hidden" name="end_date"
                                                                        id="e_date" />
                                                                    <div class="form-control" id="show_date_calen"
                                                                        onclick="show_datepicker()"></div>
                                                                    <div class="form-control" id="show_end_calen"
                                                                        onclick="show_datepicker()"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="hide_month">
                                                    <div class="titletopic" id="month-topic" hidden>
                                                        <h2>ช่วงเดือน</h2>
                                                    </div>
                                                    <div class="filtermenu" hidden>
                                                        <ul id="show_month"></ul>
                                                    </div>
                                                    <div class="titletopic" id="holiday-topic" hidden>
                                                        <h2>วันหยุด</h2>
                                                    </div>
                                                    <div class="filtermenu" hidden>
                                                        <ul id="show_holiday"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="titletopic" id="country-topic">
                                                <h2>ประเทศ</h2>
                                            </div>
                                            <div class="filtermenu">
                                                @if ($isWin || $isMac)
                                                    <div class="input-group mb-3" id="country_input">
                                                        <input type="text" class="form-control"
                                                            placeholder="ค้นหาชื่อประเทศ" id="find_country"
                                                            aria-label="air" aria-describedby="button-addon2"
                                                            onkeyup="find_country()">
                                                    </div>
                                                @endif
                                                <ul id="show_country"></ul>
                                            </div>
                                            <div class="titletopic" id="city-topic" hidden>
                                                <h2>เมือง</h2>
                                            </div>
                                            <div class="filtermenu" hidden>
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
                                                @if ($isWin || $isMac)
                                                    <div class="input-group mb-3" id="airline_input">
                                                        <input type="text" class="form-control"
                                                            placeholder="ค้นหาสายการบิน" id="find_airline"
                                                            aria-label="air" aria-describedby="button-addon2"
                                                            onkeyup="find_airline()">
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
                                        <button class="btn btnfilter" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasBottom"
                                            aria-controls="offcanvasBottom">ตัวกรอง</button>

                                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                                            aria-labelledby="offcanvasBottomLabel">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">กรองการค้นหา <a
                                                        href="javascript:void(0)" onclick="clear_filter()"
                                                        class="refreshde">ล้างค่า</a> </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                                    aria-label="Close"></button>
                                            </div>
                                            <ul id="show_select_date_mb"></ul>
                                            <ul id="show_keyword_mb"></ul>
                                            <ul id="show_code_mb"></ul>
                                            <ul id="show_select_mb"></ul>
                                            <div class="offcanvas-body small">
                                                <div class="boxfilter">
                                                    <div id="hide_date_mb">
                                                        <div class="titletopic" hidden>
                                                            <h2>ช่วงวันเดินทาง</h2>
                                                        </div>
                                                        <div class="col-lg-12" style="margin-top:20px;" hidden>
                                                            <div class="row">
                                                                <div class="col-12 col-lg-12">
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1"><i
                                                                                class="bi bi-calendar"></i></span>
                                                                        <input type="text" class="form-control"
                                                                            name="daterange" id="hide_date_select_mb"
                                                                            @if (@$start_search && @$end_search) value="{{ date('m/d/Y', strtotime(@$start_search)) }} - {{ date('m/d/Y', strtotime(@$end_search)) }}" @else value="{{ date('m/d/Y') }} - {{ date('m/d/Y', strtotime('+1 day')) }}" @endif />
                                                                        <input type="hidden" name="start_date"
                                                                            id="s_date_mb" />
                                                                        <input type="hidden" name="end_date"
                                                                            id="e_date_mb" />
                                                                        <div class="form-control" id="show_date_calen_mb"
                                                                            onclick="show_datepicker_mb()"></div>
                                                                        <div class="form-control" id="show_end_calen_mb"
                                                                            onclick="show_datepicker_mb()"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="hide_month_mb">
                                                        <div class="titletopic" hidden>
                                                            <h2>ช่วงเดือน</h2>
                                                        </div>
                                                        <div class="filtermenu" hidden>
                                                            <ul id="show_month_mb"></ul>
                                                        </div>
                                                        <div class="titletopic" hidden>
                                                            <h2>วันหยุด</h2>
                                                        </div>
                                                        <div class="filtermenu" hidden>
                                                            <ul id="show_holiday_mb"></ul>
                                                        </div>
                                                    </div>
                                                    <div class="titletopic">
                                                        <h2>ประเทศ</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        @if ($isAndroid || $isIPhone || $isIPad)
                                                            <div class="input-group mb-3" id="country_input">
                                                                <input type="text" class="form-control"
                                                                    placeholder="ค้นหาชื่อประเทศ" id="find_country"
                                                                    aria-label="air" aria-describedby="button-addon2"
                                                                    onkeyup="find_country()">
                                                            </div>
                                                        @endif
                                                        <ul id="show_country_mb"></ul>
                                                    </div>
                                                    <div class="titletopic" hidden>
                                                        <h2>เมือง</h2>
                                                    </div>
                                                    <div class="filtermenu" hidden>
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
                                                        @if ($isAndroid || $isIPhone || $isIPad)
                                                            <div class="input-group mb-3" id="airline_input">
                                                                <input type="text" class="form-control"
                                                                    placeholder="ค้นหาสายการบิน" id="find_airline"
                                                                    aria-label="air" aria-describedby="button-addon2"
                                                                    onkeyup="find_airline()">
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
                                                <a href="javascript:void(0);" class="btn btnonmb"
                                                    data-bs-dismiss="offcanvas" aria-label="Close">แสดงผลการกรอง</a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-5 ps-0">
                                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                    <select class="form-select" aria-label="Default select example" id="orderby_data1"
                                        name="orderby_data" onchange="OrderByData(this.value)">
                                        <option value="0">เรียงตาม </option>
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
                                        <button class="btn active" onclick="gridView()">
                                            <i class="bi bi-view-list list_img imgactive"></i>
                                            <i class="bi bi-view-list list_img  imgnonactive" style="color:#f15a22;"></i>
                                        </button>
                                        <button class="btn" onclick="listView()">
                                            <i class="bi bi-list-task grid_img imgnonactive" style="color:#f15a22;"></i>
                                            <i class="bi bi-list-task grid_img imgactive"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <div class="boxfilter">
                            <div class="row" id="show_box_mb">
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
                                            <select class="form-select" aria-label="Default select example"
                                                id="orderby_data2" name="orderby_data"
                                                onchange="OrderByData(this.value)">
                                                <option value="0">เรียงตาม </option>
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
                                                <button class="btn active" onclick="gridView()">
                                                    <i class="bi bi-view-list list_img imgactive"></i>
                                                    <i class="bi bi-view-list list_img  imgnonactive"
                                                        style="color:#f15a22;"></i>
                                                </button>
                                                <button class="btn" onclick="listView()">
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
                                                <button class="btn btn-submit d-none" id="btn-showmore"
                                                    onclick="show_tour()">ดูเพิ่มเติม</button>
                                                {{-- <div class="pagination" id="pagination">
                                            </div> --}}
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
        @include('frontend.layout.inc_footer')
        <script>
            var oversea_id = {{ isset($calen_id) ? $calen_id : 0 }};
            var isWin = {{ isset($isWin) ? json_encode($isWin) : 0 }};
            var isMac = {{ isset($isMac) ? json_encode($isMac) : 0 }};
            var isAndroid = {{ isset($isAndroid) ? json_encode($isAndroid) : 0 }};
            var isIPhone = {{ isset($isIPhone) ? json_encode($isIPhone) : 0 }};
            var isIPad = {{ isset($isIPad) ? json_encode($isIPad) : 0 }};
        </script>
        <script src="/script-filter.js?v={{ filemtime(public_path('script-filter.js')) }}"></script>
        <script src="/data-filter-holiday.js"></script>
        <script>
            $(document).ready(function() {
                $('.weekslider').owlCarousel({
                    loop: false,
                    item: 1,
                    margin: 20,
                    slideBy: 1,
                    autoplay: false,
                    smartSpeed: 2000,
                    nav: true,
                    navText: ['<img src="{{ asset('frontend/images/arrowRight.svg') }}">',
                        '<img src="{{ asset('frontend/images/arrowLeft.svg') }}">'
                    ],
                    navClass: ['owl-prev', 'owl-next'],
                    dots: false,
                    responsive: {
                        0: {
                            items: 2,
                            margin: 10,
                            nav: false,


                        },
                        600: {
                            items: 3,
                            margin: 10,
                            nav: false,

                        },
                        1024: {
                            items: 4,
                            slideBy: 1
                        },
                        1200: {
                            items: 6,
                            slideBy: 1
                        }
                    }
                })
                $('.recweekslide').owlCarousel({
                    loop: false,
                    item: 1,
                    margin: 20,
                    slideBy: 1,
                    autoplay: false,
                    smartSpeed: 2000,
                    nav: true,
                    navText: ['<img src="{{ asset('frontend/images/arrowRight.svg') }}">',
                        '<img src="{{ asset('frontend/images/arrowLeft.svg') }}">'
                    ],
                    navClass: ['owl-prev', 'owl-next'],
                    dots: false,
                    responsive: {
                        0: {
                            items: 1,
                            margin: 10,
                            nav: false,


                        },
                        600: {
                            items: 2,
                            margin: 10,
                            nav: false,

                        },
                        1024: {
                            items: 3,
                            slideBy: 1
                        },
                        1200: {
                            items: 4,
                            slideBy: 1
                        }
                    }
                })



            });
        </script>

    </body>

    </html>
