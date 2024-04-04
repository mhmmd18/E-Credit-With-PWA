<div>
    <table class="table table-secondary" id="table">
        <thead>
            <tr style="font-size: 16px;">
                <th>No.</th>
                <th>Name</th>
                @if (!Request::is('logs'))
                    <th>Tangal</th>
                @endif
                <th>Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($catatan as $item)
                <tr>
                    <td style="font-size: 14px;">
                        {{ !Request::is('logs') ? ($catatan->total() - $loop->index - $catatan->firstItem()) + 1 : $loop->iteration }}
                    </td>
                    <td style="font-size: 14px;">{{ $item->customer->name }}</td>
                    @if (!Request::is('logs'))
                        <td style="font-size: 14px;">{{ date('d-m-Y', strtotime($item->customer->created_at)) }}</td>
                    @endif
                    <td style="font-size: 12px;">{{ str_replace(',', '.', number_format($item->credit, 0)) }}</td>
                    <td>
                        @if (Request::is('logs'))
                            <a href="/customers/{{ $item->customer_id }}" class="btn btn-sm btn-success"><i
                                    class="fa-solid fa-eye"></i></a>
                        @endif
                            <a href="/logs/{{ $item->id }}/edit" class="btn btn-sm btn-warning"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a href="/logs/{{ $item->id }}" data-bs-toggle="modal"
                                data-bs-target="#delete-{{ $item->id }}" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan='3' class="fw-bold">{{ request()->is('logs') ? 'Total Pendapatan' : 'Total Cicilan' }}</td>
                <td colspan='2' class="fw-bold">Rp. {{ str_replace(',', '.', number_format($totalCicilan, 0)) }}</td>
            </tr>
        </tbody>
    </table>
    {{ $catatan->links() }}
</div>
{{-- modal hapus --}}
@foreach ($catatan as $item)
    <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLabel">Hapus Catatan</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/logs/{{ $item->id }}" method="post">
                        @csrf
                        @method('delete')
                        <p>Apakah anda ingin menghapus catatan ini?</p>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Hapus</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
