<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>419 - Halaman Kedaluwarsa</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f1f5f9;color:#0f172a;margin:0;padding:0}
    .wrap{max-width:800px;margin:6rem auto;padding:2rem;text-align:center}
    h1{font-size:58px;color:#64748b;margin:0}
    p{font-size:16px;color:#334155}
    a.button{display:inline-block;margin-top:18px;padding:10px 14px;background:#2563eb;color:#fff;border-radius:6px;text-decoration:none}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>419</h1>
    <p><strong>Halaman Kedaluwarsa</strong></p>
    <p>Permintaan Anda telah kedaluwarsa. Silakan coba lagi dan pastikan token CSRF valid.</p>
    <a class="button" href="{{ url()->previous() ?: route('dashboard') }}">Kembali</a>
  </div>
</body>
</html>