@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pembelian</a></div>
                    <div class="breadcrumb-item">Tambah Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form id="myForm"> 
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_supplier">Nama Supplier</label>
                                        <select class="form-control" name="id_supplier" onchange="updateNoFaktur()"
                                            id="nama_supplier">
                                            <option value="">--pilih Supplier--</option>
                                            @foreach ($supplier as $sp)
                                                <option value="{{ $sp->id_supplier }}"
                                                    {{ old('id_supplier') == $sp->id_supplier ? 'selected' : '' }}>
                                                    {{ $sp->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_supplier')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_faktur">No Faktur</label>
                                        <input type="text" name="no_faktur" id="no_faktur" class="form-control"
                                            value="{{ old('no_faktur') }}">
                                            <small id="error-no-faktur" style="color: red; display: none;"></small>
                                        @error('no_faktur')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                        <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                            name="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}">
                                        <small id="error-tanggal-pembelian" style="color: red; display: none;"></small>
                                        @error('tanggal_pembelian')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ongkos_kirim">Ongkos Kirim</label>
                                        <input type="text" name="ongkos_kirim" id="ongkos_kirim" class="form-control"
                                            value="{{ old('ongkos_kirim') }}">
                                        <small id="error-ongkos-kirim" style="color: red; display: none;"></small>
                                        @error('ongkos_kirim')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Button untuk membuka modal daftar obat -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#obatModal" style="margin-right: 10px;">
                                        + Obat
                                    </button>
                                    <button type="reset" class="btn btn-secondary" style="margin-right: 10px;"
                                        data-toggle="modal" data-target="#deleteConfirmationModal">Reset</button>
                                    <button type="submit" class="btn btn-success"
                                        style="margin-right: 10px;">Simpan</button>
                                </div>

                                <div class="col-lg-6">
                                    <!-- Modal -->
                                    <div>
                                        <input type="text" name="total_harga" id="total_harga" class="form-control"
                                            >
                                        <small id="error-total-harga" style="color: red; display: none;"></small>
                                    </div>

                                </div>
                            </div>

                            <hr style="margin-top: 20px; margin-bottom: 20px;">

                            <!-- Tabel Pembelian Obat -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Nama Obat</th>
                                            <th>Satuan</th>
                                            <th>Jumlah Beli</th>
                                            <th>Harga beli per satuan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Margin</th>
                                            <th>No Batch</th>
                                            <th>Harga Jual 1</th>
                                            <th>Harga Jual 2</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="obat-list">
                                        <!-- Data obat yang dipilih dari modal akan ditambahkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus seluruh data obat<span id="deleteObjectName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" data-dismiss="modal"
                        onclick="resetDataObat()">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Dialog Daftar Obat -->
    <div class="modal fade" id="obatModal" tabindex="-1" aria-labelledby="obatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-xxl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="obatModalLabel">Pilih Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="obatForm">
                        <!-- Tabel Daftar Obat -->
                        <div>
                            <table class="table table-bordered table-striped">
                                <!-- Tabel Daftar Obat -->
                                <div class="right">
                                    <form id="searchForm" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search"
                                                id="searchObat" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="fetchDataObat()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Merek Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Deskripsi</th>
                                        <th>Efek Samping</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDataObat">
                                    @foreach ($obat as $ob)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="obat-checkbox"
                                                    data-idobat="{{ $ob->id_obat }}" data-nama="{{ $ob->merek_obat }}"
                                                    data-kategori="{{ $ob->kategoriObat->nama_kategori }}"
                                                    data-satuan="{{ json_encode($ob->satuans) }}"
                                                    data-detail-satuan="{{ json_encode($ob->satuans->flatMap->detailSatuans->pluck('jumlah')) }}">
                                            </td>
                                            <td>{{ $ob->merek_obat }}</td>
                                            <td>{{ $ob->nama_obat }}</td>
                                            <td>{{ $ob->deskripsi_obat }}</td>
                                            <td>{{ $ob->efek_samping }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            onclick="tambahkanObat()">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('js')
        <script>
            document.getElementById('myForm').addEventListener('submit', (event) => {
            event.preventDefault();
            const idobat = document.getElementById('obat-list').querySelectorAll('.idobat');
            const inputKuantitas = document.getElementById('obat-list').querySelectorAll('.jumlah-obat');
            const inputHargaBeli = document.getElementById('obat-list').querySelectorAll('.harga-beli');
            const tanggalExp = document.getElementById('obat-list').querySelectorAll('.tanggal-kadaluarsa');
            const marginterkecil = document.getElementById('obat-list').querySelectorAll('.margin');
            const nobatch = document.getElementById('obat-list').querySelectorAll('.no_batch');
            const hargajual1 = document.getElementById('obat-list').querySelectorAll('.harga_jual1');
            const hargajual2 = document.getElementById('obat-list').querySelectorAll('.harga_jual2');
            const subtotal = document.getElementById('obat-list').querySelectorAll('.total');
            const tanggalpembelian = document.getElementById('tanggal_pembelian');
            const idsupplier = document.getElementById('nama_supplier');
            const ongkir = document.getElementById('ongkos_kirim');
            const nofaktur = document.getElementById('no_faktur');
            const totalharga = document.getElementById('total_harga');
            const tanggal = new Date();
            const tanggalsekarang = tanggal.toLocaleDateString('en-CA');  
            
            
            const errorMessagetanggalpembelian = document.getElementById('error-tanggal-pembelian');
            const errorMessageongkir = document.getElementById('error-ongkos-kirim');
            const errorMessagenfaktur= document.getElementById('error-no-faktur');
            const errorMessagetotalharga = document.getElementById('error-total-harga');

            let isValid = false;
            const dataObat = [];
            const datapembelian = [];


            idobat.forEach((item, index)=>{
                const errorMessagekuantias = document.getElementById(inputKuantitas[index].dataset.error);
                const errorMessagehargabeli = document.getElementById(inputHargaBeli[index].dataset.error);
                const errorMessagetanggalexp = document.getElementById(tanggalExp[index].dataset.error);
                const errorMessagemargin = document.getElementById(marginterkecil[index].dataset.error);
                const errorMessagenobatch = document.getElementById(nobatch[index].dataset.error);
                const errorMessagehargajual1 = document.getElementById(hargajual1[index].dataset.error);
                const errorMessagehargajual2 = document.getElementById(hargajual2[index].dataset.error);
                const errorMessagesubtotal = document.getElementById(subtotal[index].dataset.error);
                const errorMessagekuant = document.getElementById(inputKuantitas[index].dataset.error);

               a = validate(inputKuantitas[index],  inputKuantitas[index].value <= 0,errorMessagekuantias, 'inputan harus diatas 0');
               b = validate(inputHargaBeli[index], inputHargaBeli[index].value <=0,errorMessagehargabeli, 'inputan harus diatas 0');
               c = validate(marginterkecil[index], marginterkecil[index].value <= 0, errorMessagemargin,'inputan harus diatas 0');
               d = validate(hargajual1[index], hargajual1[index].value <=0, errorMessagehargajual1, 'inputan harus diatas 0'); 
               e = validate(tanggalExp[index], tanggalExp[index].value <= tanggalsekarang, errorMessagetanggalexp, 'tanggal harus melebihi tanggal saat ini');  
               f = validate(subtotal[index], subtotal[index].value <= 0, errorMessagesubtotal, 'inputan harus diatas 0');
               g = validateNoBatch(nobatch[index], errorMessagenobatch);
               h = validate(hargajual2[index], hargajual2[index].value <0, errorMessagehargajual2, 'inputan harus diatas 0');
               
             

               if(a && b && c && d && e && e && f && g && h){
                const dataobat = {
                    id_obat: item.value,
                    jumlah: inputKuantitas[index].value,
                    harga_beli: inputHargaBeli[index].value,
                    tanggal_exp: tanggalExp[index].value,
                    margin: marginterkecil[index].value,
                    no_batch: nobatch[index].value,
                    harga_jual1 : hargajual1[index].value,
                    harga_jual2 : hargajual2[index].value,
                    subtotal: subtotal[index].value
                };
                dataObat.push(dataobat);
               }
               
            });
                i = validate(nofaktur, /[^a-zA-Z0-9]/.test(nofaktur.value), errorMessagenfaktur, 'Inputan harus angka huruf atau kombinasi');
                j = validate(ongkir, ongkir.value <= 0,errorMessageongkir, 'inputan harus diatas 0' );
                k = validate(tanggalpembelian, tanggalpembelian.value > tanggalsekarang, errorMessagetanggalpembelian, 'input tanggal pembelian tidak boleh melebihi tanggal sekarang');
                l = validate(totalharga, totalharga.value <= 0, errorMessagetotalharga, 'Inputan harus diatas 0');
            
                if(a && b && c && d && e && f && g && h && i && j && k && l){
                    const pembelian = {
                    id_supplier : 1,
                    tanggal_pembelian: tanggalpembelian.value,
                    ongkos_kirim: ongkir.value,
                    no_faktur: nofaktur.value,
                    total_harga: totalharga.value,
                    obat_list: dataObat
                };
                datapembelian.push(pembelian);
                isValid= true;     
                console.log(datapembelian)  
                }
               
                if(isValid){
                  postData(datapembelian );
                    
                }

        });

        function validateNoBatch(nobatchElement, errorMessageElement) {
            if (nobatchElement.value.trim() === "") {
                return validate(nobatchElement, true, errorMessageElement, 'Inputan wajib diisi');
            } 
            if (nobatchElement.value.length < 5) {
                return validate(nobatchElement, true, errorMessageElement, 'min 5 karakter');
            }
            if (nobatchElement.value.length > 15) {
                return validate(nobatchElement, true, errorMessageElement, 'max 15 karakter');
            }
            if (/[^a-zA-Z0-9]/.test(nobatchElement.value)) {
                return validate(nobatchElement, true, errorMessageElement, 'harus angka huruf / kombinasi');
            }
            return validate(nobatchElement, false, errorMessageElement, ''); // Valid
        }


        async function postData(data){
            try{
                const response = await fetch('{{ route('Pembelian.store') }}', {
                    method: 'POST',
                    headers : {
                         'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        "X-CSRF-Token": document.querySelector('input[name=_token]').value
                    },
                    body : JSON.stringify(data)
                });
                const result = await response.json();
                if(response.ok){
                    console.log(result);
                    if (result.success && result.redirect_url) {
                        window.location.href = result.redirect_url;
                    }
                } else {
                    console.error('Server error: ', result.message);
                    const nofaktur = document.getElementById('no_faktur');
                    const errorMessagenfaktur= document.getElementById('error-no-faktur');
                    validate(nofaktur, true, errorMessagenfaktur, result.message );
                 
                } 
            }
            catch(error){
                console.error(error);
            }
        }
        function validate(element, kondisi,errorMessageElement, errorMessageText){
            if(element.value.trim() === ""){
                errorMessageElement.style.display= 'block';
                errorMessageElement.innerHTML = 'Inputan wajib diisi';
                return false;

            }
            if(kondisi) {
                errorMessageElement.style.display = 'block';
                errorMessageElement.innerHTML = errorMessageText;
                return  false;    
            } else{
                errorMessageElement.style.display = 'none';
                return true;
            }
        }


            function tambahkanObat() {
               
                const selectedObat = document.querySelectorAll('.obat-checkbox:checked');
                const obatList = document.getElementById('obat-list');
                let rowCount = obatList.rows.length;
                console.log(selectedObat);

                selectedObat.forEach((checkbox, index) => {
                    console.log('iiniii', checkbox);
                    console.log('satuan', checkbox.getAttribute('data-satuan'));
                    console.log('Detail Satuan:', checkbox.getAttribute('data-detail-satuan'));
                    const namaObat = checkbox.getAttribute('data-nama');
                    const idobat = checkbox.getAttribute('data-idobat');
                    const hargaBeli = checkbox.getAttribute('data-harga');
                    const satuan = JSON.parse(checkbox.getAttribute('data-satuan').replace(/&quot;/g, '"'));
                    const detailSatuanJumlah = JSON.parse(checkbox.getAttribute('data-detail-satuan'));
                    let satuan_terkecil_1 = 0;
                    let satuan_terkecil_2 = 0;

                    satuan.forEach(satuanItem => {

                        satuan_terkecil_1 = satuanItem.jumlah_satuan_terkecil_1
                        satuanTerbesar = satuanItem.satuan_terbesar;
                    });
                    satuan_terkecil_2 = detailSatuanJumlah[0];

                    // console.log(satuan_terkecil_1)
                    // console.log(satuan_terkecil_2)

                    const newRow = document.createElement('tr');
                    newRow.setAttribute('id', `obat.${rowCount + index + 1}`)
                    newRow.setAttribute('st1', satuan_terkecil_1)
                    newRow.setAttribute('st2', satuan_terkecil_2)
                    newRow.innerHTML = `
                        <td>${rowCount + index + 1}</td>
                        <td><button onclick="hapusItemObat(this)"  class="btn btn-link"><i class="fa-solid fa-trash""></i></button></td>
                        <td>${namaObat}
                            <input type="hidden" name="merek_obat[]" class="idobat" data-error="error-idobat-${ rowCount + index + 1}" value="${idobat}">
                            <small id="error-idobat-${rowCount + index + 1 }" style="color: red; display: none;"></small>
                        </td>
                        <td>${satuanTerbesar} <input type="hidden" name="satuan[]" value="${satuanTerbesar}"></td>
                        <td>
                            <input type="number" name="jumlah_obat[]" class="jumlah-obat" data-error="error-jumlah-${ rowCount + index + 1}" onchange="updateHarga(this)">
                            <small id="error-jumlah-${rowCount + index + 1 }" style="color: red; display: none;"></small>
                        </td>

                        <td>
                            <input type="number" name="harga_beli[]" class="harga-beli" data-error="error-harga-beli-${ rowCount + index + 1}" value="${hargaBeli}"onchange="updateHarga(this)">
                            <small id="error-harga-beli-${rowCount + index + 1 }" style="color: red; display: none;"></small>
                        </td>
                        <td>
                            <input type="date"   name="tanggal_kadaluarsa[]" data-error="error-tanggal-kadaluarsa-${ rowCount + index + 1}" class="tanggal-kadaluarsa">
                            <small id="error-tanggal-kadaluarsa-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        </td>
                        <td>
                            <input type="number" name="margin[]" class="margin" data-error="error-margin-${ rowCount + index + 1}" onchange="updateHarga(this)">
                            <small id="error-margin-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        
                        </td>
                        <td>
                            <input type="text" name="no_batch[]" data-error="error-no-batch-${ rowCount + index + 1}" class="no_batch">
                            <small id="error-no-batch-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        
                        </td>
                        <td>
                            <input type="number" name="harga_jual1[]"  data-error="error-harga-jual1-${ rowCount + index + 1}"  class="harga_jual1">
                            <small id="error-harga-jual1-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        
                        </td>
                        <td>
                            <input type="number" name="harga_jual2[]"  data-error="error-harga-jual2-${ rowCount + index + 1}"  class="harga_jual2">
                            <small id="error-harga-jual2-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        
                        </td>
                        <td>
                            <input type="number" name="total[]" data-error="error-total-${ rowCount + index + 1}" class="total" >
                            <small id="error-total-${rowCount + index + 1 }" style="color: red; display: none;">Jumlah harus positif</small>
                        
                        </td>

                    `;
                    obatList.appendChild(newRow);
                });

                const allCheckboxes = document.querySelectorAll('.obat-checkbox');
                allCheckboxes.forEach((checkbox) => {
                    checkbox.checked = false;

                });

                $('#obatModal').modal('hide'); // Menutup modal
                $('.modal-backdrop').remove(); // Hapus overlay modal yang masih tertinggal

            }

            function hapusItemObat(element) {
                const row = element.closest('tr');
                row.remove();


            }

            function updateHarga() {
                const obatList = document.getElementById('obat-list');

                // Loop melalui setiap baris obat yang ada di tabel
                Array.from(obatList.rows).forEach((row, index) => {
                    // Ambil data harga beli, jumlah beli, dan satuan terkecil obat
                    const hargaBeli = parseFloat(row.cells[5].querySelector('input').value) || 0;
                    const jumlahBeli = parseInt(row.cells[4].querySelector('input').value) || 0;
                    const satuanTerkecil1 = parseInt(row.getAttribute('st1')) || 0; // Satuan terkecil 1
                    const satuanTerkecil2 = parseInt(row.getAttribute('st2')) || 0; // Satuan terkecil 2
                    const margin = parseInt(row.cells[7].querySelector('input').value) || 0;

                    const hargaJual1 = (hargaBeli / satuanTerkecil1) + margin;
                    const hargaJual2 = satuanTerkecil2 > 0 ? ((hargaBeli / satuanTerkecil1) + margin) /
                        satuanTerkecil2 : 0;
                    const total = hargaBeli * jumlahBeli;

                    console.log(satuanTerkecil1)
                    console.log(satuanTerkecil2)
                    const inputHargaJual1 = row.cells[9].querySelector('input');
                    const inputHargaJual2 = row.cells[10].querySelector('input') || 0;
                    const inputTotal = row.cells[11].querySelector('input');

                    inputHargaJual1.value = hargaJual1.toFixed(2);
                    inputHargaJual2.value = hargaJual2.toFixed(2);
                    inputTotal.value = total.toFixed(2);


                });
                totalHarga()
            }


            function totalHarga() {
                const totalElements = document.querySelectorAll(
                    '#obat-list .total');
                const totalHargaInput = document.getElementById('total_harga');

                let grandTotal = 0;
                totalElements.forEach((totalInput) => {
                    const totalValue = parseFloat(totalInput.value) ||
                        0;
                    grandTotal += totalValue;
                });
                console.log('Grand Total: ', grandTotal);
                totalHargaInput.value = grandTotal.toFixed(2);
            }

            function resetDataObat() {
                const obatList = document.getElementById('obat-list');
                obatList.innerHTML = "";
                $('#deleteConfirmationModal').modal('hide')
                $('.modal-backdrop').remove();

            }

            async function fetchDataObat()
            {
                const searchQuery = document.getElementById('searchObat').value;
                const url = "{{ route('search-obat') }}";

                try {

                    const response = await fetch(`${url}?name=${encodeURIComponent(searchQuery)}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);

                    }

                    const data = await response.json();
                    const obats = JSON.stringify(data);

                    const tableDataObat = document.getElementById('tableDataObat');
                    tableDataObat.innerHTML = "";

                    data.forEach(function(obat) {
                    var satuan = obat.satuans[0];
                    const arraySatuan = [satuan]; 
                    var detailsatuan = obat.satuans[0].detail_satuans[0]?.jumlah ?? 0;
                    const encodedSatuan = JSON.stringify(arraySatuan).replace(/"/g, '&quot;');
                    const encodedDetailSatuan = JSON.stringify(detailsatuan);

                    const row = `<tr>
                                    <td><input type="checkbox" class="obat-checkbox" data-idobat="${obat.id_obat}" data-nama="${obat.merek_obat}" data-satuan="${encodedSatuan}" data-detail-satuan="${encodedDetailSatuan}"></td>
                                    <td>${obat.merek_obat}</td>
                                    <td>${obat.nama_obat}</td>
                                    <td>${obat.deskripsi_obat}</td>
                                    <td>${obat.efek_samping}</td>
                                </tr>`;
                    tableDataObat.insertAdjacentHTML('beforeend', row);  
                });

                    console.log(`data : ${data}`);

                } catch (error) {
                    console.error(error);

                }
            }
        </script>
    @endsection
@endpush
