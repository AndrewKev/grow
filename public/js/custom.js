// // Menggunakan event listener untuk menangani perubahan pada radio button
let radioButtons = document.querySelectorAll('input[type="radio"][name="jenis_kunjungan"]');
// var namaTokoDiv = document.querySelector(".nama-toko-div");
// var inputRoutingDiv = document.querySelector(".nama-routing-div");
// var pilihNamaToko = document.querySelector(".pilih-nama-toko-div");
// var pilihRoutingDiv = document.querySelector(".pilih-nama-routing-div");

// // Menambahkan event listener pada setiap radio button
radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener("change", function () {
        if (this.value === "IO") {
            // Jika radio button "IO" terpilih, tampilkan div "Nama Toko"
            document.getElementById('formIO').classList.remove('d-none')
            document.getElementById('notFormIO').classList.add('d-none')
        } else {
            // Jika radio button lain terpilih
            document.getElementById('formIO').classList.add('d-none')
            document.getElementById('notFormIO').classList.remove('d-none')
        }
    });
});



// $(document).ready(function () {
//     // $('#datatableSpoClose').DataTable();
//     $('#spoNew').DataTable();
// });
