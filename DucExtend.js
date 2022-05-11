function validateEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function validatePhone(number) {
    if (/(0[3|5|7|8|9])+([0-9]{8})\b/.test(number)) {
        return number.replace("0","+84");
    } else if(/(84)+([0-9]{9})\b/.test(number)){
        number = number.replace("+","");
        number = number.replace("84","");
        return "+84"+number;
    } else {
        return false
    }
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        };
        
    }
    return null;
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function getParamByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/ /g, " "));
}

function getATagByURL(text) {
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, function (url) {
        return '<a href="' + url + '">' + url + '</a>';
    })
}

function getYoutubeCode(a) {
    return (a = a.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/)) && 11 == a[7].length ? a[7] : !1 
};


function uploadImage(input, url){
    var file_data = input.prop('files')[0];
	var form = new FormData();
	form.append('image', file_data);

    $.ajax({
		url: url,
		type: 'post',
		timeout: 0,
		processData: false,
		mimeType: "multipart/form-data",
		contentType: false,
		data: form,
		dataType: "json",
		success: function (data) {

		}
	})
}

function numberFormat (nStr, thousands_sep) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');
    }
    return x1 + x2;
}