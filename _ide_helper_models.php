<?php

// @formatter:off
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \App\Models\Parameter> $parameter
 * @property-read int|null $parameter_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Golongan whereNama($value)
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
 * App\Models\Parameter
 *
 * @property int $id
 * @property int|null $golongan_id
 * @property string $title
 * @property int $parent_id
 * @property int $order
 * @property string|null $hasil_kerja
 * @property string|null $angka_kredit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Parameter[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Golongan|null $golongan
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
 * @property string $nilai
 * @property string $file
 * @property int $approval
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Penilaian whereParameterId($value)
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereUpdatedAt($value)
 */
	class Periode extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJabatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

