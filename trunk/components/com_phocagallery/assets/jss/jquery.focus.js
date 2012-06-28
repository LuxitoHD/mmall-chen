(function($){
        $.fn.setFocus = function(opt){
                //�滻ȱʡֵ
                opt = $.extend({
                        focusWrap:"#focus_wrap", //������
                        focusBox:"#focus_pics", //ͼƬ����
                        focusPics:"#focus_pics  li", //ͼƬѡ����
                        handlePrev:"#prev", //��һ����ť
                        handleNext:"#next", //��һ����ť
                        curClass:"on", //��ʶ��ǰ��ʽ
                        eventType:"mouseover", //����¼�����
                        eventSpeed:"normal", //�����ٶȣ���0���޶���
                        eventTime:2000, //�ֲ����ʱ�䣬��0���Զ��ֲ�
                        scrollDirection:0, //������������,0Ϊ���ҹ���,1Ϊ���¹���
                        curNum:0 //��ʶĬ��ͣ�ڵڼ���
                },opt);
                //����
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

                        //��ʼ��
                        if(scrollDirection){
                                //���¹���
                                $(focusBox).css("top","-"+curNum*height+"px");
                        }else{
                                //���ҹ���
                                $(focusBox).width(size*width);
                                $(focusBox).css("left","-"+curNum*width+"px");
                        }
                        $($this.get(curNum)).addClass(curClass);
                        //ִ�г���
                        mainFun();
                        //�Ƿ��Զ��ֲ�
                        if(eventTime){interval();}

                //������
                function mainFun(){
                        //handle���¼�
                        $this.each(function(i){
                                $(this).bind(eventType,function(){
                                        scrollAnimate(i);
                                        opt.curNum = i;
                                        return false;
                                });
                        });
                        //��һ�����¼�
                        $(handlePrev).bind("click",function(){
                                curNumAdd(false,size);
                                scrollAnimate(opt.curNum);
                                return false;
                        });
                        //��һ�����¼�
                        $(handleNext).bind("click",function(){
                                curNumAdd(true,size);
                                scrollAnimate(opt.curNum);
                                return false;
                        });
                };
                //��ʱִ��
                function interval(){
                        //��ʱ����
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
                        //������ʱ
                        inter.setinterval();
                        //�����ͣ�����ʱ
                        $(focusWrap).hover(function(){
                                inter.clearinterval();
                        },function(){
                                inter.setinterval()
                        });
                };
                //����������
                function curNumAdd(isAdd){
                        var curNum = opt.curNum;
                        if(isAdd){
                                //����
                                opt.curNum = (++curNum > size-1)? 0 : curNum;
                        }else{
                                //�ݼ�
                                opt.curNum = (--curNum < 0)? size-1 : curNum;
                        }
                };
                //������������
                function scrollAnimate(i){
                        //��������
                        if(scrollDirection){
                                //���¹���
                                $(focusBox).stop().animate({
                                        top:"-"+height*i+"px"
                                },eventSpeed);
                        }else{
                                //���ҹ���
                                $(focusBox).stop().animate({
                                        left:"-"+width*i+"px"
                                },eventSpeed);
                        }
                        //��ǰon״̬��ʾ
                        $this.removeClass(curClass);
                        $this.eq(i).addClass(curClass);
                };
        };
})(jQuery);  