@extends('layouts.app')

@section('title', 'Supplier Baru')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Satuan </h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Detail Satuan</a></div>
                    <div class="breadcrumb-item">Detail Satuan</div>

                </div>
            </div>
            <div class="section-body">
                <div class="card">

                    <form href={{ route('store-detailsatuan', $id_obat) }} method="POST">
                        @csrf

                        <div class="card-body">
                            <!-- Input satuan terkecil -->
                            <div class="form-group">
                                <label for="satuan_terkecil">Satuan Terkecil</label>
                                <select name="satuan_terkecil" id="satuan_terkecil" class="form-control" required>
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($satuan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div id="detail-container" class="row g-3">
                                <!-- Detail inputs will be added here -->
                            </div>

                            <!-- Button to add new detail -->

                            <hr>
                            <button type="button" class="btn btn-primary"onclick="addDetail()">Tambah Detail</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-danger " onclick="removeLastDetail()">Hapus Item </button>

                        </div>
                    </form>



                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    @section('js')
    @endsection
@endpush

<script>
    const satuanOptions = @json($satuan);
    let detailCount = 0;

    function addDetail() {
        detailCount++;

        // Container untuk setiap row detail
        const detailContainer = document.createElement('div');
        detailContainer.classList.add('card-body', 'detail-item', 'w-100');
        detailContainer.style.display = 'block'; // Pastikan tampil vertikal
        detailContainer.id = `detail-${detailCount}`;

        // Membuat dropdown satuan berdasarkan satuanOptions
        const satuanDropdown = `
        <div class="form-group">
            <label for="nama_satuan_${detailCount}">Satuan Ke-${getDetailNumber()}</label>
            <select name="nama_satuan[]" id="nama_satuan_${detailCount}" class="form-control" required>
                <option value="">Pilih Satuan</option>
                ${satuanOptions.map(satuan => `<option value="${satuan.id}">${satuan.nama_satuan}</option>`).join('')}
            </select>
        </div>
    `;

        // Label dan input konversi
        const konversiInput = `
        <div class="form-group">
            <label for="konversi_${detailCount}">Konversi ke Satuan Terkecil</label>
            <input type="number" name="konversi[]" id="konversi_${detailCount}" class="form-control" required>
        </div>
    `;

        // Gabungkan semua elemen ke dalam container detail
        detailContainer.innerHTML = satuanDropdown + konversiInput;

        // Tambahkan detailContainer ke dalam detail-container
        document.getElementById('detail-container').appendChild(detailContainer);

        // Tambahkan <hr> sebagai pemisah antar item
        const separator = document.createElement('hr');
        document.getElementById('detail-container').appendChild(separator);
    }


    function removeLastDetail() {
        const detailItems = document.querySelectorAll('.detail-item');
        if (detailItems.length > 0) {
            // Hapus elemen terakhir dan pemisahnya <hr>
            detailItems[detailItems.length - 1].remove();
            const hrSeparators = document.querySelectorAll('#detail-container hr');
            if (hrSeparators.length > 0) {
                hrSeparators[hrSeparators.length - 1].remove();
            }
            // Update ulang nomor urutan setelah penghapusan
            updateDetailLabels();
        }
    }

    function updateDetailLabels() {
        const detailItems = document.querySelectorAll('.detail-item');
        detailItems.forEach((item, index) => {
            const label = item.querySelector('label');
            if (label) {
                label.innerText = `Satuan Ke-${index + 1}`;
            }
        });
    }

    function getDetailNumber() {
        const detailItems = document.querySelectorAll('.detail-item');
        return detailItems.length + 1;
    }
</script>
