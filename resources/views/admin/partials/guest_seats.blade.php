@php
    $columnsPerRow = 20;
    $totalSeats = 500;
    $totalGuests = $guests->count();
    $rows = ceil($totalSeats / $columnsPerRow);

    // Statistik
    $hadir = $guests->where('status', 'hadir')->count();
    $belum = $guests->where('status', 'belum_hadir')->count();
    $kosong = $totalSeats - $totalGuests;
@endphp

{{-- Statistik Tamu --}}
<div class="mb-4 text-center">
    <h1>🎄 Statistik Tamu 🎄</h1>
    <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
        <span class="badge bg-success fs-5">Hadir: {{ $hadir }}</span>
        <span class="badge bg-secondary fs-5">Belum Hadir: {{ $belum }}</span>
        <span class="badge bg-light text-dark fs-5">Kosong: {{ $kosong }}</span>
    </div>
</div>

{{-- Tampilan Kursi --}}
<div class="seat-room">
    @for ($r = 0; $r < $rows; $r++)
        <div class="seat-row d-flex justify-content-between mb-2">
            @for ($c = 0; $c < $columnsPerRow; $c++)
                @php
                    $index = $r * $columnsPerRow + $c;
                    $guest = $guests[$index] ?? null;
                @endphp

                @if ($guest)
                    <div class="seat {{ $guest->status === 'hadir' ? 'seat-hadir' : 'seat-belum' }}"
                        title="{{ $guest->name }} - {{ $guest->instansi ?? '-' }}">
                        <span>{{ \Illuminate\Support\Str::limit($guest->name, 8) }}</span>
                    </div>
                @else
                    <div class="seat seat-empty"></div>
                @endif
            @endfor
        </div>
    @endfor
</div>

<style>
    /* Container kursi */
    .seat-room {
        width: 100%;
    }

    .seat-row {
        display: flex;
        justify-content: space-between; /* kursi melebar kiri-kanan */
        flex-wrap: nowrap;
        margin-bottom: 6px;
    }

    /* Kursi */
    .seat {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-align: center;
        color: #fff;
        cursor: default;
        transition: transform 0.2s;
    }

    .seat:hover {
        transform: scale(1.1);
    }

    .seat-hadir {
        background-color: #28a745; /* hijau */
    }

    .seat-belum {
        background-color: #6c757d; /* abu-abu */
    }

    .seat-empty {
        background-color: #e9ecef;
        border: 2px dashed #ced4da;
        color: #555;
        font-size: 18px;
    }
</style>
