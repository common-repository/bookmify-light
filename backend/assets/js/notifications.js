!function(e){"use strict";var t=bookmifyConfig,i={iaoAlertTime:"5000",iaoAlertPosition:"bottom-right",alertSuccessIcon:'<span class="icon_holder success"><i class="xcon-ok"></i></span>',deletedText:'<span class="text">'+t.deletedText+"</span>",savedText:'<span class="text">'+t.savedText+"</span>",addedText:'<span class="text">'+t.addedText+"</span>",testSent:'<span class="text">'+t.testSent+"</span>",testNotSend:'<span class="text">'+t.testNotSend+"</span>",invalidEmail:'<span class="bookmify_error_note">'+t.invalidEmail+"</span>",errorField:'<span class="bookmify_error_note">'+t.errorField+"</span>",ajaxurl:t.ajaxUrl,cacheElements:function(){this.cache={wrap:e(".bookmify_be_notification"),list:e(".bookmify_be_notification .notifications_list"),listItems:e(".bookmify_be_notifications .notification_item"),listItemsContents:e(".bookmify_be_notifications .notification_item .bookmify_be_list_item_content"),buttonAdd:e(".bookmify_be_add_new_notification a.add_new"),buttonDelete:e(".bookmify_be_notifications .notification_item .buttons_holder .btn_item .bookmify_be_delete"),buttonSave:e(".bookmify_be_notifications .notification_item .notifications_buttons_holder .bookmify_be_main_save_button > a"),buttonStatus:e(".bookmify_be_notifications .notification_item .notification_status input.status"),buttonOpener:e(".bookmify_be_notifications .notification_item .buttons_holder .btn_item .bookmify_be_edit"),buttonCloser:e(".bookmify_be_notifications .notification_item .closer_button a"),buttonTES:e(".bookmify_be_notifications .notification_item .bookmify_be_test_email_form_wrap a.te_send")}},init:function(){this.cacheElements(),this.openItemContent(),this.closeItemContent(),this.itemSave(),this.itemStatusChange(),this.itemEmailTest(),this.scheduledOpener(),this.scheduledOpener2()},scheduledOpener:function(){var t=e(".nano.scheduled_nano"),i=e('.bookmify_be_notifications .scheduled_holder.one_day input[type="text"]'),n=this;i.each(function(){var i=e(this),o=i.parent().find(".bot_btn");e(window).on("click",function(){t.removeClass("focused")}),t.on("click",function(e){e.stopPropagation()}),i.off().on("click",function(n){n.stopPropagation();var o=e(this).parent().find('input[type="hidden"]').val();t.css({width:i.outerWidth()+"px"}),i.hasClass("input_clicked")?(i.removeClass("input_clicked"),t.removeClass("focused")):(e(".nano:not(.scheduled_nano)").removeClass("focused"),t.find(".nano-content > div").removeClass("selected"),t.find('.nano-content > div[data-val="'+o+'"]').addClass("selected"),i.addClass("input_clicked"),t.addClass("focused"),new Popper(i,t,{placement:"bottom-start",onUpdate:function(){t.css({width:i.outerWidth()+"px"})}})),i.parent().removeClass("required_error"),i.parent().find(".bookmify_error_note").remove()}),t.css({width:i.outerWidth()+"px"}),t.find(".nano-content > div").on("click",function(a){a.stopPropagation();var s=e(this),c=s.html(),r=s.data("val");0===r?e(".bookmify_be_notifications .input_clicked").val(""):e(".bookmify_be_notifications .input_clicked").val(c),e(".bookmify_be_notifications .input_clicked").parent().find('input[type="hidden"]').val(r),t.find(".nano-content > div").removeClass("selected"),s.addClass("selected"),n.checkCategoryID(i,o),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked"),n.itemSave()}),o.on("click",function(){e(".bookmify_be_notifications .input_clicked").val(""),e(".bookmify_be_notifications .input_clicked").parent().find('input[type="hidden"]').val(""),o.removeClass("opened"),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked")}),n.checkCategoryID(i,o)})},scheduledOpener2:function(){var t=e(".nano.scheduled_nano_2"),i=e('.bookmify_be_notifications .scheduled_holder.x_time input[type="text"]'),n=this;i.each(function(){var i=e(this),o=i.parent().find(".bot_btn");e(window).on("click",function(){t.removeClass("focused")}),t.on("click",function(e){e.stopPropagation()}),i.off().on("click",function(n){n.stopPropagation();var o=e(this).parent().find('input[type="hidden"]').val();t.css({width:i.outerWidth()+"px"}),i.hasClass("input_clicked")?(i.removeClass("input_clicked"),t.removeClass("focused")):(e(".nano:not(.scheduled_nano_2)").removeClass("focused"),t.find(".nano-content > div").removeClass("selected"),t.find('.nano-content > div[data-val="'+o+'"]').addClass("selected"),i.addClass("input_clicked"),t.addClass("focused"),new Popper(i,t,{placement:"bottom-start",onUpdate:function(){t.css({width:i.outerWidth()+"px"})}})),i.parent().removeClass("required_error"),i.parent().find(".bookmify_error_note").remove()}),t.css({width:i.outerWidth()+"px"}),t.find(".nano-content > div").on("click",function(a){a.stopPropagation();var s=e(this),c=s.html(),r=s.data("val");0===r?e(".bookmify_be_notifications .input_clicked").val(""):e(".bookmify_be_notifications .input_clicked").val(c),e(".bookmify_be_notifications .input_clicked").parent().find('input[type="hidden"]').val(r),t.find(".nano-content > div").removeClass("selected"),s.addClass("selected"),n.checkCategoryID(i,o),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked"),n.itemSave()}),o.on("click",function(){e(".bookmify_be_notifications .input_clicked").val(""),e(".bookmify_be_notifications .input_clicked").parent().find('input[type="hidden"]').val(""),o.removeClass("opened"),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked")}),n.checkCategoryID(i,o)})},checkCategoryID:function(e,t){" "===e.val()||""===e.val()?t.removeClass("opened"):t.addClass("opened")},openItemContent:function(){var t=this;t.cache.buttonOpener.off().on("click",function(i){i.preventDefault(),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked");var n=e(this).parents(".notification_item");return n.hasClass("opened")?(t.cache.list.removeClass("opened"),n.removeClass("opened"),n.find(".bookmify_be_list_item_content").slideUp(300)):(t.cache.listItems.removeClass("opened"),t.cache.listItemsContents.slideUp(300),t.cache.list.addClass("opened"),n.addClass("opened"),n.find(".bookmify_be_list_item_content").slideDown(300)),!1})},closeItemContent:function(){var t=this;t.cache.buttonCloser.each(function(){e(this).off().on("click",function(i){i.preventDefault();var n=e(this).parents(".notification_item");return n.hasClass("opened")&&(t.cache.list.removeClass("opened"),n.removeClass("opened"),n.find(".bookmify_be_list_item_content").slideUp(300)),!1})})},scrollToTop:function(t,i){e([document.documentElement,document.body]).animate({scrollTop:t.offset().top-32},i)},itemSave:function(){var t=this;t.cache.buttonSave.off().on("click",function(i){i.preventDefault(),e(".nano").removeClass("focused"),e("input").removeClass("input_clicked");var n=e(this),o=n.parents(".notification_item"),a=o.data("notification-id"),s=[],c={};c.id=a,c.subject=o.find(".bookmify_be_form_wrap .notification_subject").val(),c.text=tinyMCE.get("bookmify_be_tinymce_"+a).getContent(),s.push(c);var r=o.find(".required_field"),d=0;if(r.each(function(){var i=e(this);""===i.val()&&(i.parent().find(".error_note").remove(),i.parent().addClass("required_error").append(t.errorField),d++)}),0!==d)return t.scrollToTop(o,500),!1;n.addClass("await");var l=o.find(".not_hid_type").val(),f="",_="";"customer_reminder_prev_day"===l||"employee_reminder_prev_day"===l?f=o.find('input[name="scheduled_for_hidden"]').val():"customer_reminder_x_before"!==l&&"employee_reminder_x_before"!==l||(_=o.find('input[name="scheduled_for_hidden"]').val());var u={action:"querySaveNotification",bookmify_data:JSON.stringify(s),checkTime:f,xBefore:_,type:l};return e.ajax({type:"POST",url:t.ajaxurl,cache:!0,data:u,success:function(){t.saveNotificationAjaxProcess(),n.removeClass("await")}}),!1})},saveNotificationAjaxProcess:function(){e.iaoAlert({msg:this.alertSuccessIcon+this.savedText,type:"success",alertTime:this.iaoAlertTime,position:this.iaoAlertPosition})},itemStatusChange:function(){var t=this;t.cache.buttonStatus.on("change",function(i){i.preventDefault();var n=e(this),o=n.parents(".notification_item").data("notification-id"),a=[],s={};s.id=o,s.status=n.prop("checked")?1:0,a.push(s);var c={action:"queryChangeNotificationStatus",bookmify_data:JSON.stringify(a)};return e.ajax({type:"POST",url:t.ajaxurl,cache:!0,data:c,success:function(){}}),!1})},itemEmailTest:function(){var t=this;t.cache.buttonTES.off().on("click",function(i){i.preventDefault();var n=e(this),o=n.parent().find(".recipient_email"),a=o.val(),s=0;if(""===a?(s++,o.parent().find(".bookmify_error_note").remove(),o.parent().addClass("bookmify_invalid_email").append(t.errorField)):/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(a)||(o.parent().find(".bookmify_error_note").remove(),o.parent().addClass("bookmify_invalid_email").append(t.invalidEmail),s++),0===s){var c=n.parents(".notification_item"),r=c.data("notification-id"),d=[],l={};l.id=r,l.recipient=a,l.subject=c.find(".bookmify_be_form_wrap .notification_subject").val(),l.text=tinyMCE.get("bookmify_be_tinymce_"+r).getContent(),d.push(l);var f={action:"queryEmailTest",bookmify_data:JSON.stringify(d)};n.hasClass("await")||(n.addClass("await"),e.ajax({type:"POST",url:t.ajaxurl,cache:!0,data:f,success:function(){n.removeClass("await"),o.val(""),e.iaoAlert({msg:t.alertSuccessIcon+t.testSent,type:"success",alertTime:t.iaoAlertTime,position:t.iaoAlertPosition})},error:function(i,a,s,c){n.removeClass("await"),o.val(""),e.iaoAlert({msg:t.alertWarningIcon+t.testNotSend,type:"success",alertTime:t.iaoAlertTime,position:t.iaoAlertPosition})}}))}return o.keyup(function(){var t=e(this);t.parent().hasClass("bookmify_invalid_email")&&(t.parent().removeClass("bookmify_invalid_email"),t.parent().find(".bookmify_error_note").remove())}),!1})}};e(function(){i.init()})}(jQuery);