<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(OrgMember::class)->orderBy('sort_order');
    }

    /**
     * Splits this group's members into presentation tiers so the public
     * Struktur page can render a real hierarchy (Ketua on top, Sekretaris
     * & Bendahara below, then one card per Bidang) instead of one flat
     * grid. Purely derived from each member's free-text `position` field -
     * no extra columns needed, so it works with data admins already typed
     * through the CMS (e.g. "Ketua", "Sekretaris", "Ketua Bidang
     * Kesehatan", "Kader Bidang Kesehatan").
     *
     * Recognized patterns:
     * - Exactly "Ketua"                      -> the group's leader (first match wins)
     * - "Sekretaris" / "Bendahara" / "Wakil Ketua" -> core leadership row
     * - "<Role> Bidang <Name>"                -> grouped under a "<Name>" department card
     * - anything else (e.g. plain "Anggota")  -> flat member list
     *
     * @return array{leader: ?OrgMember, secretariat: \Illuminate\Support\Collection, departments: \Illuminate\Support\Collection, flatMembers: \Illuminate\Support\Collection}
     */
    public function structuredMembers(): array
    {
        $leader = null;
        $secretariat = collect();
        $departments = collect();
        $flatMembers = collect();

        $secretariatRoles = ['sekretaris', 'bendahara', 'wakil ketua'];

        foreach ($this->members as $member) {
            $position = trim((string) $member->position);
            $normalized = mb_strtolower($position);

            if ($normalized === 'ketua' && $leader === null) {
                $leader = $member;

                continue;
            }

            if (in_array($normalized, $secretariatRoles, true)) {
                $secretariat->push($member);

                continue;
            }

            if (preg_match('/^(Ketua|Wakil Ketua|Kader|Anggota)\s+Bidang\s+(.+)$/iu', $position, $matches)) {
                $departmentName = trim($matches[2]);

                if (! $departments->has($departmentName)) {
                    $departments->put($departmentName, collect());
                }

                $departments->get($departmentName)->push((object) [
                    'member' => $member,
                    'role' => ucfirst(mb_strtolower($matches[1])),
                ]);

                continue;
            }

            $flatMembers->push($member);
        }

        return [
            'leader' => $leader,
            'secretariat' => $secretariat,
            'departments' => $departments,
            'flatMembers' => $flatMembers,
        ];
    }
}