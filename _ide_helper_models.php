<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Golongan
 *
 * @property int $id
 * @property string $nama
 * @property string|null $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\Parameter> $parameter
 * @property-read int|null $parameter_count
 * @property-read Golongan|null $parent
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\TingkatJabatan> $tingkat
 * @property-read int|null $tingkat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereUpdatedAt($value)
 */
	class Golongan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Jabatan
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Jabatan> $children
 * @property-read int|null $children_count
 * @property-read Jabatan|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan isRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereUpdatedAt($value)
 */
	class Jabatan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KPIFlow
 *
 * @property int $id
 * @property string $nama
 * @property array|null $urutan
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KPIKontrak> $kontrak
 * @property-read int|null $kontrak_count
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIFlow whereUrutan($value)
 */
	class KPIFlow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KPIKontrak
 *
 * @property int $id
 * @property int|null $kpi_flow_id
 * @property string $nama
 * @property string|null $kuantitas
 * @property string|null $keterangan_kuantitas
 * @property string|null $total
 * @property int $komponen_pengurang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KPIFlow|null $flow
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KPIPenilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak query()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereKeteranganKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereKomponenPengurang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereKpiFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereKuantitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIKontrak whereUpdatedAt($value)
 */
	class KPIKontrak extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KPIPenilaian
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $kpi_kontrak_id
 * @property int|null $kpi_periode_id
 * @property string|null $realisasi
 * @property string|null $total_realisasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KPIKontrak|null $kontrak
 * @property-read \App\Models\KPIPeriode|null $periode
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian query()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereKpiKontrakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereKpiPeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereTotalRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPenilaian whereUserId($value)
 */
	class KPIPenilaian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KPIPeriode
 *
 * @property int $id
 * @property string $nama
 * @property string|null $tgl_mulai
 * @property string|null $tgl_selesai
 * @property int|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KPIPenilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode query()
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KPIPeriode whereUpdatedAt($value)
 */
	class KPIPeriode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KategoriPenilaian
 *
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\Parameter> $parameter
 * @property-read int|null $parameter_count
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian query()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriPenilaian whereUpdatedAt($value)
 */
	class KategoriPenilaian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Laporan
 *
 * @property int $id
 * @property int|null $periode_id
 * @property int|null $user_id
 * @property string|null $unverified
 * @property string|null $revision
 * @property string|null $verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Periode|null $periode
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereRevision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereUnverified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereVerified($value)
 */
	class Laporan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Parameter
 *
 * @property int $id
 * @property int|null $golongan_id
 * @property string|null $title
 * @property int $parent_id
 * @property int $order
 * @property string|null $hasil_kerja
 * @property string|null $angka_kredit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $kategori_id
 * @property int $is_active
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Golongan|null $golongan
 * @property-read \App\Models\KategoriPenilaian|null $kategori
 * @property-read \App\Models\Parameter|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\Parameter|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter ordered(string $direction = 'asc')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereAngkaKredit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereGolonganId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereHasilKerja($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereIsActive($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereKategoriId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereOrder($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Parameter withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class Parameter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Penilaian
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $parameter_id
 * @property int|null $periode_id
 * @property string|null $nilai
 * @property string|null $file
 * @property int $approval
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $jumlah
 * @property string|null $leluhur
 * @property string|null $komentar
 * @property \App\Models\KategoriPenilaian|null $kategori
 * @property int|null $kategori_id
 * @property-read \App\Models\Parameter|null $parameter
 * @property-read \App\Models\Periode|null $periode
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian query()
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereKomentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereLeluhur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereUserId($value)
 */
	class Penilaian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Periode
 *
 * @property int $id
 * @property string $nama
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereUpdatedAt($value)
 */
	class Periode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TingkatJabatan
 *
 * @property int $id
 * @property int|null $golongan_id
 * @property string $title
 * @property int $parent_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Golongan|null $golongan
 * @property-read \App\Models\TingkatJabatan|null $parent
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\TingkatJabatan|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\TingkatJabatan[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan ordered(string $direction = 'asc')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereGolonganId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereOrder($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|TingkatJabatan withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class TingkatJabatan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUpdatedAt($value)
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $unit_id
 * @property int|null $golongan_id
 * @property int|null $jabatan_id
 * @property string $name
 * @property string|null $email
 * @property string|null $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $gruop_penilaian
 * @property int|null $tingkat_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Edwink\FilamentUserActivity\Models\UserActivity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Golongan|null $golongan
 * @property-read \App\Models\Jabatan|null $jabatan
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\TingkatJabatan|null $tingkat
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Unit|null $unit
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGolonganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGruopPenilaian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJabatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTingkatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

