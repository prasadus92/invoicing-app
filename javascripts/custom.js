$(function() {
   $('textarea').css('overflow', 'hidden').autogrow();
    var howToFormat = $('#currency_format :selected').val();

   	function sumItems(item_ref,currency){
         floatValues();
   		var item_quantity = $(item_ref).closest('tr').find('.item_quantity').val();
   		var item_price = $(item_ref).closest('tr').find('.item_price').val();   		

   		var total = parseFloat(item_quantity) * parseFloat(item_price);

         if(howToFormat == 'Hprepend' || howToFormat == 'Fprepend')
         {
      		$(item_ref).closest('tr').find('.item_total').html(currency + ' ' + total);
         }
         else
         {
            $(item_ref).closest('tr').find('.item_total').html(total + ' ' + currency);
         }
         if(howToFormat == 'Hprepend' || howToFormat == 'Fprepend')
   		{
            $(item_price).val(currency + ' ' + item_price);
         }
         else
         {
            $(item_price).val(item_price + ' ' + currency);
         }
   	}
   	
      function floatValues(currency){
          $('.item_quantity').each(function(){
            if($(this).val().length == 0)
            {
               $(this).val(0);
            }
          });
          $('.item_price').each(function(){
            if($(this).val().length == 0)
            {
               $(this).val(0);
            }
          });

      }
   	function subTotal(currency){
          var sum = 0;
          floatValues(currency);
          $('.item_total').each(function(index) {
             var item_quantity = $(this).closest('tr').find('.item_quantity').val();
             var item_price = $(this).closest('tr').find('.item_price').val();
             var total_initial = parseFloat(item_quantity) * parseFloat(item_price);
             sum += total_initial;
          });
          var sum = Math.floor(sum * 100) / 100;
          if(howToFormat == 'Hprepend' || howToFormat == 'Fprepend')
          {
             $('#formsubtotal').html(currency + ' ' + sum);
          }
          else
          {
             $('#formsubtotal').html(sum + ' ' + currency);
          }
   	}
      
      function countSalesTax(currency){
         var salesTax = $('#salestax').val();
            salesTax = salesTax.replace(/\D/g, '');
            salesTax = parseInt(salesTax, 10);
            $('#sales_tax_percen').val(salesTax);

            var subTotal = $('#formsubtotal').html();
            subTotal = subTotal.replace(currency, '');
            subTotal = parseFloat(subTotal, 10);

            var grandTotal = parseFloat((subTotal * salesTax)) / 100;
             var grandTotal = Math.floor(grandTotal * 100) / 100;

              if(howToFormat == 'Hprepend' || howToFormat == 'Fprepend')
              {
                  $('#formtax').html(currency + ' ' + grandTotal);
               }
               else
               {
                  $('#formtax').html(grandTotal + ' ' + currency);
               }
             grandSumTotal = parseFloat(grandTotal) + parseFloat(subTotal);
             var grandSumTotal = Math.floor(grandSumTotal * 100) / 100;

              if(howToFormat == 'Hprepend' || howToFormat == 'Fprepend')
              {
                  $('#formgrandtotal').html(currency + ' ' + grandSumTotal);
              }
              else
              {
                  $('#formgrandtotal').html(grandSumTotal + ' ' + currency);
              }
       }
       
       var tax_template = '<tr><th class="span-20" colspan="4"><input value="Salex Tax( 20% )" id="salestax" class="salestax" name="sales_tax_text"></th><th id="formtax" class="formtax span-4 noteditable"></th></tr>';

      function updateFormValue(data){
         $('#php_values').val(data);
      }
      

   	$('.item_quantity').live("keyup",function(){
   		sumItems($(this),$('#selected_currency').val());
         floatValues();
         subTotal($('#selected_currency').val());
         countSalesTax($('#selected_currency').val());
         updateFormValue($('#invoice_form').html());
   	});
   	
   	$('.item_price').live("keyup",function(){
   		sumItems($(this),$('#selected_currency').val());
         floatValues();
         subTotal($('#selected_currency').val());
         countSalesTax($('#selected_currency').val());
         updateFormValue($('#invoice_form').html());
   	});
      
      $('#salestax').keyup(function(){
         countSalesTax($('#selected_currency').val());
         updateFormValue($('#invoice_form').html());
      });
      
      var item_sno = $('#invoice_item table tbody tr:last td:first input').val();
      $('#add_row').click(function(){
         item_sno++;
         var rowTemplate = '<tr><td><input type="text" name="item_sno[]" value="'+item_sno+'" readonly class="noteditable"></td><td><input type="text" name="item_description[]" value=""></td><td><input type="text" name="item_quantity[]" class="item_quantity" value=""></td><td><input type="text" name="item_price[]" class="item_price" value=""></td><td><span class="item_total noteditable"></span></td></tr>';
         $('#invoice_item table tbody').append(rowTemplate);
         return false;
      });
      
      $('#delete_row').click(function(){
         if($('#invoice_item table tbody tr').length >= 3)
         {
            item_sno--;
            $('#invoice_item table tbody tr:last-child').remove();
         }
         return false;
      });
      
        $('#generate_pdf_form').click(function(){
         var final_total_before_submit = $('#formgrandtotal').html();
         if(final_total_before_submit.length !== 0)
         {
            getValueOnly = final_total_before_submit.match(/([0-9]+)/);
            if(getValueOnly[0] != 0)
            {
              if($('#create_invoice_without_client').val() == 'false')
               {
                  alert('You must selected a valid client');
               }
               else if($('#auto_suggest_client_id').length)
               {
                  document.form_invoice.submit();
               }
               else
               {
                  alert('You must selected a valid client');
               }
            }
            else
            {
               alert('Cannot create empty invoice');
            }
         }
         else
         {
            alert('Cannot create empty invoice');
         }
         return false;
      });
      
      $('#drop_down_tab').click(function(){
         $('#user_sub_menu').toggle();
         return false;
      });
      
      
      /* MANAGING SETTINGS */
      
      $('#pop_up_settings').click(function(){
         $('#settings_dialog').show();
         $('.bck_bg').show();
         return false;
      });
      $('.modal_close').click(function(){
         $('#settings_dialog').hide();
         $('.bck_bg').hide();
         return false;
      });
      
      /* Managing Email Settings */

      $('#email_pop_up_settings').click(function(){
         $('#email_settings_dialog').show();
         $('.bck_bg').show();
         return false;
      });

      $('.email_modal_close').click(function(){
         $('#email_settings_dialog').hide();
         $('.bck_bg').hide();
         return false;
      });



      /* showing upload overlay */
      $('.company_logo').hover(function(){
         $(this).find('.overlay').removeClass('hidden');
      },
      function(){
         $(this).find('.overlay').addClass('hidden');
      });

      $('.client_logo').hover(function(){
         $(this).find('.client_overlay').removeClass('hidden');
      },
      function(){
         $(this).find('.client_overlay').addClass('hidden');
      });


      $('.watermark_image_logo').hover(function(){
         $(this).find('.watermark_overlay').removeClass('hidden');
      },
      function(){
         $(this).find('.watermark_overlay').addClass('hidden');
      });


      function Currency(){
         var currency = $('#currency').val();
         var formated_currency = currency + '  ' + map[currency]
         $('#selected_currency').val(formated_currency);
         return formated_currency;
      }

      $('#currency').mouseup(Currency);
      $('#currency').mousedown(Currency);
      $('#currency').keyup(Currency);
      $('#currency').keydown(Currency);

      var email = $('#email');
      var new_password = $('#new_password');
      var new_password_repeat = $('#new_password_repeat');
      
      $('#save_settings').click(function(){
         if(validateEmail() && validatePasswordConfirm() && validateWaterMarkOptions() && validateCompanyName() && validateStreetAddress() && validateCityAddress() && validateStateAddress())
         {
            settings_data = 'email=' + email.val() + '&new_password=' + new_password.val() + '&new_password_repeat=' + new_password_repeat.val() + '&selected_currency=' + $('#selected_currency').val() + '&currency=' + $('#currency').val() + '&currency_text=' + $('#currency option:selected').text() + '&show_logo=' + $('#show_company_logo').val() + '&add_watermark=' + $('#add_watermark').val() + '&watermark_text_input=' + $('#watermark_text_input').val() + '&currency_format=' + $('#currency_format').val()  + '&your_company_name_settings=' + $('#your_company_name_settings').val() + '&street_address_settings=' + $('#street_address_settings').val() + '&city_settings=' + $('#city_settings').val() + '&state_settings=' + $('#state_settings').val() + '&phone_no=' + $('#phone_no').val() + '&pdf_footer_add=' + $('#pdf_footer_add').val() + '&pdf_footer_text=' + $('#pdf_footer_text').val();
            $.post('libs/updateSettings.php',settings_data,function(response){
               if(response == 'true' || response == ' true')
               {
                  $('#settings_dialog').find('#settings_body').html('<div id="settings_message"><p>Changes have been saved. Please wait window will reload automatically.<p></div>');
                  setTimeout(function(){
                     window.location.reload();
                  },1000);
               }
               else
               {
                  $('#settings_body').html('<div id="settings_message"><p>'+response+'<p></div>');
               }
            });
         }
         return false;
      });

      function validateEmail(){
         if(email.val().length == 0)
         {
            $(email).addClass('error');
            return false;
         }
         else
         {
            $(email).removeClass('error');
            return true;
         }
      }
      
      function validatePasswordConfirm(){
         if(new_password.val().length > 0)
         {
            if(new_password.val() !== new_password_repeat.val())
            {
               $(new_password).addClass('error');
               $(new_password_repeat).addClass('error');
               return false;
            }
            else
            {
               $(new_password).removeClass('error');
               $(new_password_repeat).removeClass('error');
               return true;
            }
         }
         else
         {
            return true;
         }
      }
      
      function validateWaterMarkOptions(){
         if($('#add_watermark').val() == 'Text Watermark')
         {
            if($('#watermark_text_input').val().length == 0)
            {
               $('#watermark_text_input').addClass('error');
               return false;
            }
            else
            {
               $('#watermark_text_input').removeClass('error');
               return true;
            }
         }
         else
         {
            return true;
         }
      }
      
      function validateCompanyName(){
         if($('#your_company_name_settings').val().length == 0)
         {
            $('.header_setting_tab').addClass('hidden');
            $('.company_settings_tab').removeClass('hidden');
            $('#your_company_name_settings').addClass('error');
            return false;
         }
         else
         {
            $('#your_company_name_settings').removeClass('error');
            return true;
         }
      }

      function validateStreetAddress(){
         if($('#street_address_settings').val().length == 0)
         {
            $('.header_setting_tab').addClass('hidden');
            $('.company_settings_tab').removeClass('hidden');
            $('#street_address_settings').addClass('error');
            return false;
         }
         else
         {
            $('#street_address_settings').removeClass('error');
            return true;
         }
      }

      function validateCityAddress(){
         if($('#city_settings').val().length == 0)
         {
            $('.header_setting_tab').addClass('hidden');
            $('.company_settings_tab').removeClass('hidden');
            $('#city_settings').addClass('error');
            return false;
         }
         else
         {
            $('#city_settings').removeClass('error');
            return true;
         }
      }


      function validateStateAddress(){
         if($('#state_settings').val().length == 0)
         {
            $('.header_setting_tab').addClass('hidden');
            $('.company_settings_tab').removeClass('hidden');
            $('#state_settings').addClass('error');
            return false;
         }
         else
         {
            $('#state_settings').removeClass('error');
            return true;
         }
      }
      
      /* DATE FUNCTIONS */

            var dateInit = new Date();

            var month=new Array();
            month[0]="January";
            month[1]="February";
            month[2]="March";
            month[3]="April";
            month[4]="May";
            month[5]="June";
            month[6]="July";
            month[7]="August";
            month[8]="September";
            month[9]="October";
            month[10]="November";
            month[11]="December";
            monthName = month[dateInit.getMonth()];
            $('.static_date input[name="invoice_date"]').val(dateInit.getDate() + '-' + monthName + '-' + dateInit.getFullYear());
            
            
            /* LOGO UPLOAD AND UPDATE SCRIPT */

      $('#input_logo').live('change', function()
      {
         $("#preview").html('');
         $("#preview").html('<img src="images/loader.gif" alt="Uploading...."/>');
         $("#logo_upload_form").ajaxForm({
               target: '#preview',
               complete: ''
          }).submit();
      });
      
      
      /* TOGGLE SETTINGS TAB */
      
      $('#settings_header li a').click(function(){
           $('#settings_header li a').parent('li').removeClass('active')
           $(this).parent('li').addClass('active');
           selected_pane = $(this).attr('id');
           $('.header_setting_tab').addClass('hidden');
           $('.' + selected_pane).removeClass('hidden');
           return false;
      })
      
      /* TOGGLE WATERMARK OPTIONS */
      
      function toogleWaterMark(){
         var current_watermark_option = $('#add_watermark').val();
         if(current_watermark_option == 'No')
         {
            $('#watermark_text').addClass('hidden');
            $('#watermark_image').addClass('hidden');
         }
         else if(current_watermark_option == 'Text Watermark')
         {
            $('#watermark_text').removeClass('hidden');
            $('#watermark_image').addClass('hidden');
         }
         else if(current_watermark_option == 'Image Watermark')
         {
            $('#watermark_text').addClass('hidden');
            $('#watermark_image').removeClass('hidden');
         }
      }
      
      function toogleLogoOptions(){
         var show_company_logo = $('#show_company_logo').val();
         if(show_company_logo == 'Yes')
         {
            $('#show_logo_wrapper').removeClass('hidden');
         }
         else
         {
            $('#show_logo_wrapper').addClass('hidden');
         }
      }
      
      function toogleFooterOptions(){
         var footer_option = $('#pdf_footer_add').val();
         if(footer_option == 'Yes')
         {
            $('#pdf_footer_text_wrapper').removeClass('hidden');
         }
         else
         {
            $('#pdf_footer_text_wrapper').addClass('hidden');
         }
      }
      

     $('#show_company_logo').keyup(toogleLogoOptions);
      $('#show_company_logo').keydown(toogleLogoOptions);
      $('#show_company_logo').mouseup(toogleLogoOptions);
      $('#show_company_logo').mousedown(toogleLogoOptions);
      toogleLogoOptions();


      $('#pdf_footer_add').keyup(toogleFooterOptions);
      $('#pdf_footer_add').keydown(toogleFooterOptions);
      $('#pdf_footer_add').mouseup(toogleFooterOptions);
      $('#pdf_footer_add').mousedown(toogleFooterOptions);
      toogleFooterOptions();


      
      $('#add_watermark').keyup(toogleWaterMark);
      $('#add_watermark').keydown(toogleWaterMark);
      $('#add_watermark').mouseup(toogleWaterMark);
      $('#add_watermark').mousedown(toogleWaterMark);
      toogleWaterMark();

      /* WATERMARK UPLOAD SCRIPT */

      $('#input_watermark').live('change', function()
      {
         $("#watermark_preview").html('');
         $("#watermark_preview").html('<img src="images/loader.gif" alt="Uploading...."/>');
         $("#watermark_upload_form").ajaxForm({
               target: '#watermark_preview',
               complete: ''
          }).submit();
      });
      
      /* UPLOAD CLIENT LOGO */

      $('#client_input_logo').live('change', function()
      {
         $("#client_preview").html('');
         $("#client_preview").html('<img src="images/loader.gif" alt="Uploading...."/>');
         $("#client_logo_upload_form").ajaxForm({
               target: '#client_preview',
               complete: ''
          }).submit();
      });
      
      
      
      /* CLIENT PAYING DATE INTERACTION */
      $('#date_suggestion_wrapper h5').click(function(){
         $(this).find('#client_payment_date').focus();
      });
      
      /* SUBMITTING CLIENT DATA */
      
      $('#saving_client').click(function(){
         if($('#client_name').val().length == 0 || $('#client_email_address').val().length == 0 || $('#client_address').val().length == 0 || $('#client_name').val() == 'Client Name [ will be on invoice ]' || $('#client_email_address').val() == 'Client Email Address' || $('#client_address').val() == 'Client address [ will be on invoice ]')
         {
            alert('Give your client some identity, Fill [Name] [Email] [Address]');
         }
         else
         {
            document.create_vcard.submit();
         }
         return false;
      })
      
      if($('#anroid_success').hasClass('loading'))
      {
      }
      else
      {
         $('#anroid_success').show();
         $('.bck_bg').show();
         setTimeout(function(){
            $('#anroid_success').hide();
            $('.bck_bg').hide();
         },3000);
      }
      
      /* CHANGING INVOICE STATUS */
      
      $('.progress').click(function(){
         $(this).closest('.tool_options').find('#invoice_tool_options').toggle();
      });
      
      $('#invoice_tool_options_body li a').click(function(){
         var this_title = $(this).attr('title');
         var this_invoice_status = $(this).find('#this_actual_text').val();
         var primary_id = $('#primary_id').val();
         
         if(this_title == 'Partially Paid')
         {
            $('#amount_paid_invoice').show();
         }
         else
         {
            changeInvoiceStatus(this_invoice_status,primary_id);
         }
         return false;
      });
      
      $('#amount_paid_invoice_partially').keyup(function(e){
         if(e.which == 13)
         {
            var invoice_final_payment_grand_total = $('#formgrandtotal').html();
            if(invoice_final_payment_grand_total.length !== 0)
            {
               getValueOnly = invoice_final_payment_grand_total.match(/([0-9]+)/);
               if(parseInt($(this).val()) > parseInt(getValueOnly))
               {
                  alert('Paid amount cannot be greater than invoice total amount');
               }
               else
               {
                    if($(this).val().length == 0)
                    {
                        alert('Enter some amount');
                    }
                    else
                    {   
                        var this_invoice_status = 'Partially Paid';
                        var primary_id = $('#primary_id').val();
                        changeInvoiceStatus(this_invoice_status,primary_id,$(this).val());
                    }
               }
            }
         }
        else if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
            $(this).val('');
        }
      });
      
      function changeInvoiceStatus(status,primary_id,paid_amount){
         if(paid_amount == undefined) paid_amount = 0;
         
         data = 'new_status=' + status + '&primary_id=' + primary_id + '&paid_amount=' + paid_amount;
         $.post('libs/changeInvoiceStatus.php',data,function(response){
            $('.bck_bg').show();
            template_to_append = '<div id="anroid_success" style="display:block;"><img src="images/loader.gif" />'+response+'</div>';
            $('body').append(template_to_append);
            setTimeout(function(){
               window.location.reload();
            },2000);
         });
      }
      
      
      /* AUTO SUGGEST COMPANY NAME */
      
      function clientAutoSuggest(query){
         data = 'query=' + query;
         $.post('libs/autoSuggest.php',data,function(response){
            $('#client_auto_suggest_body').html(response);
         });
      }
      
      $('#invoice_to').keyup(function(){
         $('#client_auto_suggest').removeClass('hidden');
         clientAutoSuggest($(this).val());
      });
      
      $('#client_auto_suggest_body li').live("click",function(){
         $('#invoice_to').val($(this).find('#auto_suggest_company_name').val());
         $('textarea[name="invoice_to_address"]').val($(this).find('#auto_suggest_client_address').val());
         $('#create_invoice_without_client').val('true');
         $('#client_auto_suggest').addClass('hidden');
      })
      
      
      /* SETTING UP DATEPICER */

    $( "#from" ).datepicker({
               defaultDate: "+1w",
               dateFormat: "yy-mm-dd",
               changeMonth: true,
               numberOfMonths: 3,
               onSelect: function( selectedDate ) {
                   $( "#to" ).datepicker( "option", "minDate", selectedDate );
               }
           });
           $( "#to" ).datepicker({
               defaultDate: "+1w",
               dateFormat: "yy-mm-dd",
               changeMonth: true,
               numberOfMonths: 3,
               onSelect: function( selectedDate ) {
                   $( "#from" ).datepicker( "option", "maxDate", selectedDate );
               }
           });
           
         $('#date_picket_go').click(function(){
            var from = $(this).parent('#date_picker_wrapper').find('#from').val();
            var to = $(this).parent('#date_picker_wrapper').find('#to').val();
            window.location = window.location.pathname + '?start_range=' + from + '&&end_range=' + to;
         })
         
         $('a.datepicker_dropdown').click(function(){
            $('#date_picker_wrapper').toggleClass('hidden');
            return false;
         });
         
         
     /* CREATING USER */
     
     $('#admin_form_register_user').click(function(){
         if(validateAdminFormUsername() && validateAdminFormEmail() && validateAdminFormPassword() && validateAdminFormRePassword())
         {
            register_data = 'register_username=' + $('#admin_form_username').val() + '&register_email=' + $('#admin_form_email').val() + '&register_password=' + $('#admin_form_password').val() + '&user_role=' + $('#admin_form_user_role').val() + '&user_status=' + $('#admin_form_user_login_status').val();

            $.post('libs/register.php',register_data,function(response){
               if(response == 'true' || response == ' true')
               {
                  $('.bck_bg').show();
                  template_to_append = '<div id="anroid_success" style="display:block;"><img src="images/loader.gif" /> User Created Successfully </div>';
                  $('body').append(template_to_append);
                  setTimeout(function(){
                     window.location.reload();
                  },2000);
               }
               else if(response == 'email' || response == ' email')
               {
                  $('.bck_bg').show();
                  template_to_append = '<div id="anroid_success" style="display:block;"><img src="images/loader.gif" /> Activation email has been sent to the user </div>';
                  $('body').append(template_to_append);
                  setTimeout(function(){
                     window.location.reload();
                  },2000);
               }
               else
               {
                  $('#form_wrapper .alert-box').removeClass('hidden').removeClass('success').addClass('alert');
                  $('#form_wrapper .alert-box').html(response);
               }
            });
         }
         return false;
     });
     
     /* EDIT USER CALL */

     $('#admin_form_edit_user').click(function(){
         if(validateAdminFormUsername() && validateAdminFormEmail())
         {
            register_data = 'register_username=' + $('#admin_form_username').val() + '&register_email=' + $('#admin_form_email').val() + '&register_password=' + $('#admin_form_password').val() + '&user_role=' + $('#admin_form_user_role').val() + '&user_status=' + $('#admin_form_user_login_status').val() + '&refrence_id=' + $('#refrence_id').val() + '&refrence_email=' + $('#refrence_email').val();

            $.post('libs/edit_user.php',register_data,function(response){
               if(response == 'true' || response == ' true')
               {
                  $('.bck_bg').show();
                  template_to_append = '<div id="anroid_success" style="display:block;"><img src="images/loader.gif" /> User Edited Successfully </div>';
                  $('body').append(template_to_append);
                  setTimeout(function(){
                     window.location.reload();
                  },2000);
               }
               else
               {
                  $('#form_wrapper .alert-box').removeClass('hidden').removeClass('success').addClass('alert');
                  $('#form_wrapper .alert-box').html(response);
               }
            });
         }
         return false;
     });

     
     function validateAdminFormUsername(){
         if($('#admin_form_username').val().length == 0)
         {
            $('#admin_form_username').addClass('error');
            return false;
         }
         else
         {
            $('#admin_form_username').removeClass('error');
            return true;
         }
     }

     function validateAdminFormEmail(){
         var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
         var this_email = $('#admin_form_email').val();

         if($('#admin_form_email').val().length == 0)
         {
            $('#admin_form_email').addClass('error');
            return false;
         }
         else if(email_regex.test(this_email))
         {
            $('#admin_form_email').removeClass('error');
            return true;
         }
         else
         {
            $('#admin_form_email').addClass('error');
            return false;
         }
     }

     function validateAdminFormPassword(){
         if($('#admin_form_password').val().length == 0)
         {
            $('#admin_form_password').addClass('error');
            return false;
         }
         else
         {
            $('#admin_form_password').removeClass('error');
            return true;
         }
     }

     function validateAdminFormRePassword(){
         if($('#admin_form_re_password').val().length == 0)
         {
            $('#admin_form_re_password').addClass('error');
            return false;
         }
         else
         {  
              if($('#admin_form_re_password').val() !== $('#admin_form_password').val())
              {
                  $('#admin_form_re_password').addClass('error');
                  $('#admin_form_password').addClass('error');
                  return false;
              }
              else
              {
                  $('#admin_form_password').removeClass('error');
                  $('#admin_form_re_password').removeClass('error');
                  return true;
              }
         }
     }
     
     /* SENDING FINAL EMAIL */

      $('#send_final_email').click(function(){
         if(validateEmailSubject() && validateEmailContent())
         {
            document.final_email_form.submit();
              return true;
         }
         else
         {
            return false;
         }
      })

     function validateEmailSubject(){
         if($('#email_subject').val().length == 0)
         {
            $('#email_subject').addClass('error');
            return false;
         }
         else
         {
            $('#email_subject').removeClass('error');
            return true;
         }
     }
     
     function validateEmailContent(){
         if($('#email_content').val().length == 0)
         {
            $('#email_content').addClass('error');
            return false;
         }
         else
         {
            $('#email_content').removeClass('error');
            return true;
         }
     }
     
     /* SAVE EMAIL SETTINGS ADMIN ONLY */

      $('#save_email_settings').click(function(){
           if(validateFinalREmails() && validateRegistrationEmail())
           {
               emailData = 'invoice_emails_from_toggle=' + $('#invoice_emails_from').val() + '&config_company_emails_from=' + $('#final_registration_emails').val() + '&invoice_email_from=' + $('#registration_emails').val();
               $.post('libs/updateEmailSettings.php',emailData,function(response){
                  if(response == 'true' || response == ' true')
                  {
                     $('#email_settings_dialog').find('#settings_body').html('<div id="settings_message"><p>Changes have been saved. Please wait window will reload automatically.<p></div>');
                     setTimeout(function(){
                        window.location.reload();
                     },1000);
                  }
                  else
                  {
                     $('#settings_body').html('<div id="settings_message"><p>'+response+'<p></div>');
                     setTimeout(function(){
                        window.location.reload();
                     },1000);
                  }
               });
           }
      })
     
      function toggleFinalREmails(){
         if($('#invoice_emails_from').val() == 'Custom Email')
         {
            $('#final_action_registration_emails').removeClass('hidden');
         }
         else
         {
            $('#final_action_registration_emails').addClass('hidden');
         }
      }
      
      function validateFinalREmails(){
         if($('#invoice_emails_from').val() == 'Custom Email')
         {
            if($('#final_registration_emails').val().length == 0)
            {
               $('#final_registration_emails').addClass('error');
               return false;
            }
            else
            {
               $('#final_registration_emails').removeClass('error');
               return true;
            }
         }
         else
         {
            return true;
         }
      }
      
      function validateRegistrationEmail(){
         if($('#registration_emails').val().length == 0)
         {
            $('#registration_emails').addClass('error');
            return false;
         }
         else
         {
            $('#registration_emails').removeClass('error');
            return true;
         }
      }

     
     $('#invoice_emails_from').mouseup(toggleFinalREmails);
     $('#invoice_emails_from').mousedown(toggleFinalREmails);
     $('#invoice_emails_from').keyup(toggleFinalREmails);
     $('#invoice_emails_from').keydown(toggleFinalREmails);
      toggleFinalREmails();
});
