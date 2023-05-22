// Menggunakan event listener untuk menangani perubahan pada radio button
var radioButtons = document.querySelectorAll('input[type="radio"][name="jenis_kunjungan"]');
var namaTokoDiv = document.querySelector(".nama-toko-div");
var inputRoutingDiv = document.querySelector(".nama-routing-div");
var pilihNamaToko = document.querySelector(".pilih-nama-toko-div");
var pilihRoutingDiv = document.querySelector(".pilih-nama-routing-div");

// Menambahkan event listener pada setiap radio button
radioButtons.forEach(function(radioButton) {
  radioButton.addEventListener("change", function() {
    if (this.value === "IO") {
      // Jika radio button "IO" terpilih, tampilkan div "Nama Toko"
      namaTokoDiv.style.display = "block";
      inputRoutingDiv.style.display = "block";
      pilihNamaToko.style.display = "none";
      pilihRoutingDiv.style.display = "none";
    } else if (this.value === "R" || this.value === "RO" || this.value === "ROC" || this.value === "STA") {
      // Jika radio button lain terpilih
      namaTokoDiv.style.display = "none";
      inputRoutingDiv.style.display = "none";
      pilihNamaToko.style.display = "block";
      pilihRoutingDiv.style.display = "block";
    }else {
      // Jika radio button lain terpilih, sembunyikan div "Nama Toko"
      namaTokoDiv.style.display = "none";
      inputRoutingDiv.style.display = "none";
      pilihNamaToko.style.display = "none";
      pilihRoutingDiv.style.display = "none";
    }
  });
});
