$(document).ready(function () {
    // YETKI AKTIF PASIF ISLEMI
    $(".yetkiAktiflik").change(function () {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var data = $(this).prop("checked");

        $.ajax({
            type : "POST",
            url : url,
            data : {
                id : id,
                data : data,
                yetki_guncelle : 1
            },
            success : function (e){
                if (e==1){
                    // BASARILI ISE
                    var conf = confirm("İşleminiz Başarılı");
                    if (conf){
                        location.reload();
                    }
                }else{
                    alert("Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz");
                }
            },
            error : function (e){
                console.log(e);
            }
        });
    });

    //  AKTIF PASIF ISLEMI
    $(".kullaniciAktiflik").change(function () {
        var id = $(this).data("id");
        var url = $(this).data("url");
        var data = $(this).prop("checked");


        $.ajax({
            type : "POST",
            url : url,
            data : {
                id : id,
                data : data,
                kullanici_guncelle : 1
            },
            success : function (e){
                if (e==1){
                    // BASARILI ISE
                    var conf = confirm("İşleminiz Başarılı");
                    if (conf){
                        location.reload();
                    }
                }else{
                    alert("Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz");
                }
            },
            error : function (e){
                console.log(e);
            }
        });
    });
});