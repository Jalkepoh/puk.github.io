<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Cetak</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Form Cetak</h2>
    <form id="formCetak">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
        <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" readonly>
      </div>
      <div class="mb-4">
        <label for="date" class="block text-gray-700 font-bold mb-2">Tanggal:</label>
        <input type="date" id="date" name="date" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>" readonly>
      </div>
      <div class="mb-4">
        <label for="amount" class="block text-gray-700 font-bold mb-2">Nominal:</label>
        <input type="number" id="amount" name="amount" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="<?php echo isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : ''; ?>" readonly>
      </div>
      <div class="mb-4">
        <label for="paymentMethod" class="block text-gray-700 font-bold mb-2">Pembayaran:</label>
        <input type="text" id="paymentMethod" name="paymentMethod" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="<?php echo isset($_GET['paymentMethod']) ? htmlspecialchars($_GET['paymentMethod']) : ''; ?>" readonly>
      </div>
    </form>
    <button id="cetakPDF" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700">Cetak PDF</button>
  </div>

  <!-- Script jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    document.getElementById('cetakPDF').addEventListener('click', async function() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      const name = document.getElementById('name').value;
      const date = document.getElementById('date').value;
      const amount = document.getElementById('amount').value;
      const paymentMethod = document.getElementById('paymentMethod').value;

      // Gambar yang ingin dimasukkan ke PDF
      const imgUrl = 'TTDSTEMPEL.png'; // Ganti dengan path ke gambar
      const imgData = await getBase64Image(imgUrl);

      // Menambahkan teks
      doc.text("Tanda Terima Pembayaran", 20, 20);
      doc.text(`Nama: ${name}`, 20, 30);
      doc.text(`Tanggal: ${date}`, 20, 40);
      doc.text(`Nominal: ${amount}`, 20, 50);
      doc.text(`Pembayaran: ${paymentMethod}`, 20, 60);
      
      // Menambahkan gambar ke PDF
      doc.addImage(imgData, 'PNG', 20, 70, 150, 50); // Ukuran gambar dapat disesuaikan

      doc.save("form-pembayaran.pdf");
    });

    // Fungsi untuk mendapatkan gambar dalam format base64
    function getBase64Image(imgUrl) {
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = 'Anonymous'; // Pastikan untuk mengizinkan CORS
        img.onload = function() {
          const canvas = document.createElement('canvas');
          canvas.width = img.width;
          canvas.height = img.height;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0);
          const dataURL = canvas.toDataURL('image/png');
          resolve(dataURL);
        };
        img.onerror = function() {
          reject(new Error('Error loading image'));
        };
        img.src = imgUrl;
      });
    }
  </script>
</body>
</html>
