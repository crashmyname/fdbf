<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel dan Konversi ke DBF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        label {
            font-size: 1.1rem;
            color: #555;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 20px;
            background-color: #fafafa;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload File Excel</h1>
        <form action="<?= base_url()?>/converts" method="POST" enctype="multipart/form-data">
            <?= csrf()?>
            <label for="excelFile">Pilih File Excel:</label>
            <input type="file" name="excelFile" id="excelFile" accept=".xlsx,.xls" required>
            <button type="submit">Upload dan Download DBF</button>
        </form>
        <div class="footer">
            <p>Konversi file Excel ke DBF dengan mudah.</p>
        </div>
    </div>
</body>
</html>

