//MEMASUKKAN PILIHAN KURSI USER KE INPUTAN//
function tes() {
    "use strict";
    var checkbox = document.getElementsByName("seat[]"),
        selected = "",
        n = checkbox.length,
        jumlah = 0,
        showData,
        amount,
        hasil,
        jumlah_orang,
        i, 
        seat;

    for (i = 0; i < n; i = i + 1) {
        if (checkbox[i].checked) {
            selected += checkbox[i].value + " ";
            jumlah = jumlah + 1;
        }
    }

    showData     = selected;
    amount       = jumlah;
    hasil        = document.getElementById("inputan").value = showData;
    jumlah_orang = document.getElementById("jumlah-orang").value = amount;
}
//CEK APAKAH BANGKU USER UDAH DI BOOKING//
function cek() {
    "use strict";
    
    var kursi       = document.getElementById("reserved").innerHTML,
        booking     = document.getElementById("inputan").value,
        arraykursi  = kursi.split(" "),
        arraybooking= booking.split(" "),
        status = false;
    
     arraykursi.map(function(lmn,idx){
         if (arraybooking.indexOf(lmn) > -1){
            window.alert("Maaf Kursi Yang Kamu Pilih Sudah Dipesan. Silahkan Pilih Kursi Yang Lain\n \n Kursi Yang Sudah Dipesan :" + " " + lmn);
         } else {
            document.getElementById("promo").style.display = "block";
         }
     })
    

        
    
    /*
    var kursi          = document.getElementById("reserved").innerHTML,
        arraykursi     = kursi.split(","),
        dobel          = document.getElementById("inputan").value,
        md_split       = dobel.split(","),
        kosong         = 0,
        i              = 0,
        tempat_kosong  = [],
        tempat_terduduk = [];
    
    for (i;i < md_split.length;i++) {
        arraykursi.map(function(lmn,idx) {
            if(lmn == md_split[i]) {
                console.log("TERISI");
                tempat_terduduk.push(md_split[i]);
                kosong++;
            } else {
                tempat_kosong.push(md_split[i]);
            }
        })   
        
          
    }
    
    if(arraykursi.length > 0) {
            alert("Tempat Terisi");
            document.getElementById("promo").style.display = "none";
        } else {
            var promosi = document.getElementById("promo").style.display = "block";
        } 
      */  
} 