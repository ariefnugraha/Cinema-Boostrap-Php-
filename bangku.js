var kursi = "A1 A2 A4";
var hasil = "A6 A4 A5";
var arraykursi = kursi.split(" ");
var arrayhasil = hasil.split(" ");
arraykursi.map(function(lmn,idx){
 if (arrayhasil.indexOf(lmn) > -1){
  alert("ada");
  alert(lmn);
 } else {
 alert("Tidak Ada");
 }
})