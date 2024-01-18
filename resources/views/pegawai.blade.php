<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Data Pegawai</h1>
        <a href="{{ route('pegawai.create') }}" class="btn btn-md btn-success mb-3">TAMBAH PEGAWAI</a>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Foto</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No.Telpon</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $nomor = 1;    
                @endphp
                @forelse ($pegawais as $pegawai)
                <tr>
                    <th scope="row">{{ $nomor++ }}</th>
                    <td>
                        <img src="{{ asset('/storage/pegawai/'.$pegawai->foto ) }}" class="rounded" style="width: 150px">
                    </td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>0{{ $pegawai->notelpon}}</td>
                    <td class="text-center">
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST">
                            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                        </form>
                    </td>
                  </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Pegawai Belum Tersedia
                    </div>
                @endforelse
            </tbody>
          </table>
          {{ $pegawais->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}', 'BERHASIL');
        
        @elseif(session()->has('error'))
            toastr.error();('{{ session('error')}}', 'GAGAL!');

        @endif
    </script>
</body>
</html>