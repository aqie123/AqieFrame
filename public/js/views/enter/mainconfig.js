require.config({
	paths:{
		jquery:'../../libs/jquery-3.1.1.min',
		swiper:'../../plugs/swiper.min',
		commonObj:'../../commonobj',
		diqu:'../../plugs/diqu2'
	}
})

require(['jquery','swiper','commonObj','diqu'],function($,swiper,commonObj){
	var topSlider = new Swiper('#topSlider',{
		pagination : '.swiper-pagination',
		paginationClickable :true,
		sliderPerView:1,    //一下滑几个
		centeredSliders:true,  //在中间
		autoplay:3000,			//每隔三秒
		loop:true,			//循环滑动
		autoplayDisableOnInteraction:true,	//手动滑动禁止自动滑动
		mousewheelControl:true,				//滚轮滑动
		prevButton:'.swiper-button-prev',	//左右切换按钮
		nextButton:'.swiper-button-next',

	});
	commonObj.loadCanvas();
	commonObj.set_address();
	$(window).scroll(commonObj.scrollHandler); //滚轮滑动加载
	$('.product').on('touchmove',commonObj.scrollHandler);  //触摸滑动加载
	// alert($)
	$('.add').on('click',commonObj.addnums);	//购买商品加减
	$('.reduce').on('click',commonObj.reducenums);
	$('.addcart').on('click',commonObj.addcatAnimate);
	if($('.cartnums').val()<1){
		$('.cartnums').hide();
	}else{
		$('.cartnums').show();
	};
	//删除购物车商品
	$('.delbtn').on('click',function(){
		$(this).parents('li').remove();
		if($('.cartlist').children('li').length<1){
			$('.cartlist').hide();
			$('.onthebottom').hide();
			$('.null_shopping').show();
		}
	});
	$('.clearcart').on('click',function(){
		$('.cartlist').find('li').each(function(){
			$(this).remove()
		})
		$('.cartlist').hide();
		$('.onthebottom').hide();
		$('.null_shopping').show();
	});
	//订单提交页面
	
	$('.address_item').on('click',function(){		//点击关联
		// alert('点击')
		// $(this).children().eq(0).children().eq(0).attr('checked',true);
		// $(this).siblings().children().eq(0).children().eq(0).attr('checked',false);
		$(this).find('input').prop('checked',true);
		// $(this).siblings().find('input').porp('checked',false);	
		commonObj.set_address();
	});
	

	$('input[name=address_options]').change(function(){  //显示地址隐藏部分
		if($(this).val()==0){
			$('#address_form').show();
		}else{
			$('#address_form').hide();
		}
	});
	$('input.ifvoicenot').change(function(){  //on click change  显示订单
		$(this).parent().next().toggle();	//
	});

	//省市区三级联动
	if($("select[name='sheng']").length>0){
            new PCAS("sheng","shi","qu","","","");
    }

    //删除购物地址
    $('#addresslist').on('click','.delete',function(){
    	$(this).parents('li').remove();			//parent parents区别
    });

    //编辑购物地址
    $('#addresslist').on('click','.edit',commonObj.address_huitian);

    //添加新地址
    $(".submit_address").on("click",commonObj.addAddresslist);

    //删除订单
    $(".order_action_cancel").on("click",function(){
    	$(this).parents('.order_form').remove();
    	if($(".order_form").length<1){
            $(".null_order").show();
        }
    });

    //登录验证
    $('#login_user').on('click',commonObj.loginin);


})