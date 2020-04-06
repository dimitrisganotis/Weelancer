$(document).ready(function(){
    $("#form").submit(function(){
        $('#form-btn').css('cursor', "wait");
        document.getElementById("form-btn").disabled = true;
        $('.fa-spin').css('display', "inherit");
    });

    $("a").click(function(){
        $('body').css('cursor', "progress");
    });
});