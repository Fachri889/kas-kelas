<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['L', 'P']);
        $fakerId = fake('id_ID');

        $firstName = $gender === 'L' ? $fakerId->firstNameMale() : $fakerId->firstNameFemale();
        $lastName = $fakerId->lastName();
        $fullName = "{$firstName} {$lastName}";

        $targetKas = 20000;
        $paidWeeks = fake()->numberBetween(0, 4);
        $totalTerbayar = $paidWeeks * 5000;
        $status = ($totalTerbayar >= $targetKas) ? 'lunas' : 'belum_lunas';

        $waliTitle = fake()->randomElement(['Bpk.', 'Ibu']);
        $waliName = $waliTitle === 'Bpk.'
            ? "{$waliTitle} " . $fakerId->firstNameMale() . " {$lastName}"
            : "{$waliTitle} " . $fakerId->firstNameFemale() . " " . $fakerId->lastName();

        $prefixHp = fake()->randomElement(['0812', '0813', '0821', '0852', '0857', '0878', '0896']);
        $noHp = $prefixHp . '-' . fake()->numerify('####-####');

        return [
            'nis' => (string) fake()->unique()->numberBetween(89300, 89999),
            'nama' => $fullName,
            'jenis_kelamin' => $gender,
            'no_hp' => $noHp,
            'nama_wali' => $waliName,
            'kelas' => 'XII MIPA 2',
            'target_kas' => $targetKas,
            'total_terbayar' => $totalTerbayar,
            'status' => $status,
        ];
    }

    public function lunas(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_terbayar' => $attributes['target_kas'] ?? 20000,
            'status' => 'lunas',
        ]);
    }

    public function belumLunas(int $weeksPaid = 2): static
    {
        $total = min(15000, max(0, $weeksPaid * 5000));
        return $this->state(fn (array $attributes) => [
            'total_terbayar' => $total,
            'status' => 'belum_lunas',
        ]);
    }

    public function menunggak(): static
    {
        return $this->state(fn () => [
            'total_terbayar' => 0,
            'status' => 'belum_lunas',
        ]);
    }

    public function withPembayaran(int $tahun = 2024, string $bulan = 'Oktober'): static
    {
        return $this->afterCreating(function (Siswa $siswa) use ($tahun, $bulan) {
            $weeks = (int) ($siswa->total_terbayar / 5000);

            for ($w = 1; $w <= $weeks; $w++) {
                $day = str_pad((string) ($w * 7 - 3), 2, '0', STR_PAD_LEFT);
                $metode = ($w % 3 === 0) ? 'qris' : (($w % 2 === 0) ? 'transfer' : 'tunai');

                Pembayaran::create([
                    'kode_transaksi' => sprintf('TRX-%s-W%d-%s', substr((string) $tahun, -2) . '10', $w, $siswa->nis),
                    'siswa_id' => $siswa->id,
                    'minggu_ke' => $w,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal' => 5000,
                    'tanggal_bayar' => sprintf('%04d-10-%s', $tahun, $day),
                    'metode_pembayaran' => $metode,
                    'status' => 'lunas',
                    'catatan' => "Iuran kas minggu ke-{$w} bulan {$bulan} {$tahun}",
                ]);
            }
        });
    }
}
