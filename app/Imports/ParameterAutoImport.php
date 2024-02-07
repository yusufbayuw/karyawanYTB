<?php

namespace App\Imports;

use App\Models\Parameter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ParameterAutoImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $unsur = null;
        $subUnsur = null;
        $uraian1 = null;
        $uraian2 = null;
        $uraian3 = null;
        $unsurPrevId = null;
        $subUnsurPrevId = null;
        $uraian1PrevId = null;
        $uraian2PrevId = null;

        foreach ($collection as $key => $row) {
            if ($key === 0) {
                // Skip header row
            } else {
                # code...
                $hasilKerja = $row[5] ?? null;
                $angkaKredit = $row[6] ?? null;
                $golonganId = $row[7] ?? null;
                $kategoriId = $row[8] ?? null;


                if ($hasilKerja !== null && $angkaKredit !== null) {
                    $unsur = $row[0];
                    $subUnsur = $row[1];
                    $uraian1 = $row[2];
                    $uraian2 = $row[3];
                    $uraian3 = $row[4];

                    //jika uraian 3 ada
                    if ($uraian3 !== null && $uraian2 !== null && $uraian1 !== null && $subUnsur !== null && $unsur !== null) {
                        // complete line
                        $uraian3Record = Parameter::create([
                            'title' => $uraian3,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian3Record->parent_id = $uraian2Record->id;
                        $uraian3Record->save();
                        $uraian2PrevId = $uraian2Record->id;

                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                        $uraian1PrevId = $uraian1Record->id;

                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();
                        $subUnsurPrevId = $subUnsurRecord->id;

                        $unsurRecord = Parameter::create([
                            'title' => $unsur,
                            'parent_id' => -1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurRecord->parent_id = $unsurRecord->id;
                        $subUnsurRecord->save();
                        $unsurPrevId = $unsurRecord->id;
                    } elseif ($uraian3 !== null && $uraian2 == null) {
                        $uraian3Record = Parameter::create([
                            'title' => $uraian3,
                            'parent_id' => $uraian2PrevId,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                    } elseif ($uraian3 !== null && $uraian2 !== null && $uraian1 == null) {
                        $uraian3Record = Parameter::create([
                            'title' => $uraian3,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'parent_id' => $uraian1PrevId,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian3Record->parent_id = $uraian2Record->id;
                        $uraian3Record->save();
                        $uraian2PrevId = $uraian2Record->id;
                    } elseif ($uraian3 !== null && $uraian2 !== null && $uraian1 !== null && $subUnsur == null ) {
                        $uraian3Record = Parameter::create([
                            'title' => $uraian3,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2PrevId = $uraian2Record->id;
                        $uraian3Record->parent_id = $uraian2Record->id;
                        $uraian3Record->save();
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'parent_id' => $subUnsurPrevId,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1PrevId = $uraian1Record->id;
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                    } elseif ($uraian3 !== null && $uraian2 !== null && $uraian1 !== null && $subUnsur !== null && $unsur == null) {
                        $uraian3Record = Parameter::create([
                            'title' => $uraian3,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2PrevId = $uraian2Record->id;
                        $uraian3Record->parent_id = $uraian2Record->id;
                        $uraian3Record->save();
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1PrevId = $uraian1Record->id;
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'parent_id' => $unsurPrevId,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurPrevId = $subUnsurRecord->id;
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();
                    }

                    # jika uraian 3 kosong dan uraian 2 ada
                    if ($uraian3 == null && $uraian2 !== null && $uraian1 !== null && $subUnsur !== null && $unsur !== null) {
                        // complete line
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                        $uraian1PrevId = $uraian1Record->id;

                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();
                        $subUnsurPrevId = $subUnsurRecord->id;

                        $unsurRecord = Parameter::create([
                            'title' => $unsur,
                            'parent_id' => -1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurRecord->parent_id = $unsurRecord->id;
                        $subUnsurRecord->save();
                        $unsurPrevId = $unsurRecord->id;
                    } elseif ($uraian3 == null && $uraian2 !== null && $uraian1 == null) {
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'parent_id' => $uraian1PrevId,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                    } elseif ($uraian3 == null && $uraian2 !== null && $uraian1 !== null && $subUnsur == null) {
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'parent_id' => $subUnsurPrevId,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                        $uraian1PrevId = $uraian1Record->id;
                    } elseif ($uraian3 == null && $uraian2 !== null && $uraian1 !== null && $subUnsur !== null && $unsur == null) {
                        $uraian2Record = Parameter::create([
                            'title' => $uraian2,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1PrevId = $uraian1Record->id;
                        $uraian2Record->parent_id = $uraian1Record->id;
                        $uraian2Record->save();
                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'parent_id' => $unsurPrevId,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurPrevId = $subUnsurRecord->id;
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();

                    }

                    // jika uraian 3 kosong, uraian 2 kosong, uraian 1 ada
                    if ($uraian3 == null && $uraian2 == null && $uraian1 !== null && $subUnsur !== null && $unsur !== null) {
                        // complete line
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        
                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();
                        $subUnsurPrevId = $subUnsurRecord->id;

                        $unsurRecord = Parameter::create([
                            'title' => $unsur,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurRecord->parent_id = $unsurRecord->id;
                        $subUnsurRecord->save();
                        $unsurPrevId = $unsurRecord->id;
                    } elseif ($uraian3 == null && $uraian2 == null && $uraian1 !== null && $subUnsur == null) {
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'parent_id' => $subUnsurPrevId,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                    } elseif ($uraian3 == null && $uraian2 == null && $uraian1 !== null && $subUnsur !== null && $unsur == null) {
                        $uraian1Record = Parameter::create([
                            'title' => $uraian1,
                            'hasil_kerja' => $hasilKerja,
                            'angka_kredit' => $angkaKredit,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        
                        $subUnsurRecord = Parameter::create([
                            'title' => $subUnsur,
                            'golongan_id' => $golonganId,
                            'kategori_id' => $kategoriId,
                        ]);
                        $subUnsurPrevId = $subUnsurRecord->id;
                        $uraian1Record->parent_id = $subUnsurRecord->id;
                        $uraian1Record->save();

                        $subUnsurRecord->parent_id = $unsurPrevId;
                        $subUnsurRecord->save();
                    }
                }
            }
        }
    }
}
