<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pakta Integritas - {{ $pendaftar->nomor_pendaftaran }}</title>
    <style>
        @page { margin: 1.6cm 1.8cm; }
        body { font-family: 'DejaVu Serif', serif; color: #0f172a; font-size: 11pt; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 12px; margin-bottom: 24px; }
        .header h1 { font-size: 18pt; margin: 0; letter-spacing: 0.15em; text-transform: uppercase; }
        .header p { margin: 4px 0 0; color: #475569; font-size: 9pt; letter-spacing: 0.08em; text-transform: uppercase; }
        .gold { color: #b8860b; }
        .meta { margin-bottom: 16px; font-size: 10pt; color: #475569; }
        .meta strong { color: #0f172a; }
        h2 { font-size: 13pt; margin-top: 18px; margin-bottom: 8px; }
        ol { padding-left: 22px; }
        ol li { margin-bottom: 6px; text-align: justify; }
        .signature-area { margin-top: 36px; }
        .signature-grid { width: 100%; border-collapse: collapse; }
        .signature-cell { padding: 6px 0; vertical-align: top; }
        .signature-line { margin-top: 70px; border-top: 1px solid #0f172a; padding-top: 4px; font-size: 10pt; }
        .stamp { display: inline-block; width: 80px; height: 80px; border: 2px dashed #94a3b8; border-radius: 4px; text-align: center; line-height: 80px; color: #94a3b8; font-size: 9pt; margin-top: 18px; }
        .footer { margin-top: 28px; padding-top: 10px; border-top: 1px solid #cbd5e1; font-size: 8pt; color: #64748b; text-align: center; }
        .ttd-info p { margin: 2px 0; font-size: 10pt; }
    </style>
</head>
<body>
    <div class="header">
        <p><span class="gold">⬩</span> Sistem Penerimaan Murid Baru <span class="gold">⬩</span></p>
        <h1>Pakta Integritas</h1>
        <p>SPMB SMA Negeri Provinsi Sumatera Selatan TA {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <p class="meta">
        Yang bertanda tangan di bawah ini:<br>
        <strong>Nama Lengkap:</strong> {{ $pendaftar->nama_lengkap }}<br>
        <strong>NIK:</strong> {{ $pendaftar->nik }} &nbsp;·&nbsp; <strong>NISN:</strong> {{ $pendaftar->nisn ?? '-' }}<br>
        <strong>Tempat / Tanggal Lahir:</strong> {{ $pendaftar->tempat_lahir }}, {{ optional($pendaftar->tanggal_lahir)->translatedFormat('d F Y') }}<br>
        <strong>Asal Sekolah:</strong> {{ $pendaftar->asal_sekolah }}<br>
        <strong>Sekolah Tujuan:</strong> {{ $pendaftar->sekolah?->nama ?? $pendaftar->sekolah_tujuan }}<br>
        <strong>Jalur Pendaftaran:</strong> {{ ucfirst($pendaftar->jalur_pendaftaran) }}<br>
        <strong>Nomor Pendaftaran:</strong> {{ $pendaftar->nomor_pendaftaran }}
    </p>

    <h2>Dengan ini menyatakan dan berjanji bahwa:</h2>
    <ol>
        <li>Seluruh data dan dokumen yang saya sampaikan dalam pendaftaran SPMB SMA Negeri Provinsi Sumatera Selatan adalah <strong>benar, sah, dan dapat dipertanggungjawabkan</strong>.</li>
        <li>Saya tidak melakukan pemalsuan, manipulasi, atau praktik kecurangan dalam bentuk apapun selama proses pendaftaran maupun seleksi.</li>
        <li>Saya hanya mendaftar pada <strong>satu jalur pendaftaran</strong> dan <strong>satu sekolah tujuan</strong> sesuai ketentuan Juknis Disdik Sumsel.</li>
        <li>Saya bersedia mengikuti seluruh tahapan seleksi sesuai jadwal dan prosedur yang ditetapkan oleh panitia.</li>
        <li>Apabila di kemudian hari ditemukan ketidaksesuaian data atau pelanggaran terhadap pernyataan ini, saya bersedia <strong>didiskualifikasi</strong> dan/atau dicabut status keterimaannya tanpa tuntutan dalam bentuk apapun.</li>
        <li>Saya akan menjaga kerahasiaan akun dan tidak memberikan akses kepada pihak yang tidak berkepentingan.</li>
    </ol>

    <p style="margin-top: 16px;">Demikian pakta integritas ini saya buat dengan sebenar-benarnya, dalam keadaan sadar, tanpa paksaan dari pihak manapun.</p>

    <div class="signature-area">
        <table class="signature-grid">
            <tr>
                <td class="signature-cell" style="width: 60%;"></td>
                <td class="signature-cell ttd-info" style="text-align: left;">
                    <p>{{ $pendaftar->kabupaten_kota ?? 'Palembang' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Yang menyatakan,</p>
                    <span class="stamp">Materai<br>Rp 10.000</span>
                    <div class="signature-line">
                        <strong>{{ $pendaftar->nama_lengkap }}</strong><br>
                        NIK {{ $pendaftar->nik }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dokumen dihasilkan otomatis oleh sistem SPMB · {{ now()->format('d-m-Y H:i') }} · {{ $pendaftar->nomor_pendaftaran }}
    </div>
</body>
</html>
