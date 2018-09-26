var jd_data = {};

jd_data.time = function(){
	this.initialize.apply(this, arguments);
};

jd_data.time.prototype = {
    /* 变量 */
    mousedown:false,
    start : [],
    end : [],
    timeout : null,
    options : {
        month : 3,
        data  : []
    },

    /* 初始化 */
	initialize:function(options){
		this.event();

        $(".data-right").pin({
            containerSelector: ".jd-date"
        });

        this.options = options;

        this.initia();

	},
    /* 所有点击事件都在这 */
    event:function(){
        _this = this;

        //年/月下拉框
        $('.date-header').on('change','.date-year,.date-month',function(){
            var year = $(".date-year").val();
            var month = $(".date-month").val();

            _this.monthNum([year,month,1])
        });

        //上一个年/月
        $('.date-tol').on('click','.prev',function(){

            var year = $(".date-year").val();
            var month = $(".date-month").val();
            var specific = $(this).parent('.date-tol').hasClass('year');
            var nextDate;
            if(specific){
                nextDate = jd_data.means.MonthAdd('m',-12,[year,month,2]);
            }else{
                nextDate = jd_data.means.MonthAdd('m',-1,[year,month,2]);
            }

            if(nextDate[0]>=2017){
                $(".date-year").val(nextDate[0]);
                $(".date-month").val(nextDate[1]);
                _this.monthNum(nextDate);
            }

        });

        //下一个年/月
        $('.date-tol').on('click','.next',function(){
            var year = $(".date-year").val();
            var month = $(".date-month").val();
            var specific = $(this).parent('.date-tol').hasClass('year');
            var nextDate;
            if(specific){
                nextDate = jd_data.means.MonthAdd('m',12,[year,month,2]);
            }else{
                nextDate = jd_data.means.MonthAdd('m',1,[year,month,2]);
            }

            if(nextDate[0]<=2021){
                $(".date-year").val(nextDate[0]);
                $(".date-month").val(nextDate[1]);
                _this.monthNum(nextDate);
            }
        });

        //返回今天
        $('.date-header').on('click','.date-today',function(){
            _this.initia();
        });

        //创建活动弹出框
        $('.jd-date').on('click','.add-create,.date-new',function(){
            $('#myCreate').modal('show');
            
            $('.recharge-bonus-form h3').html('添加充值活动');
			$('.recharge-bonus-form .submit').html('添加');
			$('.recharge-bonus-form input').val('');
			if (jd_data.means.Unix(_this.start.join("-"))) {
				$('#promotions-starttime').val(jd_data.means.Unix(_this.start.join("-"))+' 00:00:00');
			}
			if (jd_data.means.Unix(_this.end.join("-"))) {
				$('#promotions-endtime').val(jd_data.means.Unix(_this.end.join("-"))+' 23:59:59');
			}
			$('.recharge-bonus-form .error').empty();
			$("#partake_number option:first").prop("selected", 'selected');
			$('.activity-infos').empty();
			$('.activity-infos').append('<li><h6>充值</h6><input type="text" class="clear-value" name="activity_infos[0][recharge]" /><p>元，送</p><input type="text" class="clear-value" name="activity_infos[0][bonus]" /><p>元</p>');
			$('.a-add').remove();
			$('.create-activity').append('<div class="a-add">+</div>');
        });
        
        //设置活动详情
        $('.jd-date').on('click','.set-add-create',function(){
        	var id = $(this).data('id');
        	window.location.href=location.protocol+'//'+location.host+'/promotion/add?id='+id;
        });
        
        //查看活动详情
        $('.jd-date').on('click','.select-add-create',function(){
        	var id = $(this).data('id');
        	window.location.href=location.protocol+'//'+location.host+'/promotion/detail?id='+id;
        });

        //删除活动
        $('.jd-date').on('click','.date-delete',function(){
            _this.start = [];
            _this.end = [];
            _this.activity();

            $('#promotions-starttime').val('');
            $('#promotions-endtime').val('');
            $('.show_days').html('');

            $('.date-activity .yes').removeClass('active start end');
            $('.date-new,.date-delete').remove();
        });
        
        //点击修改活动时
        $('.bonus-recharge').on('click', '.modify', function(){
        	$('#myCreate').modal('show');
        	
        	_this.start = [];
            _this.end = [];
            _this.activity();

            $('#promotions-starttime').val('');
            $('#promotions-endtime').val('');

            $('.date-activity .yes').removeClass('active start end');
            $('.date-new,.date-delete').remove();
        });

        //查看活动详情
        $('.jd-date').on('click','.oldlook',function(){
            _this.lookActivity(this);
        });

        //监听用户鼠标在可选区域内按住鼠标时
        $('.date-activity').on('mousedown','.yes',function(){
            _this.start = $(this).data('time').split(',');
            _this.mousedown = true;
        });

        //监听用户鼠标经过可选区域
        $('.date-activity').on('mouseenter','.yes',function(){
            if(_this.mousedown){
                $('.date-activity .yes').removeClass('active start end');
                $('.date-new,.date-delete').remove();
                _this.end = $(this).data('time').split(',');
                _this.total();          
            }
        });


        //全屏监听用户鼠标放开
        $(document).mouseup(function(){
             _this.mousedown = false;  
        });   

    },

    /*  基础设置  - 还原  */
    initia:function(options){
        //基础参数
        var today = jd_data.means.today();
        this.activity();

        //默认
        $(".date-year").val(today[0]);
        $(".date-month").val(today[1]);

        //创建日历个数
        this.monthNum(today);
    },

    //创建日历个数
    monthNum:function(today){
        var html = '';
        var month = 3;
        if(this.options&&this.options.month){
            month = this.options.month;
        }

        for(var i=0,n=month;i<n;i++){
            var nextDate = jd_data.means.MonthAdd('m',i,today);
            html += this.calendar(nextDate);
        }
        
        $('.date-activity').html(html);
    },

    /* 日历生成  */
    calendar:function(data){

        var means = jd_data.means,
            days  = means.days(data),
            weeks = means.weeks(data),
            html = "<dd class='month'>"+data[0]+"年 "+data[1]+"月</dd>",
            options = this.options;

        for(var i=0,n=1;i<42;i++){
            if(weeks<=i&&n<=days){

                var Class = 'no';
                var lunar = calendar.solar2lunar(data[0],data[1],n);
                var IMonth = lunar.IMonthCn;
                var IDayCn = lunar.IDayCn;
                var Name = IDayCn;
                var festival = '';
                var oldno = '';
                var oldname = '';

                //阳历
                for(var o=0,m=means.solar.length;o<m;o++){
                    if(means.solar[o].date.toString()==[data[1],n].toString()){
                        Name = means.solar[o].text;
                        festival = ' a-festival';
                        break;
                    }
                }

                //农历
                for(var l=0,k=means.lunar.length;l<k;l++){
                    if(means.lunar[l].date==(IMonth+IDayCn)){
                        Name = means.lunar[l].text;
                        festival = ' a-festival';
                        break;
                    }
                }

                //母亲节 5月份的第2个星期日
                if(data[1]==5&&i==14){
                    Name = '母亲节';
                    festival = ' a-festival';
                }

                //父亲节 6月份的第3个星期日
                if(data[1]==6&&i==21){
                    Name = '父亲节';
                    festival = ' a-festival';
                }

                if(options.data.length>0){
                    for(var t=0,p=options.data.length;t<p;t++){
                        if(means.Overdue([data[0],data[1],n],options.data[t].min,options.data[t].max)){
                            oldno+=' old'
                        }
                        if([data[0],data[1],n].toString()==options.data[t].min.toString()){
                            oldno+=' oldStart';
                            if(!empty(options.data[t].type)) {
                            	oldname = '<div class="look oldlook">'+options.data[t].type+'</div>';
                            }else{
                            	oldname = '<div class="look oldlook">任选</div>';
                            }
                        }
                        if([data[0],data[1],n].toString()==options.data[t].max.toString()){
                            oldno+=' oldEnd';
                        }
                    }
                }

                
                if(means.compare([data[0],data[1],n])){
                    Class = oldno?'':'yes';
                    var ndate = [data[0],data[1],n].toString();
                    var today = means.today().toString();

                    if(ndate==today){
                        Class+=' today';
                        Name = '今天';
                    }

                    if(this.start&&this.end&&jd_data.means.Overdue([data[0],data[1],n],this.start,this.end)){
                        Class+=' active';
                        if([data[0],data[1],n].toString()==this.start.toString()){
                             Class+=' start';
                             oldname = '<div class="look oldlook">新</div>';
                        }
                        if([data[0],data[1],n].toString()==this.end.toString()){
                             Class+=' end';
                        }
                    }
                }

                Class += festival;
                Class += oldno;
                
                var dd = "<dd data-time="+[data[0],data[1],n].toString()+" class='"+Class+"'><div class='choice'><h6>"+n+"</h6><p>"+Name+"</p>"+oldname+"</div></dd>";
                html+=dd;
                n++;
            }else{
                html+='<dd></dd>';
            }
        }

        return html;
    },
    //总结
    total:function(){
        var _this = this;
        var means = jd_data.means;
        
        if(this.start&&this.end&&means.compare(this.end,this.start)){
            var old = true;
            $('.date-activity .yes,.date-activity .old').each(function(){
                var time = $(this).data('time').split(',');
                var bool = jd_data.means.Overdue(time,_this.start,_this.end);
                if(bool&&$(this).hasClass("old")){
                    old = false;
                }
            });
            
            if(old){
                 $('.date-activity .yes').each(function(){
                    var time = $(this).data('time').split(',');
                    var bool = jd_data.means.Overdue(time,_this.start,_this.end);

                    if(bool){
                        
                        $(this).addClass('active');
                        clearTimeout(_this.timeout);
                        _this.timeout = setTimeout(function(){

                            _this.activity();
                            $('#promotions-starttime').val(means.Unix(_this.start.join("-"))+' 00:00:00');
                            $('#promotions-endtime').val(means.Unix(_this.end.join('-'))+' 23:59:59');
                            $('.show_days').html('，(共'+means.dateDiff(_this.start,_this.end)+'天)');

                        },500);
                    }

                    if($(this).data('time').toString()==_this.start.toString()){
                        $(this).addClass('start');
                        $(this).find('.choice').append('<div class="look date-new">新</div>');
                    }
                    
                    if($(this).data('time').toString()===_this.end.toString()){
                        $(this).addClass('end');
                        $(this).find('.choice').append('<div class="delete date-delete">x</div>');
                    }
                });
            }else{
                clearTimeout(_this.timeout);
            }
        }
    },
    //新建活动
    activity:function(){
        var means = jd_data.means;
        var today = means.today();
        var options = this.options;
        var lunar = calendar.solar2lunar(today[0],today[1],today[2]);
        //显示节日
        var holidayText = '';
        if(options.data.length>0){
            for(var t=0,p=options.data.length;t<p;t++){
            	if(!empty(options.data[t].min)&&!empty(options.data[t].max)){
            		if(means.Overdue([today[0],today[1],today[2]],options.data[t].min,options.data[t].max)){
				        var holiday = means.Vacations(options.data[t].min, options.data[t].max);
				        if (holiday.length>0&&!empty(holiday)) {
				        	for(var i= 0,length=holiday.length; i<length; i++){
				        		var denghao = '、';
				        		if(i == 0) {
				        			holidayText += '含';
				        			denghao = '';
				        		}
				        		holidayText += denghao+'【'+holiday[i]+'】';
				        	}
				        }
				        if(holidayText){
				        	holidayText = '<div class="holiday">'+holidayText+'</div>';
				        }
            		}
            	}
            }
        }
        var html = '<div class="data-marin"><div class="Today"><h6><span>'+today.join('-')+'</span><span>星期'+["日", "一", "二", "三", "四", "五", "六"][new Date().getDay()]+'</span></h6><div class="a-calendar">'+lunar.gzYear+'【'+lunar.Animal+'年】'+lunar.IMonthCn+lunar.IDayCn+'</div>'+holidayText+'</div>';

        if(this.start.length>0&&this.end.length>0&&means.dateDiff(this.start,this.end)>0){
        	//显示节日
            var holidayMsg = '';
	        var holidays = means.Vacations(this.start, this.end);
	        if (holidays.length>0&&!empty(holidays)) {
	        	for(var i= 0,length=holidays.length; i<length; i++){
	        		var denghaos = '、';
	        		if(i == 0) {
	        			holidayMsg += '含';
	        			denghaos = '';
	        		}
	        		holidayMsg += denghaos+'【'+holidays[i]+'】';
	        	}
	        }
	        if(holidayMsg){
	        	holidayMsg = '<div class="holiday">'+holidayMsg+'</div>';
	        	html = '<div class="data-marin"><div class="Today"><h6><span>'+today.join('-')+'</span><span>星期'+["日", "一", "二", "三", "四", "五", "六"][new Date().getDay()]+'</span></h6><div class="a-calendar">'+lunar.gzYear+'【'+lunar.Animal+'年】'+lunar.IMonthCn+lunar.IDayCn+'</div>'+holidayMsg+'</div>';
	        }
            html += '<div class="data-text"><p>'+means.Unix(this.start.join('-'))+'</p><span>~</span><p>'+means.Unix(this.end.join('-'))+'</p><p class="diff">（'+means.dateDiff(this.start,this.end)+'天）</p></div>';
        }else{
            if(options.data.length>0){
            	var currentActivity = 0;
                for(var t=0,p=options.data.length;t<p;t++){
                    if(means.Overdue([today[0],today[1],today[2]],options.data[t].min,options.data[t].max)){
                    	if(!empty(options.data[t].type)){
                    		currentActivity = 1;
                    		html += '<div class="data-text"><p>'+means.Unix(options.data[t].min.join('-'))+'</p><span>~</span><p>'+means.Unix(options.data[t].max.join('-'))+'</p><p class="diff">（'+means.dateDiff(options.data[t].min,options.data[t].max)+'天）</p></div>';
                        	var p_type = '<div class="go-text activity">'+options.data[t].type+'</div>';
                        	html+=p_type;
                        	if(!empty(options.data[t].text)){
                            	var p_text = '<p class="p-text">'+options.data[t].text+'</p>';
                                html+=p_text;
                            }
                        	if(!empty(options.data[t].infos)){
                            	var p_infos = '<p class="p-text">'+options.data[t].infos+'</p>';
                                html+=p_infos;
                            }
                        }
                    }
                }
                if (currentActivity == 0) {
                	html += '<div class="activity">无营销活动</div>';
                }
            }else{
                html += '<div class="activity">无营销活动</div>';
            }
           
        }

        html +='</div><button type="text" class="add-create">创建活动</button>';
        
        $('.data-right').html(html);
    },
    //查看活动
    lookActivity:function(dom){
        var date = $(dom).parents('dd').data('time').split(',');
        var means = jd_data.means;
        var options = this.options;

        if(options.data.length>0){
            for(var t=0,p=options.data.length;t<p;t++){
                if(means.Overdue([date[0],date[1],date[2]],options.data[t].min,options.data[t].max)){
                    var today = means.today();
                    var lunar = calendar.solar2lunar(today[0],today[1],today[2]);
                    //显示节日
                    var holiday = means.Vacations(options.data[t].min, options.data[t].max);
                    var holidayText = '';
                    if (holiday.length>0) {
                    	for(var i= 0,length=holiday.length; i<length; i++){
                    		var denghao = '、';
                    		if(i == 0) {
                    			holidayText += '含';
                    			denghao = '';
                    		}
                    		holidayText += denghao+'【'+holiday[i]+'】';
                    	}
                    }
                    if(holidayText){
                    	holidayText = '<div class="holiday">'+holidayText+'</div>';
                    }
                    var html = '<div class="data-marin"><div class="Today"><h6><span>'+today.join('-')+'</span><span>星期'+["日", "一", "二", "三", "四", "五", "六"][new Date().getDay()]+'</span></h6><div class="a-calendar">'+lunar.gzYear+'【'+lunar.Animal+'年】'+lunar.IMonthCn+lunar.IDayCn+'</div>'+holidayText+'</div><div class="data-text"><p>'+means.Unix(options.data[t].min.join('-'))+'</p><span>~</span><p>'+means.Unix(options.data[t].max.join('-'))+'</p><p class="diff">（'+means.dateDiff(options.data[t].min,options.data[t].max)+'天）</p></div>';
                    if(!empty(options.data[t].type)){
                    	var p_type = '<div class="go-text activity">'+options.data[t].type+'</div>';
                    	html+=p_type;
                    	if(!empty(options.data[t].text)){
                        	var p_text = '<p class="p-text">'+options.data[t].text+'</p>';
                            html+=p_text;
                        }
                    	if(!empty(options.data[t].infos)){
                        	var p_infos = '<p class="p-text">'+options.data[t].infos+'</p>';
                            html+=p_infos;
                        }
                    	html+='</div><button type="text" class="select-add-create" data-id="'+options.data[t].id+'">查看活动详情</button>';
                    }else{
                    	html+='<div class="go-text activity">未设置活动详情</div>';
                    	html+='</div><button type="text" class="set-add-create" data-id="'+options.data[t].id+'">设置活动详情</button>';
                    }
                    
                    $('.data-right').html(html);
                }
            }
        }
    }
};

jd_data.means = {
    //计算某个月的总天数
	days:function(date){
		var day=new Date(date[0],date[1],0);
		return day.getDate();
	},

    //计算某个月的第一天是星期几
	weeks:function(date){
		var Year = date[0],
		    Month = date[1];
		Month--;
		var week=new Date(Year,Month,1);
		return week.getDay();
	},

    //今天
	today:function(){
		var today = new Date();
		var day = [today.getFullYear(),today.getMonth()+1,today.getDate()];
		return day;
	},

    //两个日期比较   如果date2未写，默认今天 data1>data2则返回ture.
	compare:function(data1,data2){
		var d1 = new Date(data1[0]||0,(data1[1]-1)||0,data1[2]||1).getTime();
		if(!data2){
			data2 = jd_data.means.today();
		};
		var d2 = new Date(data2[0]||0,(data2[1]-1)||0,data2[2]||1).getTime();
		return ((d1-d2)/1000)<0?false:true;
	},

    //相差天数
    dateDiff:function(date1,date2){
        date1 = new Date(date1[0]||0,(date1[1]-1)||0,date1[2]||1);
        date2 = new Date(date2[0]||0,(date2[1]-1)||0,date2[2]||1);
        var days = date2.getTime() - date1.getTime();
        var time = parseInt(days / (1000 * 60 * 60 * 24));
        return(time+1);
    },

    //判断日期是否在这个范围内
    Overdue:function(date,Mindate,Maxdate){
        //转成秒
        date = Date.UTC(date[0],date[1]-1,date[2]);
        Mindate = Date.UTC(Mindate[0],Mindate[1]-1,Mindate[2]);
        Maxdate = Date.UTC(Maxdate[0],Maxdate[1]-1,Maxdate[2]);

        //判断是否在这一区间
        if (date >= Mindate && date <= Maxdate) {
            return true;
        } else {
            return false;
        }
    },

    //月份加减
	MonthAdd:function(interval,add,data){
	   switch(interval){
	   		case "d" : {
	   			var str = data[0]+'-'+data[1]+'-'+data[2];
	   			var date=new Date(str.replace(/-/g,"/"));
				date.setDate(date.getDate()+add);
                return [date.getFullYear(),date.getMonth()+1,date.getDate()];
	   		}
	   		case "m" : {
	   			var srl = data[0]+'-'+data[1]+'-'+data[2];
	   			var sDate = new Date(srl.replace(/-/g,"/"));
                var sYear = sDate.getFullYear();
			    var sMonth = sDate.getMonth() + 1;
			    var sDay = sDate.getDate();
			    
			    var eYear = sYear;
		        var eMonth = sMonth + add;
		        var eDay = sDay;
		        
		        if(eMonth>12){
			      eYear++;
			      eMonth = eMonth-12;
			    };

			    var eDate = new Date(eYear, eMonth - 1, eDay);

			    if(eDate.getMonth() != eMonth - 1){
		          eDay--;
		          eDate = new Date(eYear, eMonth - 1, eDay);
		        };
		        return [eDate.getFullYear(),eDate.getMonth()+1,eDate.getDate()];
            }
	   }
	},
    //补0
    Unix:function(data){
   		var srl=data.replace(/\d+/g,function(a){return (a.length==4)?a:((a.length==2)?a:("0"+a))});
   		return srl;
    },

    //判断一个日期区间是否有节日
    Vacations:function(min,max){
        var vacat = []; //节假日
        var time = min;  //当前节假日
        var means = jd_data.means;

        while(this.Overdue(time,min,max)){
            
            //阳历
            for(var o=0,m=means.solar.length;o<m;o++){
                if(means.solar[o].date.toString()==[time[1],time[2]].toString()){
                    vacat.push(means.solar[o].text);
                    break;
                }
            }

            //农历
            var lunar = calendar.solar2lunar(time[0],time[1],time[2]);
            var IMonth = lunar.IMonthCn;
            var IDayCn = lunar.IDayCn;
            for(var l=0,k=means.lunar.length;l<k;l++){
                if(means.lunar[l].date==(IMonth+IDayCn)){
                    vacat.push(means.lunar[l].text);
                    break;
                }
            }

            //母亲节（5月份的第2个星期日）、父亲节（6月份的第3个星期日）
            if(time[1]==5&&(time[2]+this.weeks(time))==14){
                vacat.push('母亲节');
            }

            if(time[1]==6&&(time[2]+this.weeks(time))==21){
                vacat.push('父亲节');
            }

            time = this.MonthAdd('d',1,time);
        }

        return vacat;
    },

    //阳历节假日
    solar:[{
        text:'元旦',
        date:[1,1]
    },{
        text:'情人节',
        date:[2,14]
    },{
        text:'妇女节',
        date:[3,8]
    },{
        text:'愚人节',
        date:[4,1]
    },{
        text:'青年节',
        date:[5,4]
    },{
       text:'劳动节',
        date:[5,1] 
    },{
       text:'建军节',
        date:[8,1] 
    },{
        text:'国庆节',
        date:[10,1] 
    },{
        text:'平安夜',
        date:[12,24] 
    },{
        text:'圣诞节',
        date:[12,25]
    }],
    //农历节假日
    lunar:[{
        text:'除夕',
        date:'腊月三十'
    },{
        text:'春节',
        date:'正月初一'
    },{
        text:'元宵节',
        date:'正月十五'
    },{
        text:'端午节',
        date:'五月初五'
    },{
        text:'七夕节',
        date:'七月初七'
    },{
        text:'中元节',
        date:'七月十五'
    },{
        text:'中秋节',
        date:'八月十五'
    },{
        text:'重阳节',
        date:'九月初九'
    }]
}