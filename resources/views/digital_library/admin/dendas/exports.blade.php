<table>
    <thead>
        <tr>
            <th colspan="6" style="font-size: 16px; font-weight: bold;">Rekap Denda Keterlambatan - {{ $namaBulan }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($grouped as $tanggal => $dendasHariItu)
            <tr>
                <td colspan="6" style="background-color: #DDDDDD; font-weight: bold;">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </td>
            </tr>
            <tr style="font-weight: bold; background-color: #F5F5F5;">
                <td>No</td>
                <td>Nama Siswa</td>
                <td>Judul Buku</td>
                <td>Hari Terlambat</td>
                <td>Nominal Denda</td>
                <td>Status</td>
            </tr>
            @foreach ($dendasHariItu as $index => $denda)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $denda->transaction->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $denda->transaction->book->judul ?? '-' }}</td>
                    <td>{{ $denda->hari_terlambat }}</td>
                    <td>{{ $denda->nominal }}</td>
                    <td>{{ $denda->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6"></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Tidak ada data denda pada bulan ini.</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="3" style="font-weight: bold; text-align: right;">TOTAL DENDA BULAN INI</td>
            <td></td>
            <td style="font-weight: bold;">
                {{ $grouped->flatten()->sum('nominal') }}
            </td>
            <td></td>
        </tr>
    </tbody>
</table>