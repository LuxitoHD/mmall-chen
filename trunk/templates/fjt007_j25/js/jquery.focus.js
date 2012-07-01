(function($){
        $.fn.setFocus = function(opt){
                //替换缺省值
                opt = $.extend({
                        focusWrap:"#focus_wrap", //总容器
                        focusBox:"#focus_pics", //图片容器
                        focusPics:"#focus_pics  li", //图片选择器
                        handlePrev:"#prev", //上一条按钮
                        handleNext:"#next", //下一条按钮
                        curClass:"on", //标识当前样式
                        eventType:"mouseover", //鼠标事件设置
                        eventSpeed:"normal", //动画速度，设0则无动画
                        eventTime:2000, //轮播间隔时间，设0则不自动轮播
                        scrollDirection:0, //动画滚动方向,0为左右滚动,1为上下滚动
                        curNum:0 //标识默认停在第几个
                },opt);
                //变量
                var height = $(opt.focusPics).height(),
                        width = $(opt.focusPics).width(),
                        size = $(opt.focusPics).size(),
                        focusWrap = opt.focusWrap,
                        focusBox = opt.focusBox,
                        focusPics = opt.focusPics,
                        handlePrev = opt.handlePrev,
                        handleNext = opt.handleNext,
                        curClass = opt.curClass,
                        eventType = opt.eventType,
                        eventSpeed = opt.eventSpeed,
                        eventTime = opt.eventTime,
                        scrollDirection = opt.scrollDirection,
                        curNum = opt.curNum,
                        $this = $(this);

                        //初始化
                        if(scrollDirection){
                                //上下滚动
                                $(focusBox).css("top","-"+curNum*height+"px");
                        }else{
                                //左右滚动
                                $(focusBox).width(size*width);
                                $(focusBox).css("left","-"+curNum*width+"px");
                        }
                        $($this.get(curNum)).addClass(curClass);
                        //执行程序
                        mainFun();
                        //是否自动轮播
                        if(eventTime){interval();}

                //主程序
                function mainFun(){
                        //handle绑定事件
                        $this.each(function(i){
                                $(this).bind(eventType,function(){
                                        scrollAnimate(i);
                                        opt.curNum = i;
                                        return false;
                                });
                        });
                        //上一条绑定事件
                        $(handlePrev).bind("click",function(){
                                curNumAdd(false,size);
                                scrollAnimate(opt.curNum);
                                return false;
                        });
                        //下一条绑定事件
                        $(handleNext).bind("click",function(){
                                curNumAdd(true,size);
                                scrollAnimate(opt.curNum);
                                return false;
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
                                        },eventTime);
                                },
                                clearinterval:function(){
                                        clearInterval(this.itv);
                                }
                        };
                        //启动定时
                        inter.setinterval();
                        //鼠标悬停清除定时
                        $(focusWrap).hover(function(){
                                inter.clearinterval();
                        },function(){
                                inter.setinterval()
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
                        if(scrollDirection){
                                //上下滚动
                                $(focusBox).stop().animate({
                                        top:"-"+height*i+"px"
                                },eventSpeed);
                        }else{
                                //左右滚动
                                $(focusBox).stop().animate({
                                        left:"-"+width*i+"px"
                                },eventSpeed);
                        }
                        //当前on状态标示
                        $this.removeClass(curClass);
                        $this.eq(i).addClass(curClass);
                };
        };
})(jQuery);  