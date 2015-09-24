$(function(){
    app.frame();
    app.dashboard();
    app.product();
    app.category();
    app.category.variation();
    app.merchant();
});


var app = {};
app.component = {};
app.component.chosen = function(){
    if ($('select[p_action_dom="chosen-select"]')[0]) {
        $('select[p_action_dom="chosen-select"]').chosen({ width: '100%' });
        $('select[p_action_dom="chosen-select"]').on('change', function(evt, params) {
            console.log(params);
            console.log($(this).find('option:selected'));
        });
    }
    if ($('select[p_action_dom="chosen-select-no-search"]')[0]) {
        $('select[p_action_dom="chosen-select-no-search"]').chosen({ width: '100%',disable_search: true });
        $('select[p_action_dom="chosen-select-no-search"]').on('change', function(evt, params) {
            console.log(params);
            console.log($(this).find('option:selected'));
        });
    }
}
app.component.editable = function(){
    if ($('[p_action_dom="editable-item"]')[0]) {
        var editable_item = $('[p_action_dom="editable-item"]').popover({
            html:true,
            placement:'top',
            trigger:'click',
            content:'<div class="form-inline">'+
                        '<input type="text" class="form-control input-sm" style="padding-right: 24px;">'+
                        '<button type="submit" class="btn btn-primary btn-sm editable-submit" style="margin-left:5px;" p_action_dom="btn-edit"><i class="fa fa-check"></i></button>'+
                        '<button type="button" class="btn btn-default btn-sm editable-cancel" style="margin-left:5px;" p_action_dom="btn-close"><i class="fa fa-times"></i></button>'+
                    '</div>'
        });
        editable_item.on('shown.bs.popover', function () {
            $this = $(this);
            var popover = $this.next();
            popover.find('input').val($this.text());
            popover.find('button[p_action_dom="btn-close"]').on('click',function(e){
                editable_item.popover('hide');
            });
            popover.find('input').select();
            popover.find('button[p_action_dom="btn-edit"]').on('click',function(e){
                if ($.trim(popover.find('input').val())=='') {
                    return false;
                }
                $this.text(popover.find('input').val());
                editable_item.popover('hide');
            });
        })
    }
};
app.component.upload = function(){
    //Dropzone.autoDiscover = false;
    if (typeof Dropzone == "undefined") {
        return false;
    }
    Dropzone.options.uuuu = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        acceptedFiles: 'image/jpeg',
        accept: function(file, done) {
            if (file.name == "1.jpg") {
                done("Naha, you don't.");
            }else {
                done();
            }
        },
        init: function() {
            var myDropzone = this;
            var upload = $('#upload');
            upload.on('click',function(e){
                myDropzone.processQueue();
                alert(88);
            });
            this.on("addedfile", function() {
                // Show submit button here and/or inform user to click it.
                console.log('添加了一个图片');
            });
        },
        addRemoveLinks:true,
        removedfile: function(file) {
            var name = file.name;        
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: "id="+name,
                dataType: 'html'
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
        }
        
    };
};

app.frame = function(){
    /*
     * Lightbox
     */
    if ($('.lightbox')[0]) {
        $('.lightbox').lightGallery({
            enableTouch: true
        }); 
    }
    
    app.component.chosen();
    app.component.editable();
    app.component.upload();
    // ASIDE
	// =================================================================
	// Toggle Visibe
	// =================================================================
	$('#demo-toggle-aside').on('click', function (ev) {
		ev.preventDefault();
		if (!nifty.container.hasClass('aside-in')) {
			$.niftyAside('show');
		} else {
			$.niftyAside('hide');
		}
	});
    
    
    
    
    
    // GENERATE RANDOM ALERT
	// =================================================================
	// Require Admin Core Javascript
	// http://themeon.net
	// =================================================================

	var dataAlert = [{
			icon: 'fa fa-info fa-lg',
			title: "Info",
			type: "info"
	}, {
			icon: 'fa fa-star fa-lg',
			title: "Primary",
			type: "primary"
	}, {
			icon: 'fa fa-thumbs-up fa-lg',
			title: "Success",
			type: "success"
	}, {
			icon: 'fa fa-bolt fa-lg',
			title: "Warning",
			type: "warning"
	}, {
			icon: 'fa fa-times fa-lg',
			title: "Danger",
			type: "danger"
	}, {
			icon: 'fa fa-leaf fa-lg',
			title: "Mint",
			type: "mint"
	}, {
			icon: 'fa fa-shopping-cart fa-lg',
			title: "Purple",
			type: "purple"
	}, {
			icon: 'fa fa-heart fa-lg',
			title: "Pink",
			type: "pink"
	}, {
			icon: 'fa fa-sun-o fa-lg',
			title: "Dark",
			type: "dark"
	}
	];
    // GROWL LIKE NOTIFICATIONS
	// =================================================================
	// Require Admin Core Javascript
	// =================================================================
	$('#demo-alert').on('click', function (ev) {
		ev.preventDefault();
		var dataNum = nifty.randomInt(0, 8);


		$.niftyNoty({
			type: dataAlert[dataNum].type,
			icon: dataAlert[dataNum].icon,
			title: dataAlert[dataNum].title,
			message: "Lorem ipsum dolor sit amet.",
			container: 'floating',
			timer: 3500
		});
	});
    
    
    
    
    
    
    // ALERT ON TOP PAGE
	// =================================================================
	// Require Admin Core Javascript
	// =================================================================

	// Show random page alerts.
	$('#demo-page-alert').on('click', function (ev) {
		ev.preventDefault();
		var dataNum = nifty.randomInt(0, 8),
			timer = function () {
				if (nifty.randomInt(0, 5) < 4) return 3000
				return 0;
			}();

		// Show random page alerts.
		$.niftyNoty({
			type: dataAlert[dataNum].type,
			icon: dataAlert[dataNum].icon,
			title: function () {
				if (timer > 0) {
					return 'Autoclose Alert'
				}
				return 'Sticky Alert Box'
			}(),
			message: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
			timer: timer
		});
	});
    
    
    
    
    
    
    
    // LANGUAGE SWITCHER
	// =================================================================
	// Require Admin Core Javascript
	// http://www.themeOn.net
	// =================================================================
	$('#demo-lang-switch').niftyLanguage({
		onChange: function (e) {
			$.niftyNoty({
				type: 'info',
				icon: 'fa fa-info fa-lg',
				title: 'Language changed',
				message: 'The language apparently changed, the selected language is : <strong> ' + e.id + ' ' + e.name + '</strong> '
			});
		}
	});
    
}
app.dashboard = function(){
    // 基于准备好的dom，初始化echarts图表
   if ($('#echarts_month_compare')[0]) {
        var echarts_month_compare = echarts.init($('#echarts_month_compare')[0]);
        echarts_month_compare.setOption({
            legend: {
                data:['本月','月同比']
            },
            toolbox: {
                show : true,
                feature : {
                    magicType : {show: true, type: ['line', 'bar']},
                    saveAsImage : {show: true}
                }
            },
            tooltip:{
                trigger: 'axis',
                axisPointer : {
                    lineStyle : { width: 0 }
                }
            },
            grid: {
                x: 40,y: 30,x2: 20,y2: 30,
                borderWidth: 0,
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
                    splitLine:{ show:false }
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    splitLine:{
                        show:true,
                        lineStyle: {
                            color: ['rgb(223,223,223)'],
                            width: 1
                        }
                    }
                }
            ],
            series : [
                {
                    name:'本月',
                    type:'bar',
                    data:[100, 200, 50.99, 249.9, 40.99, 76.7, 135.6, 162.2, 32.6, 20.0, 16.99, 20.99,400,200,199,300,222,123,100,100,100,100,100,100,100,100,100,100,100,100,100]
                },
                {
                    name:'月同比',
                    type:'bar',
                    data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100]
                }
            ]
        });
    }
   
    if ($('#echarts_product_compare')[0]) {
        var echarts_product_compare = echarts.init($('#echarts_product_compare')[0]);
        echarts_product_compare.setOption({
            tooltip : {
                trigger: 'axis',
                axisPointer : {
                    lineStyle : { width: 0 }
                }
            },
            toolbox: {
                show : false
            },
            grid: {
                x: 80,y: 0,x2: 10,y2: 20,
                borderWidth: 0,
            },
            xAxis : [
                {
                    type : 'value',
                    splitLine:{ show:false }
                }
            ],
            yAxis : [
                {
                    type : 'category',
                    data : ['时尚女鞋','时尚男鞋','女式衣服','男士衣服','公主风四件套','宠物抱枕套(件)'],
                    splitLine:{ show:false }
                }
            ],
            series : [
                {
                    name:'2015年09月销售量',
                    type:'bar',
                    data:[100, 800, 100, 300, 200, 100]
                }
            ]
        });
    }
    
    if ($('#echarts_country_compare')[0]) {
        var echarts_country_compare = echarts.init($('#echarts_country_compare')[0]);
        echarts_country_compare.setOption({
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:['美国','俄罗斯','欧洲','澳大利亚','其他国家']
            },
            toolbox: {
                show : false
            },
            series : [
                {
                    name:'订单来源',
                    type:'pie',
                    radius : '100%',
                    center: ['50%', '50%'],
                    selectedOffset: 10,
                    itemStyle: {
                        normal: {
                            label: { show: true,position: 'outer' },
                            labelLine: { show: false }
                        }
                    },
                    data:[
                        {value:335, name:'美国'},
                        {value:310, name:'俄罗斯'},
                        {value:234, name:'欧洲'},
                        {value:135, name:'澳大利亚'},
                        {value:1548, name:'其他国家'}
                    ]
                }
            ]
        });
    }
    
    
}

app.product = function(){
    //显示规格处理modal
    var product_manage_variation_modal = $('div[p_action_dom="product_manage_variation_modal"]');
    $('#btn_manage_variation_modal').click(function(e){
        product_manage_variation_modal.modal('show');
    });
    //显示图片上传modal
    var product_upload_img_modal = $('div[p_action_dom="product_upload_img_modal"]');
    $('#btn_product_add_upload_img_modal').click(function(e){
        product_upload_img_modal.modal('show');
    });
    
    ///添加产品时的设置规格
    var add_body_str = '';
    var table_set_variation = $('table[p_action_dom="table_set_variation"]');//设置规格的表格
    var btn_add_tbody = $('button[p_action_dom="btn_add_tbody"]');
    btn_add_tbody.on('click',function(e){
        table_set_variation.append(add_body_str);
        app.component.chosen();
        app.component.editable();
    });
    $('select[p_action_dom="chosen-select-set-variation"]').chosen({
        width: '100%',
        max_selected_options: 20 
    }).on('change', function(evt, params){
        var selected = $(this).find('option:selected');
        if (selected.length <=0 ) {
            table_set_variation.css({'display':'none'});
            btn_add_tbody.css({'display':'none'});
        }else{
            table_set_variation.css({'display':'block'});
            btn_add_tbody.css({'display':'block'});
        }
        var html_head = '';
        var html_body = '';
        for(var i = 0; i < selected.length; i++){
            html_head += '<th class="min-width">'+$(selected[i]).text()+'</th>';
            html_body +='<td>'+
                            '<select p_action_dom="chosen-select-no-search">'+
                            '    <option value="0">颜色</option>'+
                            '    <option value="1">尺寸</option>'+
                            '    <option value="2">重量</option>'+
                            '    <option value="3">材质</option>'+
                            '    <option value="4">体积</option>'+
                            '</select>'+
                        '</td>';
        }
        html_head += '<th>条码</th><th>进货价</th><th>库存</th><th>操作</th>';
        html_body +='<td><a href="javascript:void(0)" class="editable-item" p_action_dom="editable-item">点击添加</a></td>'+
                    '<td><a href="javascript:void(0)" class="editable-item" p_action_dom="editable-item">点击添加</a></td>'+
                    '<td><a href="javascript:void(0)" class="editable-item" p_action_dom="editable-item">点击添加</a></td>'+
                    '<td><button class="btn btn-xs btn-danger" p_action_dom="btn_remove_tbody"><i class="fa fa-times"></i></button></td></tr></tbody>';
        table_set_variation.find('thead tr').html(html_head);
        table_set_variation.find('tbody tr').html(html_body);
        add_body_str = table_set_variation.find('tbody').prop("outerHTML");
        app.component.chosen();
        app.component.editable();
    });
    //删除按钮
    table_set_variation.on('click','tbody tr td button[p_action_dom="btn_remove_tbody"]',function(e){
        $this = $(this);
        var tbody = table_set_variation.find('tbody');
        if (tbody.length <= 1) {
            swal("错误!", "至少有一条子规格！", "error");
            return false;
        }
        swal({
            title: "确认删除?",
            text: "你将要删除子规格属性!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },function(isConfirm){
            $this.parents('tbody').remove(); 
            swal("删除啦!", "已经删除次子规格.", "success");
        });
    });
    
}

app.category = function(){
    var category_modal_modify = $('div[p_action_dom="category_modal_modify"]');
    var category_modal_add = $('div[p_action_dom="category_modal_add"]');
    var category_modal_delete = $('div[p_action_dom="category_modal_delete"]');
    category_modal_add.on('shown.bs.modal', function (e) {
        
    });
    $('button[p_action_dom="btn_category_modify_show"]').on('click',function(e){
        var tr = $(this).parents('tr');
        category_modal_modify.find('input[p_action_dom="input_category_name"]').val(tr.attr('p_action_value_name'));
        category_modal_modify.find('label[p_action_dom="label_category_parent"]').text(tr.attr('p_action_value_parent'));
        category_modal_modify.modal('show');
        
    });
    $('button[p_action_dom="btn_category_delete_show"]').on('click', function(){
		category_modal_delete.modal('show');
	});
}
app.category.variation = function(){
    var variation_modal_add = $('div[p_action_dom="variation_modal_add"]');
    $('#btn_variation_add_modal').on('click',function(e){
        variation_modal_add.modal('show');
    });
    
    ///tagsinput
    $('input[data-role="tagsinput"]').on('beforeItemAdd',function(e){
        alert('添加前');
    });
    $('input[data-role="tagsinput"]').on('itemAdded',function(e){
        alert('添加了');
    });
    
    $('input[data-role="tagsinput"]').on('beforeItemRemove',function(e){
        alert('删除前');
    });
    $('input[data-role="tagsinput"]').on('itemRemoved',function(e){
        alert('删除了');
    });
    ///end tagsinput
}

app.merchant = function(){
    //显示添加供应商modal
    var add_merchant_modal = $('div[p_action_dom="add_merchant_modal"]');
    $('#btn_add_merchant').click(function(e){
        add_merchant_modal.modal('show');
    });
}
