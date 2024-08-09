<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Input</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Input Pembayaran</h2>
    <form id="paymentForm">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
        <input type="text" id="name" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" required>
      </div>
      <div class="mb-4">
        <label for="date" class="block text-gray-700 font-bold mb-2">Tanggal:</label>
        <input type="date" id="date" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" required>
      </div>
      <div class="mb-4">
        <label for="amount" class="block text-gray-700 font-bold mb-2">Nominal:</label>
        <input type="number" id="amount" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" required>
      </div>
      <div class="mb-4">
        <label for="paymentMethod" class="block text-gray-700 font-bold mb-2">Pembayaran:</label>
        <input type="text" id="paymentMethod" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" required>
      </div>
      <div class="mb-4">
        <label for="paymentUpload" class="block text-gray-700 font-bold mb-2">Upload Pembayaran:</label>
        <input type="file" id="paymentUpload" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300" required>
      </div>
      <div class="flex justify-end">
        <button type="button" id="simpanButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
  
  <div class="max-w-4xl mx-auto mt-6">
    <table class="min-w-full bg-white border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border px-4 py-2">Nama</th>
          <th class="border px-4 py-2">Tanggal</th>
          <th class="border px-4 py-2">Nominal</th>
          <th class="border px-4 py-2">Pembayaran</th>
          <th class="border px-4 py-2">Upload Pembayaran</th>
          <th class="border px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody id="paymentsTable">
        <!-- Data akan ditambahkan di sini -->
      </tbody>
    </table>
    <div class="flex justify-end mt-4">
      <button id="downloadExcel" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">Download Excel</button>
    </div>
  </div>
  
  <script>
    document.getElementById('simpanButton').addEventListener('click', function() {
      addPayment();
    });

    document.getElementById('downloadExcel').addEventListener('click', function() {
      downloadExcel();
    });

    function addPayment() {
      const name = document.getElementById('name').value;
      const date = document.getElementById('date').value;
      const amount = document.getElementById('amount').value;
      const paymentMethod = document.getElementById('paymentMethod').value;
      const paymentUpload = document.getElementById('paymentUpload').files[0] ? document.getElementById('paymentUpload').files[0].name : '';

      if (name && date && amount && paymentMethod && paymentUpload) {
        const table = document.getElementById('paymentsTable');
        const newRow = table.insertRow();

        // Encode data for URL
        const encodedName = encodeURIComponent(name);
        const encodedDate = encodeURIComponent(date);
        const encodedAmount = encodeURIComponent(amount);
        const encodedPaymentMethod = encodeURIComponent(paymentMethod);
        const encodedPaymentUpload = encodeURIComponent(paymentUpload);

        newRow.innerHTML = `
          <td class="border px-4 py-2">${name}</td>
          <td class="border px-4 py-2">${date}</td>
          <td class="border px-4 py-2">${amount}</td>
          <td class="border px-4 py-2">${paymentMethod}</td>
          <td class="border px-4 py-2">${paymentUpload}</td>
          <td class="border px-4 py-2">
            <a href="form.php?name=${encodedName}&date=${encodedDate}&amount=${encodedAmount}&paymentMethod=${encodedPaymentMethod}&paymentUpload=${encodedPaymentUpload}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">Cetak</a>
          </td>
        `;

        // Reset form
        document.getElementById('paymentForm').reset();
      } else {
        alert('Mohon lengkapi semua kolom.');
      }
    }

    function downloadExcel() {
      const table = document.getElementById('paymentsTable');
      const wb = XLSX.utils.table_to_book(table, { sheet: "Payments" });
      XLSX.writeFile(wb, "payments.xlsx");
    }
  </script>
</body>
</html>
