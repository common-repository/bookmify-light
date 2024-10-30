!function(o){"use strict";var e={cloneForm:o(".bookmify_be_content .bookmify_be_popup_form_wrap").clone()},t=bookmifyConfig,i={iaoAlertTime:"5000",iaoAlertPosition:"bottom-right",alertSuccessIcon:'<span class="icon_holder success"><i class="xcon-ok"></i></span>',deletedText:'<span class="text">'+t.deletedText+"</span>",savedText:'<span class="text">'+t.savedText+"</span>",addedText:'<span class="text">'+t.addedText+"</span>",errorField:'<span class="error_note">'+t.errorField+"</span>",ajaxurl:t.ajaxUrl,cacheElements:function(){this.cache={wrap:o(".bookmify_be_locations"),list:o(".bookmify_be_locations .location_list"),listItems:o(".bookmify_be_locations .location_item"),listItemsContents:o(".bookmify_be_locations .location_item .bookmify_be_list_item_content"),buttonAdd:o(".bookmify_be_add_new_location a.add_new"),buttonDelete:o(".bookmify_be_locations .location_item .buttons_holder .btn_item .bookmify_be_delete"),buttonSave:o(".bookmify_be_locations .location_item .locations_buttons_holder a"),buttonOpener:o(".bookmify_be_locations .location_item .buttons_holder .btn_item .bookmify_be_edit"),buttonCloser:o(".bookmify_be_locations .location_item .closer_button a"),buttonMediaUploader:o(".bookmify_be_locations .bookmify_thumb_edit"),buttonPagination:o(".bookmify_be_pagination.location li a"),allInputs:o('input[type="text"]')}},init:function(){o(".bookmify_be_locations").length&&o(".bookmify_be_content .bookmify_be_popup_form_wrap").remove(),this.cacheElements(),this.allNanoAppendToBody(),this.closeInputDropdown(),this.closeInputDropdownOnAction(),this.ajaxPagination(),this.deleteLocation(),this.openerLocation(),this.insertLocation(),this.imgToSvg()},allNanoAppendToBody:function(){var e=o(".bookmify_be_all_nano.location"),t=e.html();o("body").append(t),e.remove()},imgToSvg:function(){o("img.bookmify_be_svg").each(function(){var e=o(this),t=e.attr("class"),i=e.attr("src");o.get(i,function(i){var n=o(i).find("svg");void 0!==t&&(n=n.attr("class",t+" replaced-svg")),n=n.removeAttr("xmlns:a"),e.replaceWith(n)},"xml")})},closerButton:function(){var e=this;o(".bookmify_be_popup_form_wrap.enable").find("span.closer").on("click",function(){e.closePopupForm()})},closerEsc:function(){o(document).keyup(function(o){o.key})},closersPopup:function(){this.closerEsc(),this.closerButton()},closePopupForm:function(){o(".nano").removeClass("focused"),o("input").removeClass("input_clicked");var e=o(".bookmify_be_popup_form_wrap.enable");o("body").removeClass("disable_scroll"),e.removeClass("enable"),setTimeout(function(){e.remove()},300)},cancelItem:function(){var e=this;o(".bookmify_be_popup_form_button a.cancel").off().on("click",function(){return e.closePopupForm(),!1})},closeInputDropdown:function(){o(".nano").removeClass("focused"),o('input[type="text"]').removeClass("input_clicked")},closeInputDropdownOnAction:function(){var e=this;o(".bookmify_be_customfields").on("click",function(){e.closeInputDropdown()})},openerLocation:function(){var e=this;e.cache.buttonOpener.off().on("click",function(t){t.preventDefault();var i=o(this),n=i.closest(".bookmify_be_list_item"),a={action:"ajaxQueryEditLocation",bookmify_data:n.data("location-id")};return i.hasClass("loading")||(i.addClass("loading"),n.addClass("loading"),o.ajax({type:"POST",url:e.ajaxurl,cache:!0,data:a,success:function(o){i.removeClass("loading"),n.removeClass("loading"),e.getRequestedLocationPopup(o)},error:function(){}})),!1})},getRequestedLocationPopup:function(e){var t=o.parseJSON(e).bookmify_be_data;o("body").addClass("disable_scroll").append(t),o("body > .bookmify_be_popup_form_wrap").addClass("bookmify_be_popup_form_location"),this.imgToSvg(),this.mediaUpload(),this.madeInputDropdown(),this.saveLocation(),this.cancelItem(),o("body > .bookmify_be_popup_form_wrap").addClass("enable"),this.closersPopup()},deleteLocation:function(){var e=this;e.cache.buttonDelete.off().on("click",function(t){t.preventDefault();var i=o(this),n=i.parents(".location_item"),a=n.data("location-id");return i.addClass("clicked"),e.deleteLocationConfirm(n,a,i),e.closeInputDropdown(),!1})},deleteLocationConfirm:function(e,t,i){var n=this,a=o("#bookmify_be_confirm");a.addClass("opened location_confirm");var s=o("#bookmify_be_confirm.location_confirm").find("a.yes"),c=o("#bookmify_be_confirm.location_confirm").find("a.no");s.off().on("click",function(s){s.preventDefault(),i.removeClass("clicked"),i.addClass("await"),i.addClass("loading"),e.addClass("loading");var c={action:"ajaxQueryDeleteLocation",bookmify_data:t};return o.ajax({type:"POST",url:n.ajaxurl,cache:!0,data:c,success:function(t){var a=o.parseJSON(t);o(".bookmify_be_page_title h3 span.count").html(a.number),i.removeClass("await"),e.removeClass("opened").slideUp(300),e.parent().removeClass("opened"),setTimeout(function(){e.remove()},400),o.iaoAlert({msg:n.alertSuccessIcon+n.deletedText,type:"success",alertTime:n.iaoAlertTime,position:n.iaoAlertPosition})}}),a.removeClass("opened location_confirm"),!1}),c.on("click",function(){return a.removeClass(),i.removeClass("clicked"),!1}),o(document).keydown(function(o){if(27===o.keyCode)return a.removeClass(),i.removeClass("clicked"),!1})},saveLocation:function(){var e=o(".bookmify_be_popup_form_location .bookmify_be_popup_form_button a.save"),t=this;e.off().on("click",function(){var e=o(this),i=e.closest(".bookmify_be_popup_form_location"),n="insert",a=0;if(i.find(".required_field").each(function(){var e=o(this);""===e.val()&&(e.parent().find(".error_note").remove(),e.parent().addClass("required_error").append(t.errorField),a++)}),0!==a)return t.scrollToTop(500),!1;e.addClass("await");var s=i.data("entity-id"),c=[],l={};l.id=s,l.title=i.find(".bookmify_be_form_wrap .location_name").val(),l.address=i.find(".bookmify_be_form_wrap .location_address").val(),l.info=i.find(".bookmify_be_form_wrap .location_info").val(),l.imgID=i.find(".bookmify_be_form_wrap .bookmify_be_img_id").val(),l.employeesIDs=i.find(".bookmify_be_form_wrap .location_employees_ids").val(),c.push(l),s&&(n="update");var r={action:"ajaxQueryInsertOrUpdateLocation",bookmify_data:JSON.stringify(c),insertOrUpdate:n,do:1};return o.ajax({type:"POST",url:t.ajaxurl,cache:!0,data:r,success:function(o){e.removeClass("await"),t.getUpdatedLocationsList(o,n)},error:function(){}}),!1}),o(".bookmify_be_popup_form_location input.required_field").keyup(function(){var e=o(this);""!==e.val()&&e.parent().hasClass("required_error")&&(e.parent().removeClass("required_error"),e.parent().find(".error_note").remove())})},getUpdatedLocationsList:function(e,t){var i=this,n=o.parseJSON(e),a=o(".bookmify_be_locations_list"),s=o(".bookmify_be_page_title h3 span.count");i.closePopupForm(),"update"===t?setTimeout(function(){o.iaoAlert({msg:i.alertSuccessIcon+i.savedText,type:"success",alertTime:i.iaoAlertTime,position:i.iaoAlertPosition})},301):setTimeout(function(){o.iaoAlert({msg:i.alertSuccessIcon+i.addedText,type:"success",alertTime:i.iaoAlertTime,position:i.iaoAlertPosition})},301),a.html(n.bookmify_be_data),s.html(n.number);var c=a.find(".location_list .location_item");setTimeout(function(){c.each(function(e,t){setTimeout(function(){o(t).addClass("fadeInTop done")},100*e)})},150),i.init()},insertLocation:function(){var i=this;o(".bookmify_be_add_new_location a").off().on("click",function(){if(parseInt(o(".bookmify_be_page_title h3 span.count").html())>=1&&o(".bookmify_be_locations").length)o.iaoAlert({msg:i.alertSuccessIcon+t.lightVersion,type:"success",alertTime:15e3,position:i.iaoAlertPosition});else{var n=e.cloneForm.clone();o("body").addClass("disable_scroll").append(n),o("body > .bookmify_be_popup_form_wrap").addClass("bookmify_be_popup_form_location"),i.imgToSvg(),i.mediaUpload(),i.madeInputDropdown(),i.saveLocation(),i.cancelItem(),o("body > .bookmify_be_popup_form_wrap").addClass("enable"),i.closersPopup()}return!1})},mediaUpload:function(){o("body > .bookmify_be_popup_form_wrap .bookmify_thumb_edit").off().on("click",function(e){e.preventDefault(),e.stopPropagation(),o(".nano").removeClass("focused"),o("input").removeClass("input_clicked");var t=o(this).closest(".input_img"),i=t.find('input[class="bookmify_be_img_id"]'),n=t.find(".bookmify_thumb_wrap"),a=t.find(".bookmify_thumb_remove"),s="",c=wp.media({library:{type:"image"},multiple:!1});return c.on("select",function(){var e=c.state().get("selection").toJSON();e.length&&(void 0!==e[0].sizes.thumbnail?e[0].sizes.thumbnail.url:e[0].url,s=void 0!==e[0].sizes.large?e[0].sizes.large.url:e[0].url,i.val(e[0].id),n.addClass("has_image").css({"background-image":"url("+s+")"}),o(this).hide(),a.show())}),c.open(),!1}),o("body > .bookmify_be_popup_form_wrap .bookmify_thumb_remove a").off().on("click",function(e){e.preventDefault(),e.stopPropagation();var t=o(this).closest(".input_img"),i=t.find('input[class="bookmify_be_img_id"]'),n=t.find(".bookmify_thumb_wrap");return i.val(""),n.removeClass("has_image").css({"background-image":"none"}),o(this).parent().hide(),!1})},ajaxPagination:function(){var e=this;e.cache.buttonPagination.off().on("click",function(t){t.preventDefault(),o(".nano").removeClass("focused"),o("input").removeClass("input_clicked");var i=o(this),n=i.parent(),a=i.data("page"),s=0;return n.hasClass("prev")?(a=i.parent().parent().find("li.active a").data("page")-1,s=1):n.hasClass("next")&&(a=i.parent().parent().find("li.active a").data("page")+1,s=1),n.hasClass("active")||e.doAjaxCallPagination(a),1===s&&e.doAjaxCallPagination(a),e.cache.list.addClass("loading"),o([document.documentElement,document.body]).animate({scrollTop:o(".bookmify_be_content").offset().top-32},300),!1})},doAjaxCallPagination:function(e){var t=this,i={action:"locationsListAjax",bookmify_page:e};o.ajax({type:"POST",url:t.ajaxurl,cache:!0,data:i,success:function(o){t.paginationAjaxProcess(o)},error:function(){}})},paginationAjaxProcess:function(e){var t=o.parseJSON(e),i=o(".bookmify_be_locations_list");i.html(t.bookmify_be_data),this.cache.list.removeClass("loading");var n=i.find(".location_item");setTimeout(function(){n.each(function(e,t){setTimeout(function(){o(t).addClass("fadeInTop done")},100*e)})},150),this.init()},madeInputDropdown:function(){var e=o(".nano.location_employees"),t=o('.bookmify_be_popup_form_location .location_employees_holder input[type="text"]'),i=e.find('input[type="checkbox"]');function n(e){var t=e,n=t.attr("data-placeholder"),a=t.siblings(".bot_btn");a.off().on("click",function(){t.siblings(".location_employees_ids").val(""),t.siblings(".bookmify_be_new_value").html(""),i.prop("checked",!1),t.attr("placeholder",n),a.removeClass("opened"),o(".nano").removeClass("focused"),o("input").removeClass("input_clicked")})}function a(o){var e=o,t=e.siblings("input.location_employees_ids"),i=e.siblings(".bot_btn");" "===t.val()||""===t.val()?i.removeClass("opened"):i.addClass("opened")}t.each(function(){var e=o(this);a(e),n(e)}),t.on("click",function(t){t.stopPropagation();var s=o(this),c=s.closest(".bookmify_be_popup_form_location").data("entity-id"),l=s.siblings(".location_employees_ids").val().split(","),r=1;i.prop("checked",!1),e.attr("data-id",c),o.each(l,function(o,t){r++,e.find('input[type="checkbox"][value="'+t+'"]').prop("checked",!0)}),i.length===r&&(e.find(".bookmify_be_check_all_items").prop("checked",!0),e.find("li").addClass("checked"));var p=o(".nano.location_employees");if(s.hasClass("input_clicked"))o(".nano").removeClass("focused"),o("input").removeClass("input_clicked");else{o(".nano").removeClass("focused"),o("input").removeClass("input_clicked"),s.addClass("input_clicked"),p.addClass("focused"),p.css({width:s.outerWidth()+"px"});new Popper(s,p,{placement:"bottom-start",onUpdate:function(){p.css({width:s.outerWidth()+"px"})}})}!function(t){e.find("ul.employees_list li").off().on("click",function(){var s,c,l,r=o(this).index(),p=o(this).find('input[type="checkbox"]');p.is(":checked")?0===r?i.prop("checked",!1):(p.prop("checked",!1),e.find('ul.employees_list li:first input[type="checkbox"]').prop("checked",!1)):0===r?i.prop("checked",!0):(p.prop("checked",!0),e.find('ul.employees_list li:first input[type="checkbox"]').prop("checked",!1)),a(t),function(t){var i=[];e.find("ul.employees_list li").each(function(){var e=o(this),t=e.find(".bookmify_be_check_item").val();0!==e.index()&&(e.find('input[type="checkbox"]').is(":checked")?(i=o.grep(i,function(o){return o!==t}),e.addClass("checked"),i.push(e.find(".bookmify_be_check_item").val())):(e.removeClass("checked"),i=o.grep(i,function(o){return o!==t})))});var s=t.attr("data-placeholder");if(o.isEmptyObject(i))t.attr("placeholder",s),t.siblings(".bookmify_be_new_value").html("");else{var c="";if(t.attr("placeholder",""),i.length>1){var l=e.find("ul.employees_list li").length-1;c='<span class="number">'+i.length+" / "+l+"</span>"}var r='<span class="text">'+e.find("input[value="+i[0]+"]").closest("li").find("span.name").html()+"</span>";t.siblings(".bookmify_be_new_value").html("").html(r+c)}t.parent().find("input.location_employees_ids").val("").val(i),a(t),n(t)}(t),n(t),s=e.find(".employees_list li").not(":first").find('input[type="checkbox"]'),c=e.find(".employees_list li").not(":first").find('input[type="checkbox"]:checked'),l=e.find('.employees_list li:first input[type="checkbox"]'),c.length===s.length?l.prop("checked",!0):l.prop("checked",!1)})}(s)}),o(window).on("click",function(){o(".nano").removeClass("focused"),o("input").removeClass("input_clicked")}),o(".nano.location_employees").on("click",function(o){o.stopPropagation()}),e.on("click",function(o){o.stopPropagation()}),n(t)},scrollToTop:function(e){o(".bookmify_be_popup_form_wrap").animate({scrollTop:0},e)}};o(function(){i.init()})}(jQuery);