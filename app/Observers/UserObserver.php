<?php

namespace App\Observers;

use App\Models\AlternatifKriteria;
use App\Models\LabelKriteria;
use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Bobots;
use App\Models\Normalisasi;
use App\Models\Preferensi;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {   
        $alternatifs = ['Primebiz', 'Karlita Hotel', 'Plaza Hotel', 'Reddorz', 'Grand Dian'];
        $createdAlternatifs = [];
        foreach ($alternatifs as $value) {
            $createdAlternatifs[] = Alternatif::create([
                'a' => $value,
                'user_id' => $user->id,
            ]);
        }

        $krs = [
            ['kategori' => 1, 'c1' => 5, 'c2' => 3, 'c3' => 5, 'c4' => 3, 'c5' => 4],
            ['kategori' => 1, 'c1' => 3, 'c2' => 2, 'c3' => 3, 'c4' => 4, 'c5' => 5],
            ['kategori' => 1, 'c1' => 4, 'c2' => 5, 'c3' => 4, 'c4' => 4, 'c5' => 2],
            ['kategori' => 1, 'c1' => 3, 'c2' => 4, 'c3' => 5, 'c4' => 3, 'c5' => 3],
            ['kategori' => 1, 'c1' => 2, 'c2' => 3, 'c3' => 3, 'c4' => 4, 'c5' => 5],
        ];

        $createdKriterias = [];
        foreach ($createdAlternatifs as $index => $alternatif) {
            $createdKriterias[] = Kriteria::create([
                'user_id' => $user->id,
                'alt_id' => $alternatif->id,
                'kategori' => $krs[$index]['kategori'],
                'c1' => $krs[$index]['c1'],
                'c2' => $krs[$index]['c2'],
                'c3' => $krs[$index]['c3'],
                'c4' => $krs[$index]['c4'],
                'c5' => $krs[$index]['c5'],
            ]);
        }

        $bobots = Bobots::create([
            'b1' => 10,
            'b2' => 20,
            'b3' => 25,
            'b4' => 25,
            'b5' => 20,
            'user_id' => $user->id,
        ]);

        // Step 1: Normalisasi
        $norms = [];
        $sumSquares = ['c1' => 0, 'c2' => 0, 'c3' => 0, 'c4' => 0, 'c5' => 0];

        // Calculate the sum of squares
        foreach ($createdKriterias as $kriteria) {
            $sumSquares['c1'] += pow($kriteria->c1, 2);
            $sumSquares['c2'] += pow($kriteria->c2, 2);
            $sumSquares['c3'] += pow($kriteria->c3, 2);
            $sumSquares['c4'] += pow($kriteria->c4, 2);
            $sumSquares['c5'] += pow($kriteria->c5, 2);
        }

        // Normalisasi
        foreach ($createdKriterias as $kriteria) {
            $norm = [];
            $norm['c1'] = $kriteria->c1 / sqrt($sumSquares['c1']);
            $norm['c2'] = $kriteria->c2 / sqrt($sumSquares['c2']);
            $norm['c3'] = $kriteria->c3 / sqrt($sumSquares['c3']);
            $norm['c4'] = $kriteria->c4 / sqrt($sumSquares['c4']);
            $norm['c5'] = $kriteria->c5 / sqrt($sumSquares['c5']);
            $norms[] = $norm;

            Normalisasi::create([
                'kr_id' => $kriteria->id,
                'c1' => $norm['c1'],
                'c2' => $norm['c2'],
                'c3' => $norm['c3'],
                'c4' => $norm['c4'],
                'c5' => $norm['c5'],
                'user_id' => $user->id,
            ]);
        }

        // Step 2: Normalisasi Terbobot
        $bobot = [
            'c1' => $bobots->b1 / 100,
            'c2' => $bobots->b2 / 100,
            'c3' => $bobots->b3 / 100,
            'c4' => $bobots->b4 / 100,
            'c5' => $bobots->b5 / 100,
        ];

        $terbobots = [];
        foreach ($norms as $norm) {
            $terbobot = [];
            $terbobot['c1'] = $norm['c1'] * $bobot['c1'];
            $terbobot['c2'] = $norm['c2'] * $bobot['c2'];
            $terbobot['c3'] = $norm['c3'] * $bobot['c3'];
            $terbobot['c4'] = $norm['c4'] * $bobot['c4'];
            $terbobot['c5'] = $norm['c5'] * $bobot['c5'];
            $terbobots[] = $terbobot;
        }

        // Step 3: Menentukan A+ dan A-
        $A_plus = [
            'c1' => max(array_column($terbobots, 'c1')),
            'c2' => max(array_column($terbobots, 'c2')),
            'c3' => max(array_column($terbobots, 'c3')),
            'c4' => max(array_column($terbobots, 'c4')),
            'c5' => max(array_column($terbobots, 'c5')),
        ];

        $A_minus = [
            'c1' => min(array_column($terbobots, 'c1')),
            'c2' => min(array_column($terbobots, 'c2')),
            'c3' => min(array_column($terbobots, 'c3')),
            'c4' => min(array_column($terbobots, 'c4')),
            'c5' => min(array_column($terbobots, 'c5')),
        ];

        // Step 4: Menghitung jarak ke solusi ideal positif dan negatif
        $D_plus = [];
        $D_minus = [];
        foreach ($terbobots as $terbobot) {
            $D_plus[] = sqrt(
                pow($A_plus['c1'] - $terbobot['c1'], 2) +
                pow($A_plus['c2'] - $terbobot['c2'], 2) +
                pow($A_plus['c3'] - $terbobot['c3'], 2) +
                pow($A_plus['c4'] - $terbobot['c4'], 2) +
                pow($A_plus['c5'] - $terbobot['c5'], 2)
            );
            $D_minus[] = sqrt(
                pow($terbobot['c1'] - $A_minus['c1'], 2) +
                pow($terbobot['c2'] - $A_minus['c2'], 2) +
                pow($terbobot['c3'] - $A_minus['c3'], 2) +
                pow($terbobot['c4'] - $A_minus['c4'], 2) +
                pow($terbobot['c5'] - $A_minus['c5'], 2)
            );
        }

        // Step 5: Menghitung nilai preferensi untuk setiap alternatif
        $vs = [];
        foreach ($D_plus as $index => $d_plus) {
            $v = $D_minus[$index] / ($D_minus[$index] + $d_plus);
            $vs[] = ['v' => $v];
        }

        // Menyimpan nilai preferensi ke database
        foreach ($createdKriterias as $index => $kriteria) {
            Preferensi::create([
                'kr_id' => $kriteria->id,
                'v' => $vs[$index]['v'],
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}