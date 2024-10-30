!function(e){"use strict";e.fn.frenifyMoveCursorToEnd=function(){this.focus();var e=this.val();return this.val("").val(e),this};var a=bookmifyConfig;moment.updateLocale("en",{months:a.calendar.monthsLong,monthsShort:a.calendar.monthsShort,weekdays:a.calendar.daysLong,weekdaysShort:a.calendar.daysShort,weekdaysMin:a.calendar.daysShort});var t={page:1,search:"",order:"ASC",text:"",orderClass:"order_asc",servicesIDs:[],customerID:"",employeeID:"",status:"",dateRange:[a.paymentStartDate,a.paymentEndDate],startDate:moment().subtract(a.paymentDateRange,"days"),endDate:moment()},r={janNameInLocal:e(".bookmify_be_months_hidden").find(".jan").val(),febNameInLocal:e(".bookmify_be_months_hidden").find(".feb").val(),marNameInLocal:e(".bookmify_be_months_hidden").find(".mar").val(),aprNameInLocal:e(".bookmify_be_months_hidden").find(".apr").val(),mayNameInLocal:e(".bookmify_be_months_hidden").find(".may").val(),junNameInLocal:e(".bookmify_be_months_hidden").find(".jun").val(),julNameInLocal:e(".bookmify_be_months_hidden").find(".jul").val(),augNameInLocal:e(".bookmify_be_months_hidden").find(".aug").val(),sepNameInLocal:e(".bookmify_be_months_hidden").find(".sep").val(),octNameInLocal:e(".bookmify_be_months_hidden").find(".oct").val(),novNameInLocal:e(".bookmify_be_months_hidden").find(".nov").val(),decNameInLocal:e(".bookmify_be_months_hidden").find(".dec").val(),defaultOption:e(".bookmify_be_months_hidden").find(".def").val()},s={iaoAlertTime:"5000",iaoAlertPosition:"bottom-right",alertSuccessIcon:'<span class="icon_holder success"><i class="xcon-ok"></i></span>',alertWarningIcon:'<span class="icon_holder warning"><i class="xcon-attention-alt"></i></span>',deletedText:'<span class="text">'+a.deletedText+"</span>",updatedText:'<span class="text">'+a.updatedText+"</span>",addedText:'<span class="text">'+a.addedText+"</span>",errorField:'<span class="error_note">'+a.errorField+"</span>",invalidEmail:'<span class="error_note">'+a.invalidEmail+"</span>",momentDateFormat:a.momentDateFormat,longMonths:a.calendar.monthsLong,calendar:{monthsLong:a.calendar.monthsLong,monthsShort:a.calendar.monthsShort,daysLong:a.calendar.daysLong,daysShort:a.calendar.daysShort,firstDay:a.calendar.firstDay},ajaxurl:a.ajaxUrl,noRecords:a.noRecords,cacheElements:function(){this.cache={buttonDetails:e(".bookmify_be_payments_list .payment_item a.bookmify_be_more"),buttonEdit:e(".bookmify_be_payments_list .payment_item a.bookmify_be_edit"),filterServiceList:e(".bookmify_be_payments .bookmify_be_services_filter_list"),filterServiceWrap:e(".bookmify_be_payments .bookmify_be_filter_list.services"),filterCustomerList:e(".bookmify_be_payments .bookmify_be_filter_popup_list.customers"),filterCustomerWrap:e(".bookmify_be_payments .bookmify_be_filter_list.customers"),filterEmployeeList:e(".bookmify_be_payments .bookmify_be_filter_popup_list.employees"),filterEmployeeWrap:e(".bookmify_be_payments .bookmify_be_filter_list.employees"),filterStatusList:e(".bookmify_be_payments .bookmify_be_filter_popup_list.status"),filterStatusWrap:e(".bookmify_be_payments .bookmify_be_filter_list.status")},this.cache.filterServiceInput=this.cache.filterServiceWrap.find(".filter_list"),this.cache.filterServiceInputPlaceholder=this.cache.filterServiceInput.attr("data-placeholder"),this.cache.filterCustomerInput=this.cache.filterCustomerWrap.find(".filter_list"),this.cache.filterCustomerInputPlaceholder=this.cache.filterCustomerInput.attr("data-placeholder"),this.cache.filterEmployeeInput=this.cache.filterEmployeeWrap.find(".filter_list"),this.cache.filterEmployeeInputPlaceholder=this.cache.filterEmployeeInput.attr("data-placeholder"),this.cache.filterStatusInput=this.cache.filterStatusWrap.find(".filter_list"),this.cache.filterStatusInputPlaceholder=this.cache.filterStatusInput.attr("data-placeholder")},init:function(){this.cacheElements(),this.imgToSvg(),this.itemOpenDetails(),this.doFilter(),this.editPaymentPaid()},imgToSvg:function(){e("img.bookmify_be_svg").each(function(){var a=e(this),t=a.attr("class"),r=a.attr("src");e.get(r,function(r){var s=e(r).find("svg");void 0!==t&&(s=s.attr("class",t+" replaced-svg")),s=s.removeAttr("xmlns:a"),a.replaceWith(s)},"xml")})},closerButton:function(){var a=this;e(".bookmify_be_popup_form_wrap.enable").find("span.closer").on("click",function(){a.closePopupForm()})},closerEsc:function(){var a=this;e(document).keyup(function(e){"Escape"===e.key&&a.closePopupForm()})},closersPopup:function(){this.closerEsc(),this.closerButton()},closePopupForm:function(){var a=e(".bookmify_be_popup_form_wrap.enable");e("body").removeClass("disable_scroll"),a.removeClass("enable"),setTimeout(function(){a.remove()},300)},wpDateToOptionDate:function(e){var a=e.split("-"),t="",s="";switch(parseInt(a[1])){case 1:s=r.janNameInLocal;break;case 2:s=r.febNameInLocal;break;case 3:s=r.marNameInLocal;break;case 4:s=r.aprNameInLocal;break;case 5:s=r.mayNameInLocal;break;case 6:s=r.junNameInLocal;break;case 7:s=r.julNameInLocal;break;case 8:s=r.augNameInLocal;break;case 9:s=r.sepNameInLocal;break;case 10:s=r.octNameInLocal;break;case 11:s=r.novNameInLocal;break;case 12:s=r.decNameInLocal}switch(r.defaultOption){case"F d, Y":t=s+" "+a[2]+", "+a[0];break;case"d F, Y":t=a[2]+" "+s+", "+a[0];break;case"Y-m-d":t=a[0]+"-"+a[1]+"-"+a[2];break;case"m/d/y":t=a[1]+"/"+a[2]+"/"+a[0];break;case"d/m/y":t=a[2]+"/"+a[1]+"/"+a[0]}return t},phpDateFormatToJsDateFormat:function(){var e="";switch(r.defaultOption){case"F d, Y":e="MMMM DD, YYYY";break;case"d F, Y":e="DD MMMM, YYYY";break;case"Y-m-d":e="YYYY-MM-DD";break;case"m/d/y":e="MM/DD/YY";break;case"d/m/y":e="DD/MM/YY"}return e},itemOpenDetails:function(){var a=this;a.cache.buttonDetails.off().on("click",function(t){t.preventDefault();var r=e(this),s=r.data("entity-id"),o=r.parents(".bookmify_be_list_item"),i={action:"ajaxQueryOpenPaymentDetails",bookmify_data:s};return r.hasClass("await")||(r.addClass("await"),o.addClass("loading"),e.ajax({type:"POST",url:a.ajaxurl,cache:!0,data:i,success:function(e){r.removeClass("await"),o.removeClass("loading"),a.getRequestedPaymentPopup(e)},error:function(){}})),!1})},getRequestedPaymentPopup:function(a){var t=e.parseJSON(a).bookmify_be_data;e("body").addClass("disable_scroll").append(t),e("body > .bookmify_be_popup_form_wrap").addClass("bookmify_be_popup_form_payment"),e("body > .bookmify_be_popup_form_wrap").addClass("enable"),this.closersPopup()},doFilter:function(){var a=e(".bookmify_be_pagination.payment li a"),r=this;a.off().on("click",function(a){a.preventDefault(),e(".bookmify_be_filter_list").removeClass("opened");var s=e(this),o=s.parent(),i=s.data("page"),n=0;return o.hasClass("prev")?(i=s.parent().parent().find("li.active a").data("page")-1,n=1):o.hasClass("next")&&(i=s.parent().parent().find("li.active a").data("page")+1,n=1),o.hasClass("active")||(t.page=i,r.filterAjaxCall()),1===n&&(t.page=i,r.filterAjaxCall()),!1}),e(".bookmify_be_payments .bookmify_be_filter_list.daterange input").daterangepicker({autoApply:!0,startDate:t.startDate,endDate:t.endDate,locale:{format:r.momentDateFormat,daysOfWeek:r.calendar.daysShort,monthNames:r.calendar.monthsLong,firstDay:parseInt(r.calendar.firstDay)}},function(e,a){t.dateRange=[],t.dateRange.push(e.format("YYYY-MM-DD")+" 00:00:00"),t.dateRange.push(a.format("YYYY-MM-DD")+" 23:59:59"),t.startDate=e,t.endDate=a,r.filterAjaxCall()}),e(window).on("click",function(){r.cache.filterServiceWrap.removeClass("opened")}),r.cache.filterServiceWrap.on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterServiceWrap.addClass("opened")});var s=null;r.cache.filterServiceList.children("div").off().on("click",function(){var a=e(this),o=a.data("id");return a.hasClass("sending")?(a.removeClass("sending"),t.servicesIDs=e.grep(t.servicesIDs,function(e){return e!==o})):(a.addClass("sending"),t.servicesIDs.push(o)),clearTimeout(s),r.checkNewValueForServiceFilterInEmployee(),s=setTimeout(function(){t.page=1,r.filterAjaxCall(),r.cache.filterServiceWrap.removeClass("opened")},700),!1}),r.cache.filterServiceWrap.find(".icon").off().on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterServiceInput.attr("placeholder",r.cache.filterServiceInputPlaceholder),r.cache.filterServiceInput.siblings(".bookmify_be_new_value").html(""),r.cache.filterServiceWrap.removeClass("ready"),r.cache.filterServiceList.children("div").removeClass("sending"),t.servicesIDs=[],r.cache.filterServiceWrap.removeClass("opened"),r.filterAjaxCall()}),e(window).on("click",function(){r.cache.filterCustomerWrap.removeClass("opened")}),r.cache.filterCustomerWrap.on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterCustomerWrap.addClass("opened")}),r.cache.filterCustomerInput.off().on("keyup",function(){var a,t,s=e(this).val().toUpperCase(),o=r.cache.filterCustomerList.children(),i=o.children("div.item"),n=0,l=o.find(".no_records");for(""!==s?r.cache.filterCustomerWrap.addClass("ready clear"):r.cache.filterCustomerWrap.removeClass("ready clear"),t=0;t<i.length;t++)((a=i[t].getElementsByTagName("span")[0]).textContent||a.innerText).toUpperCase().indexOf(s)>-1?(i[t].style.display="",n--):(i[t].style.display="none",n++);n!==i.length||l.length?n!==i.length&&o.find(".no_records").remove():o.append('<div class="no_records"><span>'+r.noRecords+"</span></div>")}),r.cache.filterCustomerList.children().children("div").off().on("click",function(){var a=e(this),s=a.data("id"),o=a.find("span").html();return a.hasClass("sending")||(a.addClass("sending"),t.customerID=s,a.siblings().removeClass("sending"),r.cache.filterCustomerInput.attr("placeholder",""),r.cache.filterCustomerInput.attr("value",o),r.cache.filterCustomerWrap.addClass("ready"),r.cache.filterCustomerWrap.removeClass("opened"),t.page=1,r.filterAjaxCall()),!1}),r.cache.filterCustomerWrap.find(".icon").off().on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterCustomerInput.attr("placeholder",r.cache.filterCustomerInputPlaceholder),r.cache.filterCustomerInput.attr("value",""),r.cache.filterCustomerList.children().children("div").removeClass("sending").css("display",""),""!==t.customerID?(t.customerID="",r.filterAjaxCall(),r.cache.filterCustomerWrap.removeClass("opened")):r.cache.filterCustomerInput.frenifyMoveCursorToEnd(),r.cache.filterCustomerWrap.removeClass("ready"),r.cache.filterCustomerWrap.removeClass("clear"),r.cache.filterCustomerList.children().find(".no_records").remove()}),e(window).on("click",function(){r.cache.filterEmployeeWrap.removeClass("opened")}),r.cache.filterEmployeeWrap.on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterEmployeeWrap.addClass("opened")}),r.cache.filterEmployeeInput.off().on("keyup",function(){var a,t,s=e(this).val().toUpperCase(),o=r.cache.filterEmployeeList.children(),i=o.children("div.item"),n=0,l=o.find(".no_records");for(""!==s?r.cache.filterEmployeeWrap.addClass("ready clear"):r.cache.filterEmployeeWrap.removeClass("ready clear"),t=0;t<i.length;t++)((a=i[t].getElementsByTagName("span")[0]).textContent||a.innerText).toUpperCase().indexOf(s)>-1?(i[t].style.display="",n--):(i[t].style.display="none",n++);n!==i.length||l.length?n!==i.length&&o.find(".no_records").remove():o.append('<div class="no_records"><span>'+r.noRecords+"</span></div>")}),r.cache.filterEmployeeList.children().children("div").off().on("click",function(){var a=e(this),s=a.data("id"),o=a.find("span").html();return a.hasClass("sending")||(a.addClass("sending"),t.employeeID=s,a.siblings().removeClass("sending"),r.cache.filterEmployeeInput.attr("placeholder",""),r.cache.filterEmployeeInput.attr("value",o),r.cache.filterEmployeeWrap.addClass("ready"),r.cache.filterEmployeeWrap.removeClass("opened"),t.page=1,r.filterAjaxCall()),!1}),r.cache.filterEmployeeWrap.find(".icon").off().on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterStatusWrap.removeClass("opened"),r.cache.filterEmployeeInput.attr("placeholder",r.cache.filterEmployeeInputPlaceholder),r.cache.filterEmployeeInput.attr("value",""),r.cache.filterEmployeeList.children().children("div").removeClass("sending").css("display",""),""!==t.employeeID?(t.employeeID="",r.filterAjaxCall(),r.cache.filterEmployeeWrap.removeClass("opened")):r.cache.filterEmployeeInput.frenifyMoveCursorToEnd(),r.cache.filterEmployeeWrap.removeClass("ready"),r.cache.filterEmployeeWrap.removeClass("clear"),r.cache.filterEmployeeWrap.children().find(".no_records").remove()}),e(window).on("click",function(){r.cache.filterStatusWrap.removeClass("opened")}),r.cache.filterStatusWrap.on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusWrap.addClass("opened")}),r.cache.filterStatusInput.off().on("keyup",function(){var a,t,s=e(this).val().toUpperCase(),o=r.cache.filterStatusList.children(),i=o.children("div.item"),n=0,l=o.find(".no_records");for(""!==s?r.cache.filterStatusWrap.addClass("ready clear"):r.cache.filterStatusWrap.removeClass("ready clear"),t=0;t<i.length;t++)((a=i[t].getElementsByTagName("span")[0]).textContent||a.innerText).toUpperCase().indexOf(s)>-1?(i[t].style.display="",n--):(i[t].style.display="none",n++);n!==i.length||l.length?n!==i.length&&o.find(".no_records").remove():o.append('<div class="no_records"><span>'+r.noRecords+"</span></div>")}),r.cache.filterStatusList.children().children("div").off().on("click",function(){var a=e(this),s=a.data("status"),o=a.find("span").html();return a.hasClass("sending")||(a.addClass("sending"),t.status=s,a.siblings().removeClass("sending"),r.cache.filterStatusInput.attr("placeholder",""),r.cache.filterStatusInput.attr("value",o),r.cache.filterStatusWrap.addClass("ready"),r.cache.filterStatusWrap.removeClass("opened"),t.page=1,r.filterAjaxCall()),!1}),r.cache.filterStatusWrap.find(".icon").off().on("click",function(e){e.preventDefault(),e.stopPropagation(),r.cache.filterServiceWrap.removeClass("opened"),r.cache.filterCustomerWrap.removeClass("opened"),r.cache.filterEmployeeWrap.removeClass("opened"),r.cache.filterStatusInput.attr("placeholder",r.cache.filterStatusInputPlaceholder),r.cache.filterStatusInput.attr("value",""),r.cache.filterStatusList.children().children("div").removeClass("sending").css("display",""),""!==t.status?(t.status="",r.filterAjaxCall(),r.cache.filterStatusWrap.removeClass("opened")):r.cache.filterStatusInput.frenifyMoveCursorToEnd(),r.cache.filterStatusWrap.removeClass("ready"),r.cache.filterStatusWrap.removeClass("clear"),r.cache.filterStatusWrap.children().find(".no_records").remove()})},checkNewValueForServiceFilterInEmployee:function(){if(e.isEmptyObject(t.servicesIDs))this.cache.filterServiceInput.attr("placeholder",this.cache.filterServiceInputPlaceholder),this.cache.filterServiceInput.siblings(".bookmify_be_new_value").html(""),this.cache.filterServiceWrap.removeClass("ready");else{var a="";if(this.cache.filterServiceInput.attr("placeholder",""),t.servicesIDs.length>1){var r=this.cache.filterServiceList.children("div").length;a='<span class="number">'+t.servicesIDs.length+" / "+r+"</span>"}var s='<span class="text">'+this.cache.filterServiceList.find('div[data-id="'+t.servicesIDs[0]+'"]').html()+"</span>";this.cache.filterServiceInput.siblings(".bookmify_be_new_value").html("").html(s+a),this.cache.filterServiceWrap.addClass("ready")}},filterAjaxCall:function(){var a=this,r=e(".bookmify_be_filter_search"),s=e(".bookmify_be_filter_order"),o={action:"ajaxFilterPaymentList",bookmify_page:t.page,bookmify_search:t.search,bookmify_order:t.order,bookmify_services:t.servicesIDs,bookmify_customer:t.customerID,bookmify_employee:t.employeeID,bookmify_status:t.status,bookmify_daterange:t.dateRange};e.ajax({type:"POST",url:a.ajaxurl,cache:!0,data:o,success:function(e){r.removeClass("await ready"),""!==t.search&&r.addClass("ready"),s.removeClass("await order_desc order_asc").addClass(t.orderClass),a.getFilteredEmlpoyeesList(e)},error:function(){}})},getFilteredEmlpoyeesList:function(a){var t=e.parseJSON(a),r=e(".bookmify_be_payment_list_content");r.html(t.bookmify_be_data);var s=r.find(".bookmify_be_list_item");setTimeout(function(){s.each(function(a,t){setTimeout(function(){e(t).addClass("fadeInTop done")},100*a)})},150),this.init()},editPaymentPaid:function(){var a=e(".bookmify_be_list.payment_list .bookmify_be_list_item"),t=a.find(".bookmify_be_edit"),r=this;t.off().on("click",function(t){t.preventDefault();var s=e(this),o=s.closest(".bookmify_be_list"),i=s.closest(".bookmify_be_list_item"),n=i.find(".payment_paid"),l=n.find("form"),c=n.find(".p_paid"),d=parseFloat(n.find('input[name="payment_paid_old"]').val()),p=parseFloat(n.find("input[type=number]").val()),f=i.find(".payment_status");if(i.hasClass("opened")){if(d===p)return i.removeClass("opened quick_edit"),o.removeClass("opened"),!1;s.addClass("await");var m={action:"ajaxQueryUpdatePaymentPaid",bookmify_data:l.serialize()};e.ajax({type:"POST",url:r.ajaxurl,cache:!0,data:m,success:function(a){var t=e.parseJSON(a);s.removeClass("await"),i.removeClass("opened quick_edit"),o.removeClass("opened"),i.find('input[name="payment_paid_old"]').val(t.price),i.find('input[type="number"]').val(t.price),c.html(t.correct_price),f.html(t.status),e.iaoAlert({msg:r.alertSuccessIcon+r.updatedText,type:"success",alertTime:r.iaoAlertTime,position:r.iaoAlertPosition}),r.imgToSvg()}})}else a.removeClass("opened quick_edit"),o.addClass("opened"),i.addClass("opened quick_edit");return l.find("input[type=number]").frenifyMoveCursorToEnd(),!1})}};e(document).ready(function(){s.init()})}(jQuery);