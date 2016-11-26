/**
 * Created by TP on 11/19/2016.
 */
var baseurl = window.location.origin+'/shopping/frontend/web/';


$(window).load (function(){
    $('#do_action_tp').hide();
    $('#show_tp').hide();

    $('#name_mua').hide();
    $('#name_nhan').hide();
    $('#phone_mua').hide();
    $('#dc_mua').hide();
    $('#email_nhan').hide();
    $('#email_mua').hide();
    $('#phone_nhan').hide();
    $('#dc_nhan').hide();
    $('#validate_phone_nhan').hide();
    $('#validate_phone_mua').hide();
    $('#validate_email_mua').hide();
    $('#validate_email_nhan').hide();
    $('#c_validate').hide();
    $('#old_pass').hide();
    $('#confirm_pass').hide();
    $('#old_pass_input').hide();
    $('#confirm_pass_input').hide();
    $('#new_pass_input').hide();
});

jQuery(document).ready(function(){
    $('#checked').bind('change',function(){
        if($(this).is(':checked')){
            $("#fullName").val($("#full_name").val());
            $("#userEmail").val($("#user_email").val());
            $("#userPhone").val($("#user_phone").val());
            $("#userAdress").val($("#user_adress").val());
        }
        else
        {
            $("#fullName").val("");
            $("#userEmail").val("");
            $("#userPhone").val("");
            $("#userAdress").val("");
        }
    });
});

$(document).ready(function(){
    $('#user_old_pass').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#old_pass_input').show();
            $(this).focus();
        }else{
            $('#old_pass_input').hide();
            var old = $(this).val();
            $.ajax({
                type: "POST",
                url: baseurl+'site/check-pass',
                data: {
                    old:old
                },
                success: function(data) {
                    var rs = JSON.parse(data);
                    if (!rs['success']) {
                        $('#old_pass').show();
                    }else{
                        $('#old_pass').hide();
                    }
                }
            });
        }
    });
    $('#user_new_pass').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#new_pass_input').show();
            $(this).focus();
        }else{
            $('#new_pass_input').hide();
        }
    });
    $('#user_confirm_pass').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#confirm_pass_input').show();
            $(this).focus();
        }else{
            $('#confirm_pass_input').hide();
            var str1 = $(this).val();
            var str2 = $('#user_new_pass').val();
            var n = str1.localeCompare(str2);
            if(n !=0 ){
                $('#confirm_pass').show();
            }else{
                $('#confirm_pass').hide();
            }
        }
    });
    $('#fullName').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#name_nhan').show();
            $(this).focus();
        }else{
            $('#name_nhan').hide();
        }
    });
    $('#userEmail').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#email_nhan').show();
            $(this).focus();
        }else{
            $('#email_nhan').hide();
            if(IsEmail($(this).val())==false){
                $('#validate_email_nhan').show();
            }else{
                $('#validate_email_nhan').hide();
            }
        }
    });
    $('#userPhone').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#phone_nhan').show();
            $(this).focus();
        }else{
            $('#phone_nhan').hide();
            if(validatePhone($(this).val())==false){
                $('#validate_phone_nhan').show();
            }else{
                $('#validate_phone_nhan').hide();
            }
        }
    });
    $('#userAdress').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#dc_nhan').show();
            $(this).focus();
        }else{
            $('#dc_nhan').hide();
        }
    });
    $('#full_name').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#name_mua').show();
            $(this).focus();
        }else{
            $('#name_mua').hide();
        }
    });
    $('#user_email').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#email_mua').show();
            $(this).focus();
        }else{
            $('#email_mua').hide();
            if(IsEmail($(this).val())==false){
                $('#validate_email_mua').show();
            }else{
                $('#validate_email_mua').hide();
            }
        }
    });
    $('#user_phone').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#phone_mua').show();
            $(this).focus();
        }else{
            $('#phone_mua').hide();
            if(validatePhone($(this).val())==false){
                $('#validate_phone_mua').show();
            }else{
                $('#validate_phone_mua').hide();
            }
        }
    });
    $('#user_adress').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#dc_mua').show();
            $(this).focus();
        }else{
            $('#dc_mua').hide();
        }
    });

    $('#btn_pass').click(function(){
        var pass = $('#user_new_pass').val();
        $.ajax({
            type: "POST",
            url: baseurl+'user/change-password',
            data: {
                pass:pass,
            },
            success: function(data) {
                var rs = JSON.parse(data);
                if (rs['success']) {
                    location.href= baseurl+'user/info';
                }else {
                    location.href= baseurl+'user/change-password';
                }
            }
        });
    });

    $('#btn').click(function(){
        if($('#fullName').val().trim() == "" || $('#userEmail').val().trim() == "" || $('#userPhone').val().trim() == "" || $('#userAdress').val().trim() == "" || $('#full_name').val().trim() == "" || $('#user_email').val().trim() == "" || $('#user_adress').val().trim() == "" || $('#user_phone').val().trim() == "")
        {
            $('#c_validate').show();
        }else{
            var fullName = $('#fullName').val();
            var userEmail = $('#userEmail').val();
            var userPhone = $('#userPhone').val();
            var userAdress = $('#userAdress').val();
            var full_name = $('#full_name').val();
            var user_email = $('#user_email').val();
            var user_adress = $('#user_adress').val();
            var user_phone = $('#user_phone').val();
            var message = $('#message').val();
            $.ajax({
                type: "POST",
                url: baseurl+'shopping-cart/save-buy',
                data: {
                    fullName:fullName,
                    userEmail:userEmail,
                    userPhone:userPhone,
                    userAdress:userAdress,
                    full_name:full_name,
                    user_email:user_email,
                    user_adress:user_adress,
                    user_phone:user_phone,
                    message:message
                },
                success: function(data) {
                    var rs = JSON.parse(data);
                    if (rs['success']) {
                        alert(rs['message']);
                        location.href= baseurl+'site/index';
                    }else {
                        alert(rs['message']);
                    }
                }
            });
        }
    });
});

function getSearch(){
    key = $("#key_search" ).val();
    window.location.href=baseurl+'product/search?key='+key;
}

function validatePhone(txtPhone) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (!filter.test(txtPhone)) {
        return false;
    }else {
        return true;
    }
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}

function addCart(id){
    price = $("#product_price").text();
    $("#price_product").text(price);
    name = $("#product_name").text();
    $("#name_product").text(name);
    imgSource = $("#product_image").attr("src");
    $("#image_product").attr({
        "src":imgSource
    });
    $.get(baseurl +'shopping-cart/add-cart',{'id' :id},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        alert('Đã thêm sản phẩm vào giỏ hàng thành công');
        $('#modal_show').modal('show');
    });
}

function updateCart(id){
    //alert(id);
    amount = $("#amount_" + id).val();
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount},function(data){
        val = data.split("<pre>");
        if(val[1] == 0){
            if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
                $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
                    val = data.split("<pre>");
                    $("#amount").text(val[1]);
                    window.location.href=baseurl+'shopping-cart/list-my-cart';
                });
            }
        }else{
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        }
    });
}


function subtraction(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount)-Number(1);
    if(amount_new == 0){
        if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
            $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
                val = data.split("<pre>");
                $("#amount").text(val[1]);
                window.location.href=baseurl+'shopping-cart/list-my-cart';
            });
        }else{
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        }
    }else{
        $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        });
    }
}

function addition(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        window.location.href=baseurl+'shopping-cart/list-my-cart';
    });
}

function delCart(id){
    if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
        $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        });
    }
}

function inPutInfo(){
    $.get(baseurl +'site/check-user',function(data){
        if(data == 1){
            alert('Bạn phải đăng nhập để thanh toán đơn hàng');
            window.location.href=baseurl+'site/login';
        }else{
            $('#do_action_tp').show( "slow");
            $('#show_tp').show( "slow");
        }
    });
}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '860437614060495',
        xfbml      : true,
        version    : 'v2.6'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

