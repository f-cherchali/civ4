import {base_url} from './const.js';
$(document).ready(function(){
    $("#rememberform").on("submit",function(e){
        e.preventDefault();
        $(".alert").removeClass("alert-danger success-danger");
        $(".alert").empty();
        var iconLoadButton = '<i class="fa fa-spinner fa-spin"></i> Veuillez patienter';
        var initialSubmitButton = $("button[type='submit']").html();
        $("button[type='submit']").html(iconLoadButton);
        $("button[type='submit']").prop("disabled",true);
        var email = $("input[name='email']").val();
        $.ajax({
            type:'POST',
            url:base_url+'admin/login/doremember',
            dataType:'text',
            data:{  
                email:email,
            },success : function(resp){
                var response = JSON.parse(resp);
                $("button[type='submit']").html(initialSubmitButton);
                $("button[type='submit']").prop("disabled",false);
                if(response.status){
                    $(".alert").addClass("alert-success");
                    $("button[type='submit']").prop("disabled",true);
                    $(".alert").html("Si votre existe bien, vous allez recevoir dans quelques minutes un lien de redéfinition de votre mot de passe par email");
                }else{
                    $(".alert").addClass("alert-danger");
                    $("button[type='submit']").prop("disabled",false);
                    var errors = "";
                    $.each(response.message,function(key,value){
                        errors+=value+"<br>";
                    });
                    $(".alert").html(errors);
                }
            },error : function(error){
                $("button[type='submit']").html(initialSubmitButton);
                $("button[type='submit']").prop("disabled",false);
                $(".alert").addClass("alert-danger");
                $(".alert").html("Une érreur est survenue");
            }
        });
        return false;
    });
});