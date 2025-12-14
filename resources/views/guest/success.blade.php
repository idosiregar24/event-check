<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            padding-top: 60px;
            color: #2c3e50;
        }

        .container {
            background: #ffffff;
            width: 360px;
            padding: 30px 35px;
            border-radius: 14px;
            border: 1px solid #e4e4e4;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            animation: fadeIn 0.4s ease;
        }

        h2 {
            color: #1abc9c;
            font-weight: 700;
            margin-bottom: 8px;
        }

        p {
            margin: 0;
            margin-bottom: 20px;
            color: #555;
        }

        .btn-download {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            padding: 12px 20px;
            font-size: 15px;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
            box-shadow: 0 3px 10px rgba(39, 174, 96, 0.3);
        }

        .btn-download:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 14px rgba(39, 174, 96, 0.4);
        }

        hr {
            border: none;
            height: 1px;
            background: #e3e3e3;
            margin: 25px 0;
        }

        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #888;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>✓ Registrasi Berhasil</h2>
        <p>Terima kasih, <strong>{{ $guest->name }}</strong>!</p>

        <hr>

        <a href="{{ asset('documents/tata_ibadah.pdf') }}"
           download="Tata-Ibadah.pdf"
           class="btn-download">
            ⤓ Unduh Tata Ibadah
        </a>

        <div class="footer">
            Panitia Natal PMK PCR 2025
        </div>
    </div>

</body>
</html>
