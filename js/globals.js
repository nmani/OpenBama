//$(document).ready(function() {
//    $('#submit').click(function() {
//
//        var msg = $('#comment_text').val();
//        //This random number is a hack for IE.  it caches the url
//        // So you have to trick IE into thinking the url is a new one each time.
//        //In the PHP code, the random number is ignored in the url.
//        var randomnumber=Math.floor(Math.random()*100);
//
//
//        $.post("http://localhost/OpenBama/index.php/bill/add_comment", {
//            comment: msg,
//            bill: '71'
//        }, function() {
//            $('#bill_comments_div').load("http://localhost/OpenBama/index.php/bill/view_comments/71/" + randomnumber);
//            $('#comment_text').val('');
//        });
//    });
//});


function open_bama_toggle(id) {
    var ele = document.getElementById(id);
    if(ele.style.display == "none") {
        ele.style.display = "block";

    }
}

function toggle_visibility(id) {
    var ele = document.getElementById(id);
    if(ele.style.display == "none") {
        ele.style.display = "block";

    }else{
        ele.style.display = "none";
    }
}

function display_tab(displayID){
    var currentDisplayedFieldHidden = document.getElementById('currently_displayed');
    var currentDisplayedField = document.getElementById(currentDisplayedFieldHidden.value);
    var newDisplayedField = document.getElementById(displayID);

    currentDisplayedField.style.display = 'none';

    newDisplayedField.style.display = 'block';

    currentDisplayedFieldHidden.value = displayID;

    var menuDIV = document.getElementById('menu_div');

    menuDIV.className = displayID;

//    alert('Previous Displayed: ' + currentDisplayedField.id);
//    alert('Display Style: ' + currentDisplayedField.style.display);
//    alert('Current Displayed: ' + newDisplayedField.id);
//    alert('Display Style: ' + newDisplayedField.style.display);

}

function toggle_text(e,text1,text2){
    if (document.all){
        if (e.innerText == text1) {
            e.innerText = text2;
        }else{
            e.innerText = text1;
        }
    }else{
        if (e.textContent == text1) {
            e.textContent = text2;
        }else{
            e.textContent = text1;
        }
    }
}

function display_sub_tab(displayID,currentDisplayedID){
    var currentDisplayedFieldHidden = document.getElementById('currently_displayed');
    var currentDisplayedField = document.getElementById(currentDisplayedFieldHidden.value);
    var newDisplayedField = document.getElementById(displayID);

    currentDisplayedField.style.display = 'none';

    newDisplayedField.style.display = 'block';

    currentDisplayedFieldHidden.value = displayID;

    var menuDIV = document.getElementById('menu_div');

    menuDIV.className = currentDisplayedID;

//    alert('Previous Displayed: ' + currentDisplayedField.id);
//    alert('Display Style: ' + currentDisplayedField.style.display);
//    alert('Current Displayed: ' + newDisplayedField.id);
//    alert('Display Style: ' + newDisplayedField.style.display);

}





// Extended Tooltip Javascript
// copyright 9th August 2002, 3rd July 2005, 24th August 2008
// by Stephen Chapman, Felgall Pty Ltd

// permission is granted to use this javascript provided that the below code is not altered
function pw() {
    return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
};
function mouseX(evt) {
    return evt.clientX ? evt.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) : evt.pageX;
}
function mouseY(evt) {
    return evt.clientY ? evt.clientY + (document.documentElement.scrollTop || document.body.scrollTop) : evt.pageY
}
function popUp(evt,oi) {
    if (document.getElementById) {
        var wp = pw(); dm = document.getElementById(oi); ds = dm.style; st = ds.visibility; if (dm.offsetWidth) ew = dm.offsetWidth; else if (dm.clip.width) ew = dm.clip.width; if (st == "visible" || st == "show") {
            ds.visibility = "hidden";
        } else {
            tv = mouseY(evt) + 20; lv = mouseX(evt) - (ew/4); if (lv < 2) lv = 2; else if (lv + ew > wp) lv -= ew/2; lv += 'px';tv += 'px';  ds.left = lv; ds.top = tv; ds.visibility = "visible";
        }
    }
}
