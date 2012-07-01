void function($){
        $.fn.photos = function(opt){
                //替换缺省值
                opt = $.extend({
                        phosWrap:"#pics_wrap", //总容器
                        phosView:"#preview img", //大图片容器
                        itemsBox:"#picsList ul", //小图片容器
                        items:"#picsList  li", //小图片选择器
                        prev:"#prev", //上一条按钮
                        next:"#next", //下一条按钮
                        prev2:"#prev2", //上一条按钮2
                        next2:"#next2", //下一条按钮2
                        scrollL:"#scrollL", //小图片左滚动按钮
                        scrollR:"#scrollR", //小图片右滚动按钮
                        curClass:"cur", //标识当前样式
                        autoPlay:false, //是否自动播放,默认不播放
                        playBtn:"#autoPlay", //
                        stopPlay:"#stopPlay", //
                        eventType:"click", //鼠标事件设置
                        eventSpeed:"normal", //动画速度，设0则无动画
                        eventTime:3000, //轮播间隔时间，设0则不自动轮播
                        scrollDirection:0, //动画滚动方向,0为左右滚动
                        curNum:0,//标识默认停在第几个
                        scrollNub:0, //每次滚动数量
                        defaultNum:3 //每次滚动数量
                },opt);
                //变量
                var height = $(opt.items).outerHeight(true),
                        width = $(opt.items).outerWidth(true),
                        size = $(opt.items).size(),
                        phosWrap = opt.phosWrap,
                        phosView = opt.phosView,
                        itemsBox = opt.itemsBox,
                        items = opt.items,
                        prev = opt.prev,
                        next = opt.next,
                        prev2 = opt.prev2,
                        next2 = opt.next2,
                        scrollL = opt.scrollL,
                        scrollR = opt.scrollR,
                        curClass = opt.curClass,
                        autoPlay = opt.autoPlay,
                        playBtn = opt.playBtn,
                        stopPlay = opt.stopPlay,
                        eventType = opt.eventType,
                        eventSpeed = opt.eventSpeed,
                        eventTime = opt.eventTime,
                        scrollDirection = opt.scrollDirection,
                        curNum = opt.curNum,
                        scrollNub = opt.scrollNub,
                        defaultNum = opt.defaultNum,
                        $this = $(this);

                        //初始化
                         //左右滚动
                        $(itemsBox).width(size*width);
                        $(itemsBox).css("left","-"+curNum*width+"px");
						$(phosView).attr('src',$this.eq(curNum).find('img').attr('data_source'));
                        $($this.get(curNum)).addClass(curClass);
                        //执行程序
                        mainFun();
                        //是否自动轮播
                        if(autoPlay){interval();}
                //主程序
                function mainFun(){
					
                        //handle绑定事件
                        $this.each(function(i){
                                $(this).bind(eventType,function(){
									scrollAnimate(i);
									opt.curNum = i;
									location.hash = "#pic_" + i;
                                });
                        });
                        //上一条绑定事件
                        $(prev).add(prev2).bind("click",function(e){
								e.preventDefault();
                                curNumAdd(false,size);
                                scrollAnimate(opt.curNum);
                                return false;
                        });
                        //下一条绑定事件
                        $(next).add(next2).bind("click",function(e){
								e.preventDefault();
                                curNumAdd(true,size);
                                scrollAnimate(opt.curNum);
                                return false;
                        });
						$(document).keyup(function(e){
							if(e.keyCode==37){
								$(prev).click();
							}
							else if(e.keyCode==39){
								$(next).click();
							}
						});
                        $(scrollL).bind("click",function(e){
								e.preventDefault();
								var firstIdx = -parseInt($(itemsBox).css("left").replace("px","")) / width;
								var curNum = opt.curNum;
								if(firstIdx>=7){
								$(itemsBox).stop()
										   .animate({left:'+=' + (scrollNub * width) + 'px'},eventSpeed);
								}
								else{
								$(itemsBox).stop()
										   .animate({left:0},eventSpeed);
								}
                        });
                        $(scrollR).bind("click",function(e){
								e.preventDefault();
								var firstIdx = -parseInt($(itemsBox).css("left").replace("px","")) / width;
								var curNum = opt.curNum;
								if(firstIdx+scrollNub<size){
									$(itemsBox).stop()
											   .animate({left:'-=' + (scrollNub * width) + 'px'},eventSpeed);
								}
                        });
                };
                //定时执行
                function interval(){
                        //定时函数
                        var inter = {
                                itv:null,
                                setinterval:function(){
                                        this.itv = setInterval(function(){
                                                curNumAdd(true,size);
                                                scrollAnimate(opt.curNum);
												location.hash = "#pic_" + opt.curNum;
                                        },eventTime);
                                },
                                clearinterval:function(){
                                        clearInterval(this.itv);
                                }
                        };
                        //启动定时
                        inter.clearinterval();
                        //鼠标悬停清除定时
                        $(phosWrap + "," + phosView).hover(function(){
                        	$(stopPlay).click();
                        },function(){
                            $(playBtn).click()
                        });
						//
						$(playBtn).click(function(e){
							e.preventDefault();
							inter.setinterval();
							$(this).hide();
							$(stopPlay).css('display','inline-block');
						});
						$(stopPlay).click(function(e){
							e.preventDefault();
							inter.clearinterval();
							$(this).hide();
							$(playBtn).css('display','inline-block');
						});
                };
                //计数器叠加
                function curNumAdd(isAdd){
                        var curNum = opt.curNum;
                        if(isAdd){
                                //递增
                                opt.curNum = (++curNum > size-1)? 0 : curNum;
                        }else{
                                //递减
                                opt.curNum = (--curNum < 0)? size-1 : curNum;
                        }
                };
                //滚动动画程序
                function scrollAnimate(i){
                        //滚动动画
								if(i>=size-scrollNub+defaultNum){
									
									$(itemsBox).stop().animate({left:"-"+width*(size-scrollNub)+"px"},eventSpeed);
								}
								else if(i>defaultNum){
									
									$(itemsBox).stop().animate({left:"-"+width*(i-defaultNum)+"px"},eventSpeed);
								}
								else{
									
									$(itemsBox).stop().animate({left:0},eventSpeed);
								}
                        //当前on状态标示
                        $this.removeClass(curClass);
                        $this.eq(i).addClass(curClass);
						$(phosView).attr('src',$this.eq(i).find('img').attr('data_source'));
                };
        };
		

}(jQuery);  