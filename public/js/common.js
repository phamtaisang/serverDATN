let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
});

var R = {}
// var config = {
//     apiKey: "AIzaSyAP971pw7kzJTTYatF0EkWtbJ9rDcCX2vc",
//     authDomain: "my-project-1500357993095.firebaseapp.com",
//     databaseURL: "https://my-project-1500357993095.firebaseio.com",
//     projectId: "my-project-1500357993095",
//     storageBucket: "my-project-1500357993095.appspot.com",
//     messagingSenderId: "1068180738247"
// };
const config = {
    apiKey: "AIzaSyBtPN8N7_89PI8afj35vkmM6evyKPUpGHI",
    authDomain: "sanghumg-40254.firebaseapp.com",
    projectId: "sanghumg-40254",
    storageBucket: "sanghumg-40254.appspot.com",
    messagingSenderId: "693271265844",
    appId: "1:693271265844:web:2cde270451b3fff1d38061",
    measurementId: "G-6MPW57KK30"
};
R.userName = $('meta[name="user-name"]').attr('content');
R.userId = $('meta[name="user-id"]').attr('content');
R.userAvatar = $('meta[name="user-avatar"]').attr('content');
R.firebase = firebase.initializeApp(config);
R.firebaseDB = R.firebase.database();
R.firebaseMessaging = R.firebase.messaging();

$(function () {
    $(".popup_close").click(function () {
        $("div.popup").css("display", "none");
    });
    $(".popup_opacity").click(function () {
        $("div.popup").css("display", "none");
    });

    $("#btn_search_friend").click(function () {
        let searchText = $("#search_input").val();
        window.location.href = window.location.origin + '/search/friend?search_text='+searchText;
    });

    $("#btn_search_post").click(function () {
        let searchText = $("#search_input").val();
        window.location.href = window.location.origin + '/search/post?search_text='+searchText;
    });

    $("#btn_show_menu").click(function () {
        var displayType = $(".left-menu").css('display');
        if(displayType == 'none') {
            $(".left-menu").css('display', 'block');
        } else {
            $(".left-menu").css('display', 'none');
        }
    });

});
