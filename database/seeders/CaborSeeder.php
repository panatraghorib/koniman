<?php

namespace Database\Seeders;

use App\Models\Cabor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabor = [
            "Aerobik",
            "Aeromodelling",
            "Anggar",
            "Angkat Berat",
            "Angkat Besi",
            "Aquatik Renang",
            "Arung Jeram",
            "Atletik",
            "Balap Sepeda",
            "Baseball",
            "Basket 3X3",
            "Basket 5X5",
            "Berkuda",
            "Bermotor",
            "Billiard",
            "Binaraga",
            "Bowling",
            "Bridge",
            "Bulu Tangkis",
            "Catur",
            "Cricket",
            "Danse Sport",
            "Dayung",
            "Futsal",
            "Gantole",
            "Gate Ball",
            "Golf",
            "Gulat",
            "Handball",
            "Hockey Indoor",
            "Hockey Outdoor",
            "Judo",
            "Karate",
            "Kempo",
            "Layar",
            "Loncat Indah",
            "Menembak",
            "Muaythai",
            "Panahan",
            "Panjat Tebing",
            "Paralayang",
            "Pencak Silat",
            "Petanque",
            "Polo Air",
            "Renang",
            "Renang Indah",
            "Renang Ows",
            "Rugby",
            "Selam",
            "Selancar Angin",
            "Selancar Ombak",
            "Senam Aerobik",
            "Senam Artistik",
            "Senam Ritmik",
            "Sepak Bola",
            "Sepak Takraw",
            "Sepatu Roda",
            "Ski Air",
            "Soft Tennis",
            "Softball",
            "Squash",
            "Taekwondo",
            "Tarung Derajat",
            "Tenis",
            "Tenis Meja",
            "Terbang Layang",
            "Terjun Payung",
            "Tinju",
            "Voli Indoor",
            "Voli Pasir",
            "Wood Ball",
            "Wushu",
        ];


        foreach ($cabor as $name) {
            Cabor::create([
                "cabor_name" => $name,
                "initial" => "initial",
                "logo" => "img/default-logo.png",
            ]);
        }
    }
}
