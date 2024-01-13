<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nama_obat' => $this->nama_obat,
            'jenis_obat' => $this->jenis_obat,
            'kategori_obat' => $this->kategori_obat_id,
            'stok_obat' => $this->stok_obat,
            'harga_obat' => $this->harga_obat,
            'tanggal_masuk' => $this->tanggal_masuk,
            'exp_date' => $this->exp_date,
        ];
    }
}
