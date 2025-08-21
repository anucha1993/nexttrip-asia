               
    // holiday_date = Array.from([holiday_date], (x) => x );
    window.ASSET_URL = "{{ env('ASSET_URL') }}";
    var menu_country = new Array();
        var menu_price = new Array();
        var menu_airline = new Array();
        var menu_rating = new Array();
        var menu_day = new Array();
        var menu_holiday = new Array();
        var menu_month = new Array();
        var menu_city = new Array();
        var menu_amupur = new Array();
        var data_tour = new Array();
        var city_slide = new Array();
        var oversea_id = oversea_id?oversea_id:0;
        var price_search = price_search?price_search:0;
        var country_search = country_search?country_search:0;
        var city_search = city_search?city_search:0;
        var keyword_search = keyword_search?keyword_search:0;
        var code_id = code_id?code_id:0;
        var start_search = start_search?start_search:0;
        var end_search = end_search?end_search:0;
        var str_start = str_start?str_start:0;
        var str_end = str_end?str_end:0;
        var travel_search = travel_search?travel_search:0;
        var tour_code = tour_code?tour_code:0;
        var isWin = isWin?isWin:0;
        var isMac = isMac?isMac:0;
        var isAndroid = isAndroid?isAndroid:0;
        var isIPhone = isIPhone?isIPhone:0;
        var isIPad = isIPad?isIPad:0;
        var count_country = 0;
        var count_city = 0;
        var count_amupur = 0;
        var count_airline = 0;
        var total_tour = 0;
        var type_data = {
            country: new Array(),
            price: new Array(),
            airline: new Array(),
            rating: new Array(),
            day:new Array(),
            month:new Array(),
            holiday:new Array(),
            city:new Array(),
            amupur:new Array(),
            start_date:new Array(),
            end_date:new Array(),
            travel_search:new Array(),
            tour_code:new Array(),
            tag_search:new Array(),
        }
        var tag_search = tag_search?tag_search:0;
        var tag_name = tag_name?tag_name:0;
        var paginat_act = 1;
        var main_tour = new Array();
        var total_page = 0;
        var days = ['วันอาทิตย์','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์'];
        var months = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        var month_number = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        var min_date = (new Date().getMonth()+1)+'/'+new Date().getDate()+'/'+new Date().getFullYear()*1;
        starter();
        $('#hide_date_select').hide();
        $('#hide_date_select_mb').hide(); 
       
        async function starter(){
            var tour_tag = tour;
            if(oversea_id){
                tour = await tour.filter(x => x.country_id.includes('"'+oversea_id+'"'));
                var tour_fill = new Array();
                for(let t in tour){
                    tour_fill.push(tour[t].id);
                }
                period = await period.filter(x=> tour_fill.includes(x.tour_id));
            }
            
            if(city_search){
                type_data.city.push(city_search);
            }
            if(travel_search.length){
                type_data.travel_search = await travel_search;
                if(isWin || isMac){
                    document.getElementById('show_keyword').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }else if(isIPhone || isAndroid || isIPad){
                    //mobile
                    document.getElementById('show_keyword_mb').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    document.getElementById('show_keyword_all').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }
            }else if(tour_code.length){
                type_data.tour_code = await tour_code;
                if(isWin || isMac){
                    document.getElementById('show_code').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }else if(isIPhone || isAndroid || isIPad){
                    //mobile
                    document.getElementById('show_code_mb').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    document.getElementById('show_code_all').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }
            }else if(code_id){
                type_data.tour_code.push(code_id);
                if(isWin || isMac){
                    document.getElementById('show_code').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }else if(isIPhone || isAndroid || isIPad){
                    //mobile
                    document.getElementById('show_code_mb').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    document.getElementById('show_code_all').innerHTML = "<li onclick='DeletedCode()'><label class='check-container'>"+code_id+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }
            }
            else if(keyword_search){
                type_data.travel_search.push(keyword_search);
                if(isWin || isMac){
                    document.getElementById('show_keyword').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }else if(isIPhone || isAndroid || isIPad){
                    //mobile
                    document.getElementById('show_keyword_mb').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    document.getElementById('show_keyword_all').innerHTML = "<li onclick='DeletedKeyword()'><label class='check-container'>"+keyword_search+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }
            }else if(tag_search){
                // tour_tag = await tour_tag.filter(x => x.tag_id.includes('"'+tag_search+'"'));
                // var tour_fill = new Array();
                // for(let t in tour_tag){
                //     tour_fill.push(tour[t].id);
                // }
                // period = await period.filter(x=> tour_fill.includes(x.tour_id));
                type_data.tag_search.push(tag_search);
                if(isWin || isMac){
                    document.getElementById('show_tag').innerHTML = "<li onclick='DeletedTag()'><label class='check-container'>"+tag_name+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }else if(isIPhone || isAndroid || isIPad){
                    //mobile
                    document.getElementById('show_tag_mb').innerHTML = "<li onclick='DeletedTag()'><label class='check-container'>"+tag_name+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    document.getElementById('show_tag_all').innerHTML = "<li onclick='DeletedTag()'><label class='check-container'>"+tag_name+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                }
            }else{
                data_tour = await tour;
            }
            await show_tour(0);
            // await readMore();
            await SelectFilter();
            await menu_filter();

            if(!oversea_id){
                await show_country();
                $('#city-topic').hide();
                $('#amupur-topic').hide();
            }
            if(oversea_id){
                await show_city(true);
                $('#country-topic').hide();
            }
            await show_price();
            await show_airline();
            await show_rating();
            await show_day();
            await show_month();
            await show_holiday();
            await date_picker();
            await filter_tour();
            
        }
         async function date_picker(){
                if(start_search && end_search){
                    var check_after = new Date(start_search);
                    var check_befor = new Date(end_search);
                    var searchS_show = check_after.getDate()+'/'+month_number[check_after.getMonth()]+'/'+(check_after.getFullYear()*1+543);
                    var searchE_show = check_befor.getDate()+'/'+month_number[check_befor.getMonth()]+'/'+(check_befor.getFullYear()*1+543);
                    if(isWin || isMac){
                        document.getElementById('show_select_date').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+searchS_show+" ถึง "+searchE_show+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                    }else if(isIPhone || isAndroid || isIPad){
                         //mobile
                        document.getElementById('show_select_date_mb').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+searchS_show+" ถึง "+searchE_show+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                        document.getElementById('show_select_date_all').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+searchS_show+" ถึง "+searchE_show+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                    }
                
                    type_data.start_date.push(start_search);
                    type_data.end_date.push(end_search);
                    count_pagin = 1;
             
                }else{
                    var check_after = new Date();
                    var check_befor = new Date(check_after.valueOf()+86400000);
                }
            
                var strat_show = check_after.getDate()+'  '+months[check_after.getMonth()]+'  '+(check_after.getFullYear()*1+543);
                var start_day_show = days[check_after.getDay()];
                var end_show = check_befor.getDate()+'  '+months[check_befor.getMonth()]+'  '+(check_befor.getFullYear()*1+543);
                var end_day_show = days[check_befor.getDay()];
                var text_s_show = '';
                    text_s_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+strat_show+"</span>";
                    text_s_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+start_day_show+"</span>";
                var text_e_show = '';
                    text_e_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+end_show+"</span>";
                    text_e_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+end_day_show+"</span>";
            
            if(isWin || isMac){
                document.getElementById('show_date_calen').innerHTML = text_s_show;
                document.getElementById('show_end_calen').innerHTML = text_e_show;
            }else if(isIPhone || isAndroid || isIPad){
                //mobile
                document.getElementById('show_date_calen_mb').innerHTML = text_s_show;
                document.getElementById('show_end_calen_mb').innerHTML = text_e_show;
            }
           
         }
        async function count_paginate(page){
         
            var min = page-6;
            if(min <= 0){
                min = min-min;
            }
            var btn = '';
            var max = total_page < 12?total_page:12;
            if(paginat_act){          
                btn+= "<a class='pagination-newer' onclick='show_tour("+(paginat_act-1)+")'><i class='fas fa-angle-left'></i></a>";
            }
            for(x=min;x<min+max;x++){
                if((x+1)<=max){
                    btn+= "<span class='pagination-inner'>";
                    btn+=     "<a herf='javascript:void(0);'"; 
                                if(x == paginat_act){
                    btn+=           " class='pagination-active'"; 
                                }
                    btn+=   "  onclick='show_tour("+x+")' id='page"+(x+1)+"'>"+(x+1)+"</a>";
                    btn+= "</span>";
                }
            }
            if(paginat_act != total_page-1 && total_page > 1){
                btn+=  "<a class='pagination-older' onclick='show_tour("+(paginat_act+1)+")'><i class='fas fa-angle-right'></i></a>";
            }
            document.getElementById('pagination').innerHTML = btn;
        }
        async function menu_filter(){
            //เมนูประเทศ
            for(let x in country){
                var id_country = country[x].id;
                var num = await tour.filter(x => x.country_id.includes('"'+id_country+'"')).length;
                if(num){
                    let info = {
                        id:country[x].id,
                        name:country[x].country_name_th != ''?country[x].country_name_th:country[x].country_name_en,
                        num:num,
                    }
                    if(!menu_country[count_country]){
                        menu_country[count_country] = new Array();
                    }
                    menu_country[count_country].push(info);
                    if(menu_country[count_country].length >= 10 && count_country == 0){
                        count_country++;
                    }
                }
            }
            //เมนูประเทศ
            //เมนูเมือง
            for(let x in city){
                var id_city = city[x].id;
                var num = await tour.filter(x => x.city_id.includes('"'+id_city+'"')).length;
                if(num){
                    let info = {
                        id:city[x].id,
                        name:city[x].city_name_th != ''?city[x].city_name_th:city[x].city_name_en,
                        num:num,
                    }
                    if(!menu_city[count_city]){
                        menu_city[count_city] = new Array();
                    }
                    menu_city[count_city].push(info);
                    if(menu_city[count_city].length >= 10 && count_city == 0){
                        count_city++;
                    }
                    city_slide.push(info);
                }
            }
            //เมนูเมือง
            //เมนูอำเภอ
            for(let x in amupur){
                var id_amupur = amupur[x].id;
                var num = await tour.filter(x => x.district_id.includes('"'+id_amupur+'"')).length;
                if(num){
                    let info = {
                        id:amupur[x].id,
                        name:amupur[x].name_th != ''?amupur[x].name_th:amupur[x].name_en,
                        num:num,
                    }
                    if(!menu_amupur[count_amupur]){
                        menu_amupur[count_amupur] = new Array();
                    }
                    menu_amupur[count_amupur].push(info);
                    if(menu_amupur[count_amupur].length >= 10 && count_amupur == 0){
                        count_amupur++;
                    }
                }
            }
            //เมนูอำเภอ
            //เมนูราคา
            for(let p in price){
                var num = await tour.filter(x => x.price_group == p && x.price_group != 0).length;
                if(num){
                    let info = {
                        id:p,
                        name:price[p],
                        num:num,
                    }
                    menu_price.push(info);
                }
            }
            //เมนูราคา
            //เมนูสายการบิน
            for(let x in airline){
                var id_airline = airline[x].id;
                var num = await tour.filter(x => x.airline_id == id_airline).length;
                if(num){
                    let info = {
                        id:airline[x].id,
                        name:airline[x].travel_name,
                        num:num,
                        img:airline[x].image,
                    }
                    if(!menu_airline[count_airline]){
                        menu_airline[count_airline] = new Array();
                    }
                    menu_airline[count_airline].push(info);
                    if(menu_airline[count_airline].length >= 10 && count_airline == 0){
                        count_airline++;
                    }
                }
            }
            //เมนูสายการบิน
            //เมนูระดับดาว
            for(let r in rating){
                var num = await tour.filter(x => (x.rating ? x.rating:0) == rating[r]).length;
                // var num = await tour.filter(x => rating.includes(x.rating)).length;
                if(num){
                    let info = {
                        name:rating[r]*1,
                        num:num,
                    }
                    menu_rating.push(info);
                }
            }
            //เมนูระดับดาว
            //เมนูจำนวนวัน
            for(let d in day_num){
                var num = await period.filter(x => x.day == day_num[d]);
                var check = new Array();
                    for(let n in num){
                        check.push(num[n].tour_id);
                    }
                    check = await check.filter((value, index, self) => {
                        return self.indexOf(value) === index;
                    });
                    if(check.length){
                        menu_day.push({
                            name : day_num[d],
                            num: check.length,
                            tour:check,
                        });
                    }
            }
            //เมนูจำนวนวัน
            //เมนูช่วงเดือน
                for(let year in month){
                    menu_month[year] = new Array();
                    for(let m in month[year]){
                        var num = await period.filter(x => x.group_date ==  month[year][m]+year && x.count > 0 && x.status_period != 3);
                        var check = new Array();
                        //console.log(num,'num menu_month ')
                        for(let n in num){
                            check.push(num[n].tour_id);
                        }
                        check = await check.filter((value, index, self) => {
                            return self.indexOf(value) === index;
                        });
                        if(check.length){
                            menu_month[year].push({
                                id: month[year][m]+year,
                                name : month_data[month[year][m]*1],
                                num: check.length,
                                tour:check,
                                
                            });
                        }
                    }
                    if(!menu_month[year].length){
                        menu_month.splice(year);
                    }
                }
            //เมนูช่วงเดือน
            //เมนูวันหยุด
                for(let h in holiday){
                    var num = await period.filter(x => new Date(x.start_date).valueOf() >=  holiday[h].num_start*1000   && new Date(x.start_date).valueOf() <=  holiday[h].num_end*1000 );
                    var check = new Array();
                        for(let n in num){
                            check.push(num[n].tour_id);
                        }
                        check = await check.filter((value, index, self) => {
                            return self.indexOf(value) === index;
                        });
                        if(check.length){
                            menu_holiday.push({
                                id: holiday[h].id,
                                name : holiday[h].name,
                                num: check.length,
                                tour:check,
                                
                            });
                        }  
                }
                
            //เมนูวันหยุด
        }
       
        var country_act = 0;
        async function show_country(){
            var data = menu_country[0];
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container">'+data[y].name;
                if(country_search == data[y].id*1){
                    text = text+'<input type="checkbox" checked id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                    put_filter(data[y].id*1,`country`);
                }else{
                    text = text+'<input type="checkbox" id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                }
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
            }
            var data = menu_country[1];
            if(data){
                text = text+"<div id='moreprd' class='collapse'>";
                for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    if(country_search == data[y].id*1){
                        text = text+'<input type="checkbox" checked  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                        put_filter(data[y].id*1,`country`);
                    }else{
                        text = text+'<input type="checkbox"  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                    }
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                text = text+"</div>";
                    if(data.length >= 1){
                        text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>';
                    }
            }
            if(isWin || isMac){
                document.getElementById('show_country').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_country_mb').innerHTML = await text;
            }
           
            if(text == ''){
                $('#country-topic').hide();
                $('#country_input').hide();
            }
        }
        async function show_city(x){
            var data = menu_city[0];
            var text = '';
            var text_slide = '';
            for(let y in data){
                text = text+'<li><label class="check-container">'+data[y].name;
                if(city_search == data[y].id*1){
                    text = text+'<input type="checkbox" checked id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                    put_filter(data[y].id*1,`city`);
                }else{
                    text = text+'<input type="checkbox" id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                }
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
            }
            var data = menu_city[1];
            if(data){
                text = text+"<div id='morecity' class='collapse'>";
                for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    if(city_search == data[y].id*1){
                        text = text+'<input type="checkbox" checked id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                        put_filter(data[y].id*1,`city`);
                    }else{
                        text = text+'<input type="checkbox"  id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                    }
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                text = text+"</div>";
                    if(data.length >= 1){
                        text = text+'<a data-bs-toggle="collapse" data-bs-target="#morecity" class="seemore"> ดูเพิ่มเติม</a>';
                    }
            }
            if(isWin || isMac){
                document.getElementById('show_city').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_city_mb').innerHTML = await text;
            }
            if(text == ''){
                $('#city-topic').hide();
                $('#city_input').hide();
            }
            //ชื่อเมืองแสดงบนแบนเนอร์
            for(let c in city_slide){
                text_slide = text_slide+ '<div class="item" ><a href="javascript:void(0);" onclick="document.getElementById(`city'+city_slide[c].id+'`).click()" >';
                text_slide = text_slide+ '<div class="catss">';
                text_slide = text_slide+ 'ทัวร์'+city_slide[c].name;
                text_slide = text_slide+ '</div></a></div>';
            }
            if(city_slide.length == 0){
                $('#hide_slide').hide();
            }
            if(x){
                document.getElementById('slide_country').innerHTML = await text_slide;
            }
         
        }
        async function show_amupur(){
            var data = menu_amupur[0];
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container">'+data[y].name;
                text = text+'<input type="checkbox" id="amupur'+data[y].id+'" onclick="put_filter('+data[y].id+',`amupur`)" value="'+data[y].id+'">';
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
            }
            var data = menu_amupur[1];
            if(data){
                text = text+"<div id='moreamupur' class='collapse'>";
                for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    text = text+'<input type="checkbox"  id="amupur'+data[y].id+'" onclick="put_filter('+data[y].id+',`amupur`)" value="'+data[y].id+'">';
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                text = text+"</div>";
            
                    if(data.length >= 1){
                        text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreamupur" class="seemore"> ดูเพิ่มเติม</a>';
                    }
            }
            if(isWin || isMac){
                document.getElementById('show_amupur').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_amupur_mb').innerHTML = await text;
            }
            
            if(text == ''){
                $('#amupur-topic').hide();
            }
        }
        async function show_price(){
            var data = menu_price;
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container">'+data[y].name;
                if(price_search == data[y].id*1){
                    text = text+'<input type="checkbox" checked id="price'+data[y].id+'" onclick="put_filter('+data[y].id+',`price`)" value="'+data[y].id+'">';
                    put_filter(data[y].id*1,`price`);
                }else{
                    text = text+'<input type="checkbox" id="price'+data[y].id+'" onclick="put_filter('+data[y].id+',`price`)" value="'+data[y].id+'">';
                }
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
               
            }
            if(isWin || isMac){
                document.getElementById('show_price').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_price_mb').innerHTML = await text;
            }
            
           
            if(text == ''){
                $('#price-topic').hide();
            }
           
        }
        async function show_airline(){
            var data = menu_airline[0];
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container flex items-center gap-2 w-full whitespace-nowrap min-w-0">';
                if(data[y].img){
                    text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt="" class="w-8 h-8 object-contain flex-shrink-0 inline-block align-middle">';
                }
                text = text+'<span class="truncate inline-block align-middle leading-tight">'+data[y].name+'</span>';
                text = text+'<span class="count ml-2 text-gray-500 inline-block align-middle leading-tight">('+data[y].num+')</span>';
                text = text+'<input type="checkbox" id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'" class="ml-2 align-middle">';
                text = text+'<span class="checkmark align-middle"></span></label></li>';
            }
            var data = menu_airline[1];
            if(data){
                text = text+"<div id='moreairline' class='collapse'>";
                for(let y in data){
                    text = text+'<li><label class="check-container flex items-center gap-2 w-full whitespace-nowrap min-w-0">';
                    if(data[y].img){
                        text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt="" class="w-8 h-8 object-contain flex-shrink-0 inline-block align-middle">';
                    }
                    text = text+'<span class="truncate inline-block align-middle leading-tight">'+data[y].name+'</span>';
                    text = text+'<span class="count ml-2 text-gray-500 inline-block align-middle leading-tight">('+data[y].num+')</span>';
                    text = text+'<input type="checkbox"  id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'" class="ml-2 align-middle">';
                    text = text+'<span class="checkmark align-middle"></span></label></li>';
                }
                text = text+"</div>";
                    if(data.length >= 1){
                        text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreairline" class="seemore"> ดูเพิ่มเติม</a>';
                    }   
            }
            if(isWin || isMac){
                document.getElementById('show_airline').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_airline_mb').innerHTML = await text;
            }
           
           
            if(text == ''){
                $('#airline-topic').hide();
                $('#airline_input').hide();
            }
        }
        async function show_rating(){
            var data = menu_rating.sort((a, b) => a.name - b.name);
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container"><div class="rating">';
                if(data[y].name != 0){
                    for(n=1;n<=data[y].name;n++){
                        text = text+'<i class="bi bi-star-fill"></i>';
                    }     
                }else{
                    text = text+'ไม่มีระดับดาวที่พัก';
                }
                text = text+'</div><input type="checkbox" id="rating'+data[y].name+'" onclick="put_filter('+data[y].name+',`rating`)" value="'+data[y].name+'">';
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
            }
            if(isWin || isMac){
                document.getElementById('show_rating').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_rating_mb').innerHTML = await text;
            }
            
            if(text == ''){
                $('#rating-topic').hide();
            }
        }
        async function show_day(){
            var data = menu_day;
            var text = '';
            for(let y in data){
                text = text+'<li><label class="check-container">'+data[y].name+' วัน';
                text = text+'<input type="checkbox" id="day'+data[y].name+'" onclick="put_filter('+data[y].name+',`day`)" value="'+data[y].name+'">';
                text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
            }

            if(isWin || isMac){
                document.getElementById('show_day').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_day_mb').innerHTML = await text;
            }

            if(text == ''){
                $('#day-topic').hide();
            }
        }
        async function show_month(){
            var text = '';
            var month = menu_month;
            for(let year in month){
                text = text+'<li>'+year+'</li>';
                for(let m in month[year]){
                    text = text+'<li><label class="check-container">'+month[year][m].name;
                    text = text+'<input type="checkbox" id="month'+month[year][m].id+'" onclick="put_filter(`'+month[year][m].id+'`,`month`)" value="'+month[year][m].id+'">';
                    text = text+'<span class="checkmark"></span><div class="count">('+month[year][m].num+')</div></label></li>';
                }
            }

            if(isWin || isMac){
                document.getElementById('show_month').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_month_mb').innerHTML = await text;
            }
           
            
            if(text == ''){
                $('#month-topic').hide();
            }
        }
        async function show_holiday(){
            var text = '';
            var data = menu_holiday;
            for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    text = text+'<input type="checkbox" id="holiday'+data[y].id+'" onclick="put_filter(`'+data[y].id+'`,`holiday`)" value="'+data[y].id+'">';
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                
            }
            if(isWin || isMac){
                document.getElementById('show_holiday').innerHTML = await text;
            }else if(isIPhone || isAndroid || isIPad){
                document.getElementById('show_holiday_mb').innerHTML = await text;
            }
            if(text == ''){
                $('#holiday-topic').hide();
            }
        }
        //ค้นหาประเทศ
        async function find_country(){
            var keyword = document.getElementById('find_country').value;
            var find_data = new Array();
            var count_find = 0;
            if(keyword){
                var find_keyword = await country.filter(x=> x.country_name_th.indexOf(keyword) >= 0);
                if(find_keyword.length){
                    for(let f in find_keyword){
                        var num = await tour.filter(x => x.country_id.includes('"'+find_keyword[f].id+'"')).length;
                        if(num){
                            let info = {
                                id:find_keyword[f].id,
                                name:find_keyword[f].country_name_th != ''?find_keyword[f].country_name_th:find_keyword[f].country_name_en,
                                num:num,
                            }
                            if(!find_data[count_find]){
                                find_data[count_find] = new Array();
                            }
                            find_data[count_find].push(info);
                            if(find_data[count_find].length >= 10 && count_find == 0){
                                count_find++;
                            }
                        }
                    }
                    var data = find_data[0];
                    var text = '';
                    for(let y in data){
                        text = text+'<li><label class="check-container">'+data[y].name;
                        if(country_search == data[y].id*1){
                            text = text+'<input type="checkbox" checked id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                            put_filter(data[y].id*1,`country`);
                        }else{
                            text = text+'<input type="checkbox" id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                        }
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    var data = find_data[1];
                    if(data){
                        text = text+"<div id='moreprd' class='collapse'>";
                        for(let y in data){
                            text = text+'<li><label class="check-container">'+data[y].name;
                            if(country_search == data[y].id*1){
                                text = text+'<input type="checkbox" checked  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                                put_filter(data[y].id*1,`country`);
                            }else{
                                text = text+'<input type="checkbox"  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                            }
                            text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                        }
                        text = text+"</div>";
                            if(data.length >= 1){
                                text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>';
                            }
                    }
                    if(isWin || isMac){ 
                        document.getElementById('show_country').innerHTML = await text;
                    }else if(isIPhone || isAndroid || isIPad){
                        document.getElementById('show_country_mb').innerHTML = await text;
                    }
                }else{
                    if(isWin || isMac){ 
                        document.getElementById('show_country').innerHTML = '<center><strong class="text-danger" >ไม่พบผลการค้นหา</strong></center>';
                    }else if(isIPhone || isAndroid || isIPad){ 
                        document.getElementById('show_country_mb').innerHTML = '<center><strong class="text-danger">ไม่พบผลการค้นหา</strong></center>';
                    }
                }
            }else{
                var data = menu_country[0];
                var text = '';
                for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    if(country_search == data[y].id*1){
                        text = text+'<input type="checkbox" checked id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                        put_filter(data[y].id*1,`country`);
                    }else{
                        text = text+'<input type="checkbox" id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                    }
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                var data = menu_country[1];
                if(data){
                    text = text+"<div id='moreprd' class='collapse'>";
                    for(let y in data){
                        text = text+'<li><label class="check-container">'+data[y].name;
                        if(country_search == data[y].id*1){
                            text = text+'<input type="checkbox" checked  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                            put_filter(data[y].id*1,`country`);
                        }else{
                            text = text+'<input type="checkbox"  id="country'+data[y].id+'" onclick="put_filter('+data[y].id+',`country`)" value="'+data[y].id+'">';
                        }
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    text = text+"</div>";
                        if(data.length >= 1){
                            text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>';
                        }
                }
                if(isWin || isMac){ 
                    document.getElementById('show_country').innerHTML = await text;
                }else if(isIPhone || isAndroid || isIPad){  
                    document.getElementById('show_country_mb').innerHTML = await text;
                }
            }
        }
         //ค้นหาเมือง
        async function find_city(){
            var keyword = document.getElementById('find_city').value;
            var find_data = new Array();
            var count_find = 0;
            if(keyword){
                var find_keyword = await city.filter(x=> x.city_name_th.indexOf(keyword) >= 0);
                if(find_keyword.length){
                    for(let f in find_keyword){
                        var num = await tour.filter(x => x.city_id.includes('"'+find_keyword[f].id+'"')).length;
                        if(num){
                            let info = {
                                id:find_keyword[f].id,
                                name:find_keyword[f].city_name_th != ''?find_keyword[f].city_name_th:find_keyword[f].city_name_en,
                                num:num,
                            }
                            if(!find_data[count_find]){
                                find_data[count_find] = new Array();
                            }
                            find_data[count_find].push(info);
                            if(find_data[count_find].length >= 10 && count_find == 0){
                                count_find++;
                            }
                        }
                    }
                    var data = find_data[0];
                    var text = '';
                    for(let y in data){
                        text = text+'<li><label class="check-container">'+data[y].name;
                        if(city_search == data[y].id*1){
                            text = text+'<input type="checkbox" checked id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                            put_filter(data[y].id*1,`city`);
                        }else{
                            text = text+'<input type="checkbox" id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                        }
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    var data = find_data[1];
                    if(data){
                        text = text+"<div id='moreprd' class='collapse'>";
                        for(let y in data){
                            text = text+'<li><label class="check-container">'+data[y].name;
                            if(city_search == data[y].id*1){
                                text = text+'<input type="checkbox" checked  id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                                put_filter(data[y].id*1,`city`);
                            }else{
                                text = text+'<input type="checkbox"  id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                            }
                            text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                        }
                        text = text+"</div>";
                            if(data.length >= 1){
                                text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>';
                            }
                    }
                    if(isWin || isMac){
                        document.getElementById('show_city').innerHTML = await text;
                    }else if(isIPhone || isAndroid || isIPad){
                        document.getElementById('show_city_mb').innerHTML = await text;
                    }
                }else{
                    if(isWin || isMac){
                        document.getElementById('show_city').innerHTML = '<center><strong class="text-danger" >ไม่พบผลการค้นหา</strong></center>';
                    }else if(isIPhone || isAndroid || isIPad){
                        document.getElementById('show_city_mb').innerHTML = '<center><strong class="text-danger">ไม่พบผลการค้นหา</strong></center>';
                
                    }
                }
            }else{
                var data = menu_city[0];
                var text = '';
                for(let y in data){
                    text = text+'<li><label class="check-container">'+data[y].name;
                    if(city_search == data[y].id*1){
                        text = text+'<input type="checkbox" checked id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                        put_filter(data[y].id*1,`city`);
                    }else{
                        text = text+'<input type="checkbox" id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                    }
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                var data = menu_city[1];
                if(data){
                    text = text+"<div id='moreprd' class='collapse'>";
                    for(let y in data){
                        text = text+'<li><label class="check-container">'+data[y].name;
                        if(city_search == data[y].id*1){
                            text = text+'<input type="checkbox" checked  id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                            put_filter(data[y].id*1,`city`);
                        }else{
                            text = text+'<input type="checkbox"  id="city'+data[y].id+'" onclick="put_filter('+data[y].id+',`city`)" value="'+data[y].id+'">';
                        }
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    text = text+"</div>";
                        if(data.length >= 1){
                            text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>';
                        }
                }
                if(isWin || isMac){
                    document.getElementById('show_city').innerHTML = await text;
                }else if(isIPhone || isAndroid || isIPad){
                    document.getElementById('show_city_mb').innerHTML = await text;
                }
            }
        }
        // ค้นหาสายการบิน
        async function find_airline(){
            var keyword = document.getElementById('find_airline').value;
            var find_data = new Array();
            var count_find = 0;
            if(keyword){
                var find_keyword = await airline.filter(x=> x.travel_name.indexOf(keyword) >= 0);
                if(find_keyword.length){
                    for(let f in find_keyword){
                        var num = await tour.filter(x => x.airline_id == find_keyword[f].id).length;
                        if(num){
                            let info = {
                                id:find_keyword[f].id,
                                name:find_keyword[f].travel_name,
                                num:num,
                                img:find_keyword[f].image,
                            }
                            if(!find_data[count_find]){
                                find_data[count_find] = new Array();
                            }
                            find_data[count_find].push(info);
                            if(find_data[count_find].length >= 10 && count_find == 0){
                                count_find++;
                            }
                        }
                    }
                    var data = find_data[0];
                    var text = '';
                    for(let y in data){
                        text = text+'<li><label class="check-container">'
                        if(data[y].img){
                            text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt=""></img>';
                        }
                        text = text+' '+data[y].name;
                        text = text+'<input type="checkbox" id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'">';
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    var data = find_data[1];
                    if(data){
                        text = text+"<div id='moreairline' class='collapse'>";
                        for(let y in data){
                            text = text+'<li><label class="check-container">';
                            if(data[y].img){
                                text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt=""></img>';
                            }
                            text = text+' '+data[y].name;
                            text = text+'<input type="checkbox"  id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'">';
                            text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                        }
                        text = text+"</div>";
                        if(data.length >= 1){
                            text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreairline" class="seemore"> ดูเพิ่มเติม</a>';
                        }   
                    }
                    if(isWin || isMac){ 
                        document.getElementById('show_airline').innerHTML = await text;
                    }else if(isIPhone || isAndroid || isIPad){
                        document.getElementById('show_airline_mb').innerHTML = await text;
                    }
                }else{
                    if(isWin || isMac){ 
                        document.getElementById('show_airline').innerHTML = '<center><strong class="text-danger" >ไม่พบผลการค้นหา</strong></center>';
                    }else if(isIPhone || isAndroid || isIPad){
                        document.getElementById('show_airline_mb').innerHTML = '<center><strong class="text-danger">ไม่พบผลการค้นหา</strong></center>';
                    }    
                }
            }else{
                var data = menu_airline[0];
                var text = '';
                for(let y in data){
                    text = text+'<li><label class="check-container">'
                    if(data[y].img){
                        text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt=""></img>';
                    }
                    text = text+' '+data[y].name;
                    text = text+'<input type="checkbox" id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'">';
                    text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                }
                var data = menu_airline[1];
                if(data){
                    text = text+"<div id='moreairline' class='collapse'>";
                    for(let y in data){
                        text = text+'<li><label class="check-container">';
                        if(data[y].img){
                            text = text+'<img src="https://nexttrip.b-cdn.net/'+data[y].img+'" alt=""></img>';
                        }
                        text = text+' '+data[y].name;
                        text = text+'<input type="checkbox"  id="airline'+data[y].id+'" onclick="put_filter('+data[y].id+',`airline`)" value="'+data[y].id+'">';
                        text = text+'<span class="checkmark"></span><div class="count">('+data[y].num+')</div></label></li>';
                    }
                    text = text+"</div>";
                        if(data.length >= 1){
                            text = text+'<a data-bs-toggle="collapse" data-bs-target="#moreairline" class="seemore"> ดูเพิ่มเติม</a>';
                        }   
                }
                if(isWin || isMac){ 
                    document.getElementById('show_airline').innerHTML = await text;
                }else if(isIPhone || isAndroid || isIPad){
                    document.getElementById('show_airline_mb').innerHTML = await text;
                }
            }
        }
        async function put_filter (id,type){
          await check_date();
          if(type_data[type].includes(id)){
            var index = type_data[type].indexOf(id);
            type_data[type].splice(index,1);
            count_pagin = 1;
           await check_month(index);
           await check_holiday(index);
          }else{
            type_data[type].push(id);
            count_pagin = 1;
          }  
        //   console.log(type_data,'type_data-check')
          await filter_tour();
        }
     
        async function filter_tour (){
            // data_tour = new Array();
            data_tour = await tour;
            var count_tour = 0;
            var check_fill = true;
            // console.log(tour.length,'tour-check')
            if(type_data.country.length){
               for(let i in type_data.country){
                    // let data = await tour.filter(x => x.country_id.includes('"'+type_data.country[i]+'"'));
                    data_tour = await data_tour.filter(x => x.country_id.includes('"'+type_data.country[i]+'"'));
                    // array mearge
                    // data_tour = await data_tour.concat(data);
               }
               check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check1')
            if(type_data.price.length){
                for(let i in type_data.price){
                    //  let data = await tour.filter(x => x.price_group == type_data.price[i]);
                    //  data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => x.price_group == type_data.price[i]);
                }
                check_fill = false;
             }
            //  console.log(data_tour.length,'data_tour-check2')
            if(type_data.airline.length){
                for(let i in type_data.airline){
                    //  let data = await tour.filter(x => x.airline_id == type_data.airline[i]);
                    //  data_tour = await data_tour.concat(data);
                    data_tour =   await data_tour.filter(x => x.airline_id == type_data.airline[i]);
                }
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check3')
            if(type_data.rating.length){
                for(let i in type_data.rating){
                    // let data = await tour.filter(x => x.rating == type_data.rating[i]);
                    // data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => (x.rating ? x.rating:0) == type_data.rating[i]);
                }
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check4')
            if(type_data.day.length){
                for(let i in type_data.day){
                    let check = menu_day.find(x => x.name  ==  type_data.day[i]);
                    // let data = await tour.filter(x => check.tour.includes(x.id));
                    // data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => check.tour.includes(x.id));
                } 
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check5')
            if(type_data.holiday.length){
                for(let i in type_data.holiday){
                    let check = menu_holiday.find(x => x.id  ==  type_data.holiday[i]);
                    // let data = await tour.filter(x => check.tour.includes(x.id));
                    // data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => check.tour.includes(x.id));
                }
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check6')
            if(type_data.month.length){
                // console.log(menu_month,'check menu_month',)
                for(let i in type_data.month){
                    for(let m in menu_month){
                        let check = menu_month[m].find(x => x.id  ==  type_data.month[i]);
                        // console.log(check,'check month')
                        if(check){
                            // let data = await tour.filter(x => check.tour.includes(x.id));
                            // data_tour = await data_tour.concat(data);
                            data_tour = await data_tour.filter(x => check.tour.includes(x.id));
                        }
                       
                    }
                } 
                check_fill = false;
            }
            // console.log(data_tour,'data_tour-check7')
            if(type_data.city.length){
                for(let i in type_data.city){
                    //  let data = await tour.filter(x => x.city_id.includes('"'+type_data.city[i]+'"'));
                    //  // array mearge
                    //  data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => x.city_id.includes('"'+type_data.city[i]+'"'));
                }
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check8')
            if(type_data.amupur.length){
                for(let i in type_data.amupur){
                    //  let data = await tour.filter(x => x.district_id.includes('"'+type_data.amupur[i]+'"'));
                    //  // array mearge
                    //  data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => x.district_id.includes('"'+type_data.amupur[i]+'"'));
                }
                check_fill = false;
            }
            // console.log(data_tour.length,'data_tour-check9')
            if(type_data.start_date.length){
                var check_tour = new Array();
                if(start_search && end_search){
                   var pe = await period.filter(x=> x.check_start >= str_start && x.check_start <= str_end);
                }else{
                   var pe = await period.filter(x => new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                }
                for(let p in pe){
                    check_tour.push(pe[p].tour_id);
                    // pe_check.push(pe[p].id);
                    // let data = await tour.filter(x => x.id == pe[p].tour_id);
                    // data_tour = await data_tour.concat(data);
                }
                data_tour = await data_tour.filter(x => check_tour.includes(x.id));
               check_fill = false;
               
            }
            // console.log(data_tour.length,'data_tour-check10')
            // if(check_fill){
                // console.log(travel_search,'travel_search.length')
                // console.log(type_data.tour_code,'tour_code.length')
                // console.log(start_search,'start_search')
                // console.log(end_search,'end_search')
                if(type_data.travel_search.length){
                        // let data = await tour.filter(x => type_data.travel_search.includes(x.id));
                        // data_tour = await data_tour.concat(data);
                        data_tour = await data_tour.filter(x => type_data.travel_search.includes(x.id));
                        check_fill = false;
                        // console.log(data_tour,'travel_search.length')
                }if(type_data.tour_code.length){
                    // let data = await tour.filter(x => type_data.tour_code.includes(x.id));
                    // data_tour = await data_tour.concat(data);
                    data_tour = await data_tour.filter(x => type_data.tour_code.includes(x.id));
                    check_fill = false;
                }
                console.log(type_data,'type_data11111',tour_code)
                if(type_data.tag_search.length){
                    data_tour = await data_tour.filter(x => x.tag_id.includes('"'+type_data.tag_search+'"'));
                    // console.log(type_data.tag_search,'tag_search.length',data_tour)
                    check_fill = false;
                }
                // else if(start_search && end_search){
                //     var search_check = new Array();
                //     var date_search = await period.filter(x=> x.check_start >= str_start && x.check_end <= str_end);
                //     for(let d in date_search){
                //         search_check.push(date_search[d].tour_id);
                //         // var date_tour = date_search[d].tour_id;
                //         // let data = await tour.filter(x => x.id == date_tour);
                //         // data_tour = await data_tour.concat(data);
                //     }
                //     data_tour = await data_tour.filter(x =>search_check.includes(x.id));
                // }
                if(check_fill){
                    data_tour = await tour;
                }
            // }
            // console.log(data_tour.length,'data_tour-check11')
            // หา Unique
            // data_tour = await data_tour.filter((value, index, self) => {
            //     return self.indexOf(value) === index;
            // });
            if(document.getElementById('orderby_data2').value){
                var check_order = document.getElementById('orderby_data2').value;
            }else{
                var check_order = document.getElementById('orderby_data1').value;
            }
            if(check_order*1 != 0){
                OrderByData(check_order*1);
            //     if(check_order*1 == 1){
            //         await data_tour.sort((a, b) => a.price - b.price);
            //     }else if(check_order*1 == 2){
            //         await data_tour.sort((a, b) => b.tour_views - a.tour_views);
            //     }else if(check_order*1 == 3){
            //         data_tour = await tour.filter(x => special_price.includes(x.id));
            //     }else if(check_order*1 == 4){
            //         data_tour = await tour.filter(x => promotion.includes(x.id));
            //     }
            }else{
                main_tour = new Array();
                for(let d in data_tour){
                    if(!main_tour[count_tour]){
                        main_tour[count_tour] = new Array();
                    }
                    if(type_data.start_date.length){
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    }else{
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                    }
                    // let group_period = Object.groupBy(period_data, group => { return group.group_date; });
                    let group_period = new Array();
                    for(let p in period_data){
                        if(!group_period[period_data[p].group_date]){
                            group_period[period_data[p].group_date] = new Array;
                        }
                        group_period[period_data[p].group_date].push(period_data[p])
                    }
                    let country_data = JSON.parse(data_tour[d].country_id);
                    var country_fil = new Array();
                    for(let t in country_data){
                        country_fil =  await country.filter(x => x.id == country_data[t]);
                    }
                    let info = {
                        tour:data_tour[d],
                        airline: await airline.find(x=> x.id == data_tour[d].airline_id),
                        period: group_period,
                        tour_type: await tour_type.find(x=>x.id == data_tour[d].type_id),
                        sold_out: period_soldout,
                        country:country_fil,
                        // period: await period.filter(x=> x.tour_id == data_tour[d].id && x.count > 0 && x.status_period != 3),
                    }
                    main_tour[count_tour].push(info);
                    if(main_tour[count_tour].length >= 15){
                        count_tour++;
                    }
                    
                }
                // console.log(main_tour,'show_tour')
                document.getElementById('show_total').innerHTML = 'พบ '+data_tour.length+' รายการ';
                total_page = count_tour;
                await show_tour(0);
                // readMore();
                await SelectFilter();
            }
            
          }
          var count_pagin = 1;

          async function show_tour(x){
           
            if(x == undefined){
                count_pagin++;
            }
           
            var tour_show = main_tour[count_pagin-1];
            if(tour_show && (typeof tour_show === 'string' || (typeof tour_show === 'object' && tour_show.length >= 15)) && main_tour.length > 1){
                $('#btn-showmore').removeClass('d-none');
            }else{
                $('#btn-showmore').addClass('d-none');
            }
                        let text = '';
                        let text_grid = '';
                        text += `<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">`;
                        for(let y in tour_show){
                                let t = tour_show[y];
                                let price = t.tour.special_price > 0 ? t.tour.price - t.tour.special_price : t.tour.price;
                                let priceText = t.tour.special_price > 0
                                        ? `ปกติ ${Intl.NumberFormat('th-TH', {currency:'THB'}).format(t.tour.price)}${Intl.NumberFormat('th-TH', {currency:'THB'}).format(price)} บาท`
                                        : `${Intl.NumberFormat('th-TH', {currency:'THB'}).format(price)} บาท</span>`;
                                let country = t.country && t.country.length ? (t.country[0].country_name_th || t.country[0].country_name_en) : '';
                                let rating = '';
                                if (t.tour.rating > 0) {
                                        for (let i = 1; i <= t.tour.rating; i++) {
                                                rating += `<i class='bi bi-star-fill text-yellow-400'></i>`;
                                        }
                                }

                                let soldOut = Object.keys(t.period).length === 0;
                                // text += `
                                // <div class="w-full md:w-1/2 lg:w-1/3 p-2 inline-block align-top">
                                //     <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col h-full hover:shadow-2xl transition-shadow duration-300">
                                //         <a href="https://nexttripholiday.com/tour/${t.tour.slug}" target="_blank" class="block">
                                //             <img src="https://nexttrip.b-cdn.net/${t.tour.image}" alt="${t.tour.name}" class="w-full h-48 object-cover">
                                //         </a>
                                //         <div class="p-4 flex-1 flex flex-col">
                                //             <div class="flex items-center justify-between mb-2">
                                //                 <span class="text-xs bg-blue-100 text-blue-600 rounded px-2 py-1">${country}</span>
                                //                 <span class="text-xs text-gray-500">รหัสทัวร์: <span class="font-semibold">${t.tour.code1_check ? t.tour.code1.slice(-6) : t.tour.code.slice(-6)}</span></span>
                                //             </div>
                                //             <h3 class="text-lg font-bold mb-1"><a href="/tour/${t.tour.slug}" target="_blank">${t.tour.name}</a></h3>
                                //             <div class="flex items-center mb-2">${rating}</div>
                                //             <div class="mb-2">${priceText}</div>
                                           
                                //             <div class="flex flex-wrap gap-2 mb-2">
                                               
                                //                 ${t.tour.shop ? `<span class='bg-pink-100 text-pink-700 px-2 py-1 rounded text-xs'><i class='bi bi-bag-fill'></i> ช้อป: ${t.tour.shop}</span>` : ''}
                                //                 ${t.tour.eat ? `<span class='bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs'><i class='bi bi-cup-hot-fill'></i> กิน: ${t.tour.eat}</span>` : ''}
                                //                 ${t.tour.special ? `<span class='bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs'><i class='bi bi-bookmark-heart-fill'></i> พิเศษ: ${t.tour.special}</span>` : ''}
                                          
                                //             </div>
                                //             ${soldOut ? `<div class='bg-red-100 text-red-600 text-center rounded p-2 my-2 font-bold'>SOLD OUT<br><span class='text-xs font-normal'>ว้า! หมดแล้ว คุณตัดสินใจช้าไป</span></div>` : ''}
                                //             <div class="mt-auto flex justify-between items-center">
                                //                 <a href="/tour/${t.tour.slug}" target="_blank" class="btn btn-main-og bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">รายละเอียด</a>
                                //                 <button class="wishlist ml-2" data-tour-id="${t.tour.id}" onclick="likedTour(${t.tour.id})"><i class="bi bi-heart-fill text-pink-500"></i></button>
                                //             </div>
                                //         </div>
                                //     </div>
                                // </div>
                                // `;
                             text += `
                             <article class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow overflow-hidden ">
  <div class="relative">
    <a href="#" class="block overflow-hidden">
    <img src="https://nexttrip.b-cdn.net/${t.tour.image}"
     alt="ทัวร์ญี่ปุ่น"
     class="w-full max-h-600 object-contain bg-gray-100 rounded-t-2xl">

    </a>

    <button type="button" class="absolute top-3 right-3 inline-flex items-center justify-center
            w-9 h-9 rounded-full bg-white/90 backdrop-blur shadow hover:bg-white" aria-label="บันทึก">
      <svg viewBox="0 0 24 24" class="w-5 h-5 text-rose-500" fill="currentColor"><path d="M11.645 20.91l-.007-.003-.022-.012a29.79 29.79 0 01-1.454-.836c-1.255-.743-2.969-1.905-4.727-3.514C2.556 14.138 1 12.063 1 9.7 1 7.387 2.883 5.5 5.2 5.5c1.33 0 2.6.57 3.46 1.56A4.65 4.65 0 0112 5c1.2 0 2.34.5 3.34 1.46.86-.99 2.13-1.56 3.46-1.56 2.317 0 4.2 1.886 4.2 4.2 0 2.363-1.556 4.438-3.485 6.845-1.758 1.61-3.472 2.772-4.727 3.514a29.79 29.79 0 01-1.454.836l-.022.012-.007.003a.75.75 0 01-.646 0z"/></svg>
    </button>

    
  </div>

  <div class="px-4 pt-5 pb-4">
  <div class="flex items-center justify-center gap-2">
      <span class="inline-flex items-center justify-center text-[13px] font-semibold text-rose-600
                   bg-rose-50 rounded-full px-3 py-1"> 5 วัน 3 คืน </span>
                   ${t.airline && t.airline.image ? ` <span class="text-xs">สายการบิน</span> : <img src="https://nexttrip.b-cdn.net/${t.airline.image}" alt="Airline" class="">` : ''}
                   
    </div>

    <h3 class="mt-3 font-extrabold text-[18px] leading-snug text-gray-900 line-clamp-2">
     ${t.tour.name}
    </h3>

    <div class="mt-3 space-y-2 text-[14px] text-gray-700">
      <div class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 rounded-full px-2.5 py-1">
        <span class="text-xs">📍</span> ${country}
      </div>
      <div class="flex items-center gap-1">
        <span class="text-gray-500">โรงแรม: </span>
        <!-- stars -->
       ${rating}
      </div>
            <div class="text-gray-600">กำหนดการเดินทาง: ${(() => {
                let allPeriods = [];
                for (let key of Object.keys(t.period)) {
                    for (let p of t.period[key]) {
                        allPeriods.push({start: new Date(p.start_date), end: new Date(p.end_date)});
                    }
                }
                if (allPeriods.length > 0) {
                    allPeriods.sort((a, b) => a.start - b.start);
                    let first = allPeriods[0].start;
                    let last = allPeriods[allPeriods.length-1].end;
                    let months = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                    return `${months[first.getMonth()]} ${first.getFullYear()} – ${months[last.getMonth()]} ${last.getFullYear()}`;
                } else {
                    return '-';
                }
            })()}</div>
      <div class="text-gray-600">รหัสทัวร์: <span class="font-semibold">${t.tour.code1_check ? t.tour.code1.slice(-6) : t.tour.code.slice(-6)}</span></div>
    </div>

    <div class="mt-4 flex items-end justify-between">
      <div>
        <div class="text-sm text-gray-500">เริ่มต้น</div>
        <div class="text-[22px] leading-none font-extrabold text-orange-600">
          ${priceText} <span class="text-[13px] font-semibold text-gray-500 ml-1">THB</span>
        </div>
      </div>

      <a href="/tour/${t.tour.slug}"
         class="inline-flex items-center justify-center h-10 px-4 rounded-lg bg-orange-500 text-white
                font-semibold shadow-sm hover:bg-orange-600 transition whitespace-nowrap shrink-0">
        รายละเอียด
      </a>
    </div>
  </div>
</article>

                             `;
                        }
                        text += `</div>`
                        if(x != undefined){
                                document.getElementById('show_tour').innerHTML = `<div class="flex flex-wrap -m-2">${text}</div>`;
                                document.getElementById('show_grid').innerHTML = text_grid;
                        }else{
                                $('#show_tour').append(`<div class="flex flex-wrap -m-2">${text}</div>`);
                                $('#show_grid').append(text_grid);
                        }
                        await readMore();
        }
        // ฟิลเตอร์ที่เลือก
        async function SelectFilter(){
        var text = '';
        for(let x in type_data){
            if(type_data[x].length){
                if(x == 'price'){
                    for(let y in type_data[x]){
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+price[type_data[x][y]]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                }
                if(x == 'month'){
                    for(let y in type_data[x]){
                        let month_value = type_data[x][y];
                        let m =  month_value.substr(0,2)*1;
                        let year =  month_value.substr(2,5);
                        text += "<li onclick='document.getElementById(`"+x+month_value+"`).click()'><label class='check-container'>"+month_data[m]+' '+year+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                   await check_month(type_data[x]);
                }
                if(x == 'holiday'){
                    for(let y in type_data[x]){
                        let day = holiday.find(z=>z.id == type_data[x][y]*1);
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+day.name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                  await check_holiday(type_data[x]);
                }
                if(x == 'country'){
                    for(let y in type_data[x]){
                        let country_data = country.find(z=>z.id == type_data[x][y]);
                        let name = country_data.country_name_th != ''?country_data.country_name_th:country_data.country_name_en;
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                }
                if(x == 'day'){
                    for(let y in type_data[x]){
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+type_data[x][y]+" วัน <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                }
                if(x == 'airline'){
                    for(let y in type_data[x]){
                        let airline_data = airline.find(z=>z.id == type_data[x][y]);
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+airline_data.travel_name+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                }
                if(x == 'rating'){
                    for(let y in type_data[x]){
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>";
                        if(type_data[x][y] != 0){
                            text += type_data[x][y]+' ดาว';
                        }else{
                            text += 'ไม่มีระดับดาวที่พัก';
                        }   
                        text += " <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";   
                    }
                }
                if(x == 'city'){
                    for(let y in type_data[x]){
                        let city_data = city.find(z=>z.id == type_data[x][y]);
                        let name = city_data.city_name_th != ''?city_data.city_name_th:city_data.city_name_en;;
                        if(city_search){
                            text += "<li onclick='DeletedCity()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                        }else{
                            text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                        }
                    }
                }
                if(x == 'amupur'){
                    for(let y in type_data[x]){
                        let amupur_data = amupur.find(z=>z.id == type_data[x][y]);
                        let name = amupur_data.name_th != ''?amupur_data.name_th:amupur_data.name_en;;
                        text += "<li onclick='document.getElementById(`"+x+type_data[x][y]+"`).click()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                    }
                }
            }
        } 
        await check_date();
        if(isWin || isMac){
            document.getElementById('show_select').innerHTML = text;
        }else if(isIPhone || isAndroid || isIPad){
            //mobile
            document.getElementById('show_select_mb').innerHTML = text;
            document.getElementById('show_select_all').innerHTML = text;
        }
    }
    window.onload = function() {
        setInitialLikedStatus();
    };
    // กด Favorite
    const likedTours = JSON.parse(localStorage.getItem('likedTours')) || [];

    function setInitialLikedStatus() {
        const heartIcons = document.querySelectorAll('.wishlist');
        
        heartIcons.forEach(icon => {
            const tourId = parseInt(icon.getAttribute('data-tour-id'));
            if (likedTours.includes(tourId)) {
                icon.classList.add('active');
            }
        });
    }

    async function likedTour(tourId) {
        const index = likedTours.indexOf(tourId);

        if (index === -1) {
            likedTours.push(tourId);
        } else {
            likedTours.splice(index, 1);
        }

        // บันทึก likedTours ใน local storage
        localStorage.setItem('likedTours', JSON.stringify(likedTours));

        // อัปเดตสถานะของไอคอนถูกใจ
        const heartIcon = document.querySelector(`[data-tour-id="${tourId}"]`);
        if (likedTours.includes(tourId)) {
            heartIcon.classList.add('active');
            toastr.success("ได้เพิ่มทัวร์ในรายการที่ต้องการสำเร็จแล้ว");
        } else {
            heartIcon.classList.remove('active');
            toastr.error("ลบรายการทัวร์ที่ต้องการสำเร็จแล้ว");
        }

        const likedCountElement = document.getElementById('numberwishls');
        // แสดงจำนวนที่ถูกใจใน header
        likedCountElement.textContent = `${likedTours.length}`;
    }
    // เรียงลำดับ
    async function OrderByData(value){
        count_pagin = 1;
        // ราคาถูกที่สุด
        if(value == 1){
           await data_tour.sort((a, b) => a.price - b.price);
                       main_tour = new Array();
            var count_tour = 0;
            for(let d in data_tour){
                if(!main_tour[count_tour]){
                    main_tour[count_tour] = new Array();
                }
                if(type_data.start_date.length){
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                }else{
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                }
                // let period_data = await period.filter(x=> x.tour_id == data_tour[d].id && x.count > 0 && x.status_period != 3);
                let group_period = new Array();
                    for(let p in period_data){
                        if(!group_period[period_data[p].group_date]){
                            group_period[period_data[p].group_date] = new Array;
                        }
                        group_period[period_data[p].group_date].push(period_data[p])
                    }
                let country_data = JSON.parse(data_tour[d].country_id);
                var country_fil = new Array();
                for(let t in country_data){
                    country_fil =  await country.filter(x => x.id == country_data[t]);
                }
                let info = {
                    tour:data_tour[d],
                    airline: await airline.find(x=> x.id == data_tour[d].airline_id),
                    period: group_period,
                    tour_type: await tour_type.find(x=>x.id == data_tour[d].type_id),
                    sold_out: period_soldout,
                    country:country_fil,
                }
                main_tour[count_tour].push(info);
                if(main_tour[count_tour].length >= 15){
                    count_tour++;
                }
            }
            document.getElementById('show_total').innerHTML = 'พบ '+data_tour.length+' รายการ';
            total_page = count_tour;
           
            await show_tour(0);
            // readMore();
            await SelectFilter();
        }
        // ดูมากสุด
        if(value == 2){
            await data_tour.sort((a, b) => b.tour_views - a.tour_views);
                         main_tour = new Array();
             var count_tour = 0;
             for(let d in data_tour){
                 if(!main_tour[count_tour]){
                     main_tour[count_tour] = new Array();
                 }
                if(type_data.start_date.length){
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                }else{
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                }
                //  let period_data = await period.filter(x=> x.tour_id == data_tour[d].id && x.count > 0 && x.status_period != 3);
                 let group_period = new Array();
                 for(let p in period_data){
                     if(!group_period[period_data[p].group_date]){
                         group_period[period_data[p].group_date] = new Array;
                     }
                     group_period[period_data[p].group_date].push(period_data[p])
                 }
                 let country_data = JSON.parse(data_tour[d].country_id);
                 var country_fil = new Array();
                 for(let t in country_data){
                     country_fil =  await country.filter(x => x.id == country_data[t]);
                }
                let info = {
                    tour:data_tour[d],
                    airline: await airline.find(x=> x.id == data_tour[d].airline_id),
                    period: group_period,
                    tour_type: await tour_type.find(x=>x.id == data_tour[d].type_id),
                    sold_out: period_soldout,
                    country:country_fil,
                }
                main_tour[count_tour].push(info);
                if(main_tour[count_tour].length >= 15){
                     count_tour++;
                }
             }
             document.getElementById('show_total').innerHTML = 'พบ '+data_tour.length+' รายการ';
             total_page = count_tour;
             
             await show_tour(0);
            //  readMore();
            await SelectFilter();
        }
        // มีลดราคา
        if(value == 3){
            var order_tour = await data_tour.filter(x => special_price.includes(x.id));
                        main_tour = new Array();
            var count_tour = 0;
            var count_num = 0;
            for(let d in order_tour){
                if(order_tour[d].special_price > 0 ){
                    if(!main_tour[count_tour]){
                        main_tour[count_tour] = new Array();
                    }
                    if(type_data.start_date.length){
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    }else{
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                    }
                    // let period_data = await period.filter(x=> x.tour_id == order_tour[d].id && x.count > 0 && x.status_period != 3);
                    let group_period = new Array();
                    for(let p in period_data){
                        if(!group_period[period_data[p].group_date]){
                            group_period[period_data[p].group_date] = new Array;
                        }
                        group_period[period_data[p].group_date].push(period_data[p])
                    }
                    let country_data = JSON.parse(order_tour[d].country_id);
                    var country_fil = new Array();
                    for(let t in country_data){
                         country_fil =  await country.filter(x => x.id == country_data[t]);
                    }
                    let info = {
                        tour:order_tour[d],
                        airline: await airline.find(x=> x.id == order_tour[d].airline_id),
                        period: group_period,
                        tour_type: await tour_type.find(x=>x.id == order_tour[d].type_id),
                        sold_out: period_soldout,
                        country:country_fil,
                    }
                    main_tour[count_tour].push(info);
                    if(main_tour[count_tour].length >= 15){
                        count_tour++;
                    }
                    count_num++;
                }
            }
            document.getElementById('show_total').innerHTML = 'พบ '+count_num+' รายการ';
            total_page = count_tour;
            await show_tour(0);
            // readMore();
            await SelectFilter();
        }
        // มีโปรโมชั่น
        if(value == 4){
            var order_tour = await data_tour.filter(x => promotion.includes(x.id));
                        main_tour = new Array();
            var count_tour = 0;
            var count_num = 0;
            for(let d in order_tour){
                if(order_tour[d].special_price > 0 ){
                    if(!main_tour[count_tour]){
                        main_tour[count_tour] = new Array();
                    }
                    if(type_data.start_date.length){
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    }else{
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                    }
                    // let period_data = await period.filter(x=> x.tour_id == order_tour[d].id && x.count > 0 && x.status_period != 3);
                    let group_period = new Array();
                    for(let p in period_data){
                        if(!group_period[period_data[p].group_date]){
                            group_period[period_data[p].group_date] = new Array;
                        }
                        group_period[period_data[p].group_date].push(period_data[p])
                    }
                    let country_data = JSON.parse(order_tour[d].country_id);
                    var country_fil = new Array();
                    for(let t in country_data){
                         country_fil =  await country.filter(x => x.id == country_data[t]);
                    }
                    let info = {
                        tour:order_tour[d],
                        airline: await airline.find(x=> x.id == order_tour[d].airline_id),
                        period: group_period,
                        tour_type: await tour_type.find(x=>x.id == order_tour[d].type_id),
                        sold_out: period_soldout,
                        country:country_fil,
                    }
                    main_tour[count_tour].push(info);
                    if(main_tour[count_tour].length >= 15){
                        count_tour++;
                    }
                    count_num++;
                }
            }
            document.getElementById('show_total').innerHTML = 'พบ '+count_num+' รายการ';
            total_page = count_tour;
            await show_tour(0);
            // readMore();
            await SelectFilter();
       }
       // ไม่เรียง
       if(value == 0){
            // data_tour = await tour;
            main_tour = new Array();
            var count_tour = 0;
            for(let d in data_tour){
                if(!main_tour[count_tour]){
                    main_tour[count_tour] = new Array();
                }
                if(type_data.start_date.length){
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                }else{
                    var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                    var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                }
                // let period_data = await period.filter(x=> x.tour_id == data_tour[d].id && x.count > 0 && x.status_period != 3);
                let group_period = new Array();
                for(let p in period_data){
                    if(!group_period[period_data[p].group_date]){
                        group_period[period_data[p].group_date] = new Array;
                    }
                    group_period[period_data[p].group_date].push(period_data[p])
                }
                let country_data = JSON.parse(data_tour[d].country_id);
                var country_fil = new Array();
                for(let t in country_data){
                     country_fil =  await country.filter(x => x.id == country_data[t]);
                }
                let info = {
                    tour:data_tour[d],
                    airline: await airline.find(x=> x.id == data_tour[d].airline_id),
                    period: group_period,
                    tour_type: await tour_type.find(x=>x.id == data_tour[d].type_id),
                    sold_out: period_soldout,
                    country:country_fil,
                }
                main_tour[count_tour].push(info);
                if(main_tour[count_tour].length >= 15){
                    count_tour++;
                }
            }
            document.getElementById('show_total').innerHTML = 'พบ '+data_tour.length+' รายการ';
            total_page = count_tour;
            await show_tour(0);
            // readMore();
            await SelectFilter();
       }
    }
     // เรียงหาประเเภททัวร์
     async function OrderByType(value){
            var order_tour = await data_tour.filter(x => x.type_id == value);
            main_tour = new Array();
            var count_tour = 0;
            var count_num = 0;
            count_pagin = 1;
            for(let d in order_tour){
                    if(!main_tour[count_tour]){
                        main_tour[count_tour] = new Array();
                    }
                    if(type_data.start_date.length){
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3 && new Date(x.start_date).valueOf() >= new Date(type_data.start_date).valueOf()  && new Date(x.start_date).valueOf() <=   new Date(type_data.end_date).valueOf());
                    }else{
                        var period_data = await period.filter(x=> x.tour_id == data_tour[d].id  && x.count > 0 && x.status_period != 3);
                        var period_soldout = await period.filter(x=> x.tour_id == data_tour[d].id && x.count == 0 && x.status_period == 3);
                    }
                    // let period_data = await period.filter(x=> x.tour_id == order_tour[d].id && x.count > 0 && x.status_period != 3);
                    let group_period = new Array();
                    for(let p in period_data){
                        if(!group_period[period_data[p].group_date]){
                            group_period[period_data[p].group_date] = new Array;
                        }
                        group_period[period_data[p].group_date].push(period_data[p])
                    }
                    let country_data = JSON.parse(order_tour[d].country_id);
                    var country_fil = new Array();
                    for(let t in country_data){
                         country_fil =  await country.filter(x => x.id == country_data[t]);
                    }
                    let info = {
                        tour:order_tour[d],
                        airline: await airline.find(x=> x.id == order_tour[d].airline_id),
                        period: group_period,
                        tour_type: await tour_type.find(x=>x.id == order_tour[d].type_id),
                        sold_out: period_soldout,
                        country:country_fil,
                    }
                    main_tour[count_tour].push(info);
                    if(main_tour[count_tour].length >= 15){
                        count_tour++;
                    }
                    count_num++;
                
            }
            document.getElementById('show_total').innerHTML = 'พบ '+count_num+' รายการ';
            total_page = count_tour;
            await show_tour(0);
            // readMore();
            await SelectFilter();
       
    }
   async function DeletedKeyword(){
        document.getElementById('show_keyword').innerHTML = '';
        document.getElementById('show_keyword_mb').innerHTML = '';
        document.getElementById('show_keyword_all').innerHTML = '';
        type_data.travel_search = new Array();
        travel_search = 0;
        keyword_search = 0;
        count_pagin = 1;
        await filter_tour();
    }
   async function DeletedCode(){
        document.getElementById('show_code').innerHTML = '';
        //mobile
        document.getElementById('show_code_mb').innerHTML = '';
        document.getElementById('show_code_all').innerHTML = '';
        type_data.tour_code = new Array();
        tour_code = 0;
        code_id = 0;
        count_pagin = 1;
        await filter_tour();
    }
    async function DeletedCity(){
        type_data.city = new Array();
        city_search = 0;
        count_pagin = 1;
        await filter_tour();
    }
    async function DeletedTag(){
        document.getElementById('show_tag').innerHTML = '';
        document.getElementById('show_tag_mb').innerHTML = '';
        document.getElementById('show_tag_all').innerHTML = '';
        type_data.tag_search = new Array();
        tag_search = 0;
        tag_name = 0;
        count_pagin = 1;
        // console.log(type_data.tag_search,'DeletedTag')
        await filter_tour();
        //window.location.replace(('search-tour'));
    }
    // Datepicker
    
   $(function() {
       $('input[name="daterange"]').daterangepicker({
           opens: 'left',
           minDate: min_date,
       }, function(start, end, label) {
           document.getElementById('s_date').value = start.format('YYYY-MM-DD');
           document.getElementById('e_date').value = end.format('YYYY-MM-DD');
           document.getElementById('s_date_mb').value = start.format('YYYY-MM-DD');
           document.getElementById('e_date_mb').value = end.format('YYYY-MM-DD');
           
            var start_value = start.format('YYYY-MM-DD');
            var end_value = end.format('YYYY-MM-DD');
            if(start && end){
                type_data.start_date = new Array();
                type_data.end_date = new Array();
                type_data.start_date.push(start_value)
                type_data.end_date.push(end_value)
                count_pagin = 1;
                filter_tour();
                check_date();
           }
           let y = new Date(start);
           let x = new Date(end);
           let s_show = y.getDate()+'  '+months[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+months[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           var s_select = y.getDate()+'/'+month_number[y.getMonth()]+'/'+(y.getFullYear()*1+543);
           let e_select = x.getDate()+'/'+month_number[x.getMonth()]+'/'+(x.getFullYear()*1+543);
           let s_day = days[y.getDay()];
           let e_day = days[x.getDay()];

           var text_start = '';
               text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_show+"</span>";
               text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_day+"</span>";
           var text_end = '';
               text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_show+"</span>";
               text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_day+"</span>";

            if(isWin || isMac){
                document.getElementById('show_select_date').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
                document.getElementById('show_date_calen').innerHTML = text_start;
                document.getElementById('show_end_calen').innerHTML = text_end;
            }else if(isAndroid || isIPhone || isIPad){
                //mobile
                document.getElementById('show_select_date_mb').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                document.getElementById('show_select_date_all').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                document.getElementById('show_date_calen_mb').innerHTML = text_start;
                document.getElementById('show_end_calen_mb').innerHTML = text_end;
            }
           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();
           //mobile
           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();
       });
       $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
           document.getElementById('s_date').value = null;
           document.getElementById('e_date').value = null;
           document.getElementById('show_select_date').innerHTML = '';
           //mobile
           document.getElementById('s_date_mb').value = null;
           document.getElementById('e_date_mb').value = null;
           document.getElementById('show_select_date_mb').innerHTML = '';
           document.getElementById('show_select_date_all').innerHTML = '';
          
           let y = new Date();
           let x = new Date(y.valueOf()+86400000);
           
           let s_show = y.getDate()+'  '+months[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+months[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           let s_day = days[y.getDay()];
           let e_day = days[x.getDay()];
           var dateS_now = (month_number[y.getMonth()])+'/'+y.getDate()+'/'+y.getFullYear()*1;
           var dateE_now = (month_number[x.getMonth()])+'/'+x.getDate()+'/'+x.getFullYear()*1;
           
           var text_start1 = '';
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_show+"</span>";
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
           var text_end2 = '';
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_show+"</span>";
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span>";

               if(isWin || isMac){
                    document.getElementById('show_date_calen').innerHTML = text_start1;
                    document.getElementById('show_end_calen').innerHTML = text_end2;
                    document.getElementById('hide_date_select').value = dateS_now+" - "+dateE_now;
               }else if(isAndroid || isIPhone || isIPad){
                    document.getElementById('show_date_calen_mb').innerHTML = text_start1;
                    document.getElementById('show_end_calen_mb').innerHTML = text_end2;
                    document.getElementById('hide_date_select_mb').value = dateS_now+" - "+dateE_now;
               }

           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();
            //mobile
           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();

           //ลบค่า tour
           var index_start = type_data['start_date'].indexOf(0);
           type_data['start_date'].splice(index_start,1);
           var index_end = type_data['end_date'].indexOf(0);
           type_data['end_date'].splice(index_end,1);
           count_pagin = 1;
           filter_tour();

       });
       $('input[name="daterange"]').on('hide.daterangepicker', function(ev, picker) {
           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();
            //mobile
           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();

       });
   });
   async function show_datepicker() {
       $('#show_date_calen').hide();
       $('#show_end_calen').hide();
       $('#hide_date_select').show();
       document.getElementById("hide_date_select").click();
   }
   async function show_datepicker_mb() {
        $('#show_date_calen_mb').hide();
        $('#show_end_calen_mb').hide();
        $('#hide_date_select_mb').show();
        document.getElementById("hide_date_select_mb").click();
    }
  async function DeletedDate(){
            document.getElementById('show_select_date').innerHTML = '';
            //mobile
            document.getElementById('show_select_date_mb').innerHTML = '';
            document.getElementById('show_select_date_all').innerHTML = '';
            document.getElementById('s_date').value = null;
            document.getElementById('e_date').value = null;
            document.getElementById('s_date_mb').value = null;
            document.getElementById('e_date_mb').value = null;
           let y = new Date();
           let x = new Date(y.valueOf()+86400000);
           var dateS_now = (month_number[y.getMonth()])+'/'+y.getDate()+'/'+y.getFullYear()*1;
           var dateE_now = (month_number[x.getMonth()])+'/'+x.getDate()+'/'+x.getFullYear()*1;
           let s_show = y.getDate()+'  '+months[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+months[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           let s_day = days[y.getDay()];
           let e_day = days[x.getDay()];
           
           var text_start1 = '';
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_show+"</span>";
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
           var text_end2 = '';
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_show+"</span>";
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span>";
           

            if(isWin || isMac){
                document.getElementById('hide_date_select').value = dateS_now+' - '+dateE_now;
                document.getElementById('show_date_calen').innerHTML = text_start1;
                document.getElementById('show_end_calen').innerHTML = text_end2;
            }else if(isAndroid || isIPhone || isIPad){
                document.getElementById('hide_date_select_mb').value = dateS_now+' - '+dateE_now;
                document.getElementById('show_date_calen_mb').innerHTML = text_start1;
                document.getElementById('show_end_calen_mb').innerHTML = text_end2;
            }

            // ลบค่าtour
            var index_start = type_data['start_date'].indexOf(0);
            type_data['start_date'].splice(index_start,1);
            var index_end = type_data['end_date'].indexOf(0);
            type_data['end_date'].splice(index_end,1);

            //ลบค่าวันที่ค้นหา
            start_search = 0;
            end_search = 0;
            count_pagin = 1;

            await filter_tour();
            await check_date();
   }
    async function check_date(){
        // console.log(type_data['start_date'],'check_date')
        if(type_data['start_date'].length){
            $('#hide_month').hide();
            $('#hide_month_mb').hide();
            $('#hide_holiday').hide();
            $('#hide_holiday_mb').hide();
        }else if(!type_data['start_date'].length && !type_data['month'].length && !type_data['holiday'].length){
            $('#hide_month').show();
            $('#hide_month_mb').show();
            $('#hide_holiday').show();
            $('#hide_holiday_mb').show();
        }
    }
    async function check_month(value){
        if(value.length){
            $('#hide_date').hide();
            $('#hide_date_mb').hide();
            $('#hide_holiday').hide();
            $('#hide_holiday_mb').hide();
            // console.log(value,'check_month')
        }else{
            $('#hide_date').show();
            $('#hide_date_mb').show();
            $('#hide_holiday').show();
            $('#hide_holiday_mb').show();
        }
    }
    async function check_holiday(value){
        // console.log(value,'check_holiday')
        if(value.length){
            $('#hide_date').hide();
            $('#hide_date_mb').hide();
            $('#hide_month').hide();
            $('#hide_month_mb').hide();
        }else{
            $('#hide_date').show();
            $('#hide_date_mb').show();
            $('#hide_month').show();
            $('#hide_month_mb').show();
        }
    }

async function clear_filter(){
    type_data = {
        country: new Array(),
        price: new Array(),
        airline: new Array(),
        rating: new Array(),
        day:new Array(),
        month:new Array(),
        holiday:new Array(),
        city:new Array(),
        amupur:new Array(),
        start_date:new Array(),
        end_date:new Array(),
        travel_search:new Array(),
        tour_code:new Array(),
        tag_search:new Array(),
    }
    travel_search = 0;
    keyword_search = 0;
    tour_code = 0;
    code_id = 0;
    start_search = 0;
    end_search = 0;
    price_search = 0;
    country_search = 0;
    city_search = 0;
    count_pagin = 1;
    tag_search = 0;
    tag_name = 0;
    //keyword
    document.getElementById('show_keyword').innerHTML = '';
    document.getElementById('show_keyword_mb').innerHTML = '';
    document.getElementById('show_keyword_all').innerHTML = '';
    //code
    document.getElementById('show_code').innerHTML = '';
    document.getElementById('show_code_mb').innerHTML = '';
    document.getElementById('show_code_all').innerHTML = '';
    //select date
    document.getElementById('show_select_date').innerHTML = '';
    document.getElementById('show_select_date_mb').innerHTML = '';
    document.getElementById('show_select_date_all').innerHTML = '';
    document.getElementById('s_date').value = null;
    document.getElementById('e_date').value = null;
    document.getElementById('s_date_mb').value = null;
    document.getElementById('e_date_mb').value = null;
    let y = new Date();
    let x = new Date(y.valueOf()+86400000);
    var dateS_now = (month_number[y.getMonth()])+'/'+y.getDate()+'/'+y.getFullYear()*1;
    var dateE_now = (month_number[x.getMonth()])+'/'+x.getDate()+'/'+x.getFullYear()*1;
    if(isWin || isMac){
        document.getElementById('hide_date_select').value = dateS_now+' - '+dateE_now;
    }else if(isAndroid || isIPhone || isIPad){
        document.getElementById('hide_date_select_mb').value = dateS_now+' - '+dateE_now;
    }

    await check_date();
    await check_month(type_data.month);
    await check_holiday(type_data.holiday);
    if(!oversea_id){
        await show_country();
        $('#city-topic').hide();
        $('#amupur-topic').hide();
    }
    if(oversea_id){
        await show_city(false);
        $('#country-topic').hide();
    }
    await show_price();
    await show_airline();
    await show_rating();
    await show_day();
    await show_month();
    await show_holiday();
    await date_picker();
    await filter_tour();
}
check_date();   
async function readMore(){
    var $readMore = "ดูช่วงเวลาเพิ่มเติม ";
    var $readLess = "ย่อข้อความ";
    $(".readMoreBtn").text($readMore);
    $('.readMoreBtn').click(function () {
        var $this = $(this);
        $this.text($readMore);
        if ($this.data('expanded') == "yes") {
            $this.data('expanded', "no");
            $this.text($readMore);
            $this.parent().find('.readMoreText').animate({
                maxHeight: '120px'
            });
        } else {
            $this.data('expanded', "yes");
            $this.parent().find('.readMoreText').css({
                maxHeight: 'none'
            });
            $this.text($readLess);

        }
    });

    var $readMore2 = "<i class=\"fi fi-rr-angle-small-down\"></i>";
    var $readLess2 = "<i class=\"fi fi-rr-angle-small-up\"></i>";
    $(".readMoreBtn2").html($readMore2);
    $('.readMoreBtn2').click(function () {
        var $this = $(this);
        $this.html($readMore2);
        if ($this.data('expanded') == "yes") {
            $this.data('expanded', "no");
            $this.html($readMore2);
            $this.parent().find('.readMoreText2').animate({
                height: '50px'
            });
        } else {
            $this.data('expanded', "yes");
            $this.parent().find('.readMoreText2').css({
                height: 'auto'
            });
            $this.html($readLess2);

        }
    });
}
   

