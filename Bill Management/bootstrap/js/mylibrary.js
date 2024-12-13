jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}

function alertPopup(msg, delay=8000, colour='yellow')
{
    if($("#alert").length)
    {
        $("#alert").remove();
    }
    $("body").append('<div onclick="gumHoJa();" id="alert" style="z-index:100;color:black; border-radius:3px; background-color:' + colour + '; padding:25px 50px; height:55px; line-height:10px; text-align:center; vertical-align:middle; border: 0 solid black; font-size: 12pt;"> <span id="spanText">'+ msg +'</span></div>');
    // $("#alert").css({'z-index':100, 'position': 'absolute', 'left':15, 'bottom':15, 'box-shadow': '10px 10px 5px #888888' }); //#337ab7
    $("#alert").center();
    $("#alert").css({'z-index':100, 'box-shadow': '10px 10px 5px #888888' }); //#337ab7
    $("#alert").fadeOut(delay);

    if( colour == "red")
    {
        // $("#alert").center();
        $("#alert").css({'box-shadow': '10px 10px 5px grey'});
    }
    
}

function gumHoJa()
{
    $("#alert").remove();
}


jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}


function blankControls()
{
	// to clear all text boxes
	$('input[type=text]').each(function(){ $(this).val(''); });

	// to clear all number boxes
	$('input[type=number]').each(function(){ $(this).val(''); });

    // To Set 1st element in all dropdowns
    $("select").prop('selectedIndex', 0);

    // For labels with class blank
    $("label.blank").text('');

    // For TextArea
    $("textarea").val('');

    // For images
    $('img').attr("src", "");

    // to clear all file inputs
    $('input[type=file]').each(function(){ $(this).val(''); });
}

    $(document).ready(function() {
        $("input[type=number]").click(function() {
           $(this).select();
        });

        ///////// Avoiding ', " and \ in text input
       $('input[type=text]').keypress(function(event) 
       {
            if ( event.which == 39 || event.which == 34 || event.which == 92) 
            {
                event.preventDefault();
                $(this).val($(this).val() + '');
            }
        });

    });

       


function myAlert(arg)
{
	// alert("FFF");
    $( "#dialog" ).text(arg);
	 $( "#dialog" ).dialog({
      title: "PJ",
      modal: true,
      dialogClass: "alert",
	  buttons: [
	    {
	      text: "OK",
	      click: function() {
	        $( this ).dialog( "close" );
	      }
	    }
	  ]
	}); 
}




// Function to Change the Default Date Format
function dateFormat(dt)
{
    var mnth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    return (dt.getDate()<=9?"0"+dt.getDate():dt.getDate()) + "-" + mnth[dt.getMonth()] + "-" + dt.getFullYear();
}


/* Email Validation*/
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
/* END - Email Validation*/




/*--------------- Date validation------------*/
function testDate(dt) {
	// alert(document.getElementById(dt).value);
	// alert(document.getElementById(dt).value);
    var result = isDate(document.getElementById(dt).value);
    return result;
    // console.log(document.getElementById('dateTest').value);
    // console.log(result);
    // $('#result').text(result );
}

//function isDate(txtDate) {
function isDate(currVal) {
	// alert(currVal);

    if (currVal == '') return false;

    //Declare Regex  
    var rxDatePattern = /^(\d{1,2})(\/|-)([a-zA-Z]{3})(\/|-)(\d{4})$/;

    var dtArray = currVal.match(rxDatePattern); // is format OK?
    // alert(dtArray);
    if (dtArray == null) return false;

    var dtDay = parseInt(dtArray[1]);
    var dtMonth = dtArray[3];
    var dtYear = parseInt(dtArray[4]);
    
    // alert(dtDay + " " + dtMonth + "  " + dtYear);
    // alert(dtDay);
    // need to change to lowerCase because switch is
    // case sensitive
    switch (dtMonth.toLowerCase()) {
        case 'jan':
            dtMonth = '01';
            break;
        case 'feb':
            dtMonth = '02';
            break;
        case 'mar':
            dtMonth = '03';
            break;
        case 'apr':
            dtMonth = '04';
            break;
        case 'may':
            dtMonth = '05';
            break;
        case 'jun':
            dtMonth = '06';
            break;
        case 'jul':
            dtMonth = '07';
            break;
        case 'aug':
            dtMonth = '08';
            break;
        case 'sep':
            dtMonth = '09';
            break;
        case 'oct':
            dtMonth = '10';
            break;
        case 'nov':
            dtMonth = '11';
            break;
        case 'dec':
            dtMonth = '12';
            break;
    }

    // // convert date to number
    // dtMonth = parseInt(dtMonth);
    
    // if (isNaN(dtMonth)) return false;
    // else if (dtMonth < 1 || dtMonth > 12) return false;
    // else if (dtDay < 1 || dtDay > 31) return false;
    // else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) return false;
    // else if (dtMonth == 2) {
    //     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
    //     if (dtDay > 29 || (dtDay == 29 && !isleap)) return false;
    // }
    // return true;
    // convert date to number
    dtMonth = parseInt(dtMonth);
    
    if (isNaN(dtMonth)) return false;
    else if (dtMonth < 1 || dtMonth > 12) return false;
    else if (dtDay < 1 || dtDay > 31) return false;
    else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) return false;
    else if (dtMonth == 2) {
        // var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        var isleap = false;
        if (dtYear % 4 == 0 )
        {
            isleap = true;
        }
        // if (dtDay > 29 || (dtDay == 29 && !isleap)) return false;
        if (dtDay > 29 || (dtDay == 29 && isleap == true)) return false;
    }
    return true;
}
/*---------------END Date validation------------*/





//-------------------- Hour Glass 
function ajaxindicatorstart(text)
{
    // if( $("#spanNotification").text().length > -10 ) /// dont show hourGlass in case of notification ajax Call
    // {
    //     return;
    // }
    
    if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
    // var base_url='<?php echo site_url();?>';
    // alert(global_base_url);
    jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src=' + global_base_url + '/bootstrap/images/ajax-loader.gif><div>'+text+'</div></div><div class="bg"></div></div>');
    }

    jQuery('#resultLoading').css({
        'width':'100%',
        'height':'100%',
        'position':'fixed',
        'z-index':'10000000',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto'
    });

    jQuery('#resultLoading .bg').css({
        'background':'#000000',
        'opacity':'0.7',
        'width':'100%',
        'height':'100%',
        'position':'absolute',
        'top':'0'
    });

    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height':'75px',
        'text-align': 'center',
        'position': 'fixed',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto',
        'font-size':'16px',
        'z-index':'10',
        'color':'#ffffff'

    });

    jQuery('#resultLoading .bg').height('100%');
       jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop()
{
    jQuery('#resultLoading .bg').height('100%');
       jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}

jQuery(document).ajaxStart(function () {
    
        //show ajax indicator
        ajaxindicatorstart('loading data... please wait...');
        }).ajaxStop(function () {
        //hide ajax indicator
        ajaxindicatorstop();
    // }
});

//-------------------- Hour Glass 