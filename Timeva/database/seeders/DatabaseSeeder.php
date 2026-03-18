<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profil;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== COMPTE UTILISATEUR =====
        $user = User::firstOrCreate(
            ['email' => 'client@timeva.com'],
            [
                'nom'      => 'Dupont',
                'prenom'   => 'Marie',
                'password' => Hash::make('Client@2024'),
            ]
        );
        Profil::firstOrCreate(
            ['user_id' => $user->id],
            [
                'id'     => (string) Str::uuid(),
                'prenom' => 'Marie',
                'nom'    => 'Dupont',
                'role'   => 'client',
            ]
        );

        // ===== COMPTE ADMIN =====
        $admin = User::firstOrCreate(
            ['email' => 'admin@timeva.com'],
            [
                'nom'      => 'Admin',
                'prenom'   => 'TIMEVA',
                'password' => Hash::make('Admin@2024!'),
            ]
        );
        Profil::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'id'     => (string) Str::uuid(),
                'prenom' => 'TIMEVA',
                'nom'    => 'Admin',
                'role'   => 'admin',
            ]
        );

        // ===== 20 MONTRES =====
        $montres = [
            ['name' => 'Chrono Elite Pro',      'brand' => 'LuxeTime',   'prix' => 185000, 'colors' => ['Noir', 'Argent']],
            ['name' => 'Royal Automatique',     'brand' => 'Regalia',    'prix' => 320000, 'colors' => ['Or', 'Noir']],
            ['name' => 'Sport Titanium X',      'brand' => 'SpeedGear',  'prix' => 95000,  'colors' => ['Gris', 'Bleu']],
            ['name' => 'Classique Heritage',    'brand' => 'Méridian',   'prix' => 145000, 'colors' => ['Brun', 'Noir']],
            ['name' => 'Diver 300M Pro',        'brand' => 'AquaForce',  'prix' => 210000, 'colors' => ['Bleu', 'Noir', 'Vert']],
            ['name' => 'Skeleton Vision',       'brand' => 'Artcraft',   'prix' => 275000, 'colors' => ['Argent', 'Or rose']],
            ['name' => 'Pilot Altimeter',       'brand' => 'AeroWatch',  'prix' => 165000, 'colors' => ['Noir', 'Kaki']],
            ['name' => 'Moonphase Prestige',    'brand' => 'Luminel',    'prix' => 395000, 'colors' => ['Bleu nuit', 'Noir']],
            ['name' => 'Dress Gold 36mm',       'brand' => 'EleganceCo', 'prix' => 230000, 'colors' => ['Or', 'Or rose']],
            ['name' => 'GMT Voyager',            'brand' => 'TravelPro',  'prix' => 285000, 'colors' => ['Bleu', 'Noir', 'Vert']],
            ['name' => 'Racing Chronograph',    'brand' => 'SpeedGear',  'prix' => 120000, 'colors' => ['Rouge', 'Noir']],
            ['name' => 'Vintage Retro 1960',    'brand' => 'OldCraft',   'prix' => 175000, 'colors' => ['Crème', 'Bleu']],
            ['name' => 'Smart Hybrid Connect',  'brand' => 'TechWear',   'prix' => 85000,  'colors' => ['Noir', 'Blanc']],
            ['name' => 'Ultra Slim 5mm',        'brand' => 'Méridian',   'prix' => 195000, 'colors' => ['Argent', 'Or']],
            ['name' => 'Tourbillon Master',     'brand' => 'Regalia',    'prix' => 750000, 'colors' => ['Or', 'Platine']],
            ['name' => 'Field Watch Canvas',    'brand' => 'OutdoorCo',  'prix' => 65000,  'colors' => ['Kaki', 'Sable', 'Noir']],
            ['name' => 'Bicolor Prestige',      'brand' => 'EleganceCo', 'prix' => 250000, 'colors' => ['Or/Acier', 'Or rose/Acier']],
            ['name' => 'Carbon Phantom',        'brand' => 'SpeedGear',  'prix' => 310000, 'colors' => ['Noir mat']],
            ['name' => 'Solar Eco Drive',       'brand' => 'TechWear',   'prix' => 75000,  'colors' => ['Argent', 'Noir']],
            ['name' => 'Perpetuel Calendar',    'brand' => 'Luminel',    'prix' => 520000, 'colors' => ['Or blanc', 'Platine']],
        ];

        foreach ($montres as $data) {
            $product = Product::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'        => $data['name'],
                    'brand'       => $data['brand'],
                    'description' => 'Montre ' . $data['brand'] . ' — ' . $data['name'] . '. Une pièce d\'exception alliant savoir-faire horloger et élégance contemporaine.',
                    'prix'        => $data['prix'],
                    'category'    => 'watches',
                    'is_active'   => true,
                ]
            );

            foreach ($data['colors'] as $color) {
                ProductVariant::firstOrCreate(
                    ['product_id' => $product->id, 'color' => $color],
                    ['stock_quantity' => rand(5, 30)]
                );
            }
        }

        // ===== 20 LUNETTES =====
        $lunettes = [
            ['name' => 'Aviator Classic Gold',   'brand' => 'VisionLux',  'prix' => 45000,  'colors' => ['Or', 'Argent']],
            ['name' => 'Wayfarer Urban Black',   'brand' => 'StreetView', 'prix' => 35000,  'colors' => ['Noir', 'Écaille']],
            ['name' => 'Round Vintage Copper',   'brand' => 'RetroSight', 'prix' => 42000,  'colors' => ['Cuivre', 'Argent']],
            ['name' => 'Cat Eye Glam',           'brand' => 'FemmeVue',   'prix' => 38000,  'colors' => ['Noir', 'Léopard', 'Rouge']],
            ['name' => 'Sport Shield UV400',     'brand' => 'ActiveLens', 'prix' => 28000,  'colors' => ['Noir', 'Blanc', 'Bleu']],
            ['name' => 'Oversized Square',       'brand' => 'FemmeVue',   'prix' => 52000,  'colors' => ['Écaille', 'Noir', 'Nude']],
            ['name' => 'Hexagonal Titanium',     'brand' => 'VisionLux',  'prix' => 68000,  'colors' => ['Titane', 'Or rose']],
            ['name' => 'Clubmaster Premium',     'brand' => 'ClassicEye', 'prix' => 47000,  'colors' => ['Or/Noir', 'Argent/Brun']],
            ['name' => 'Miroir Iridescent',      'brand' => 'StreetView', 'prix' => 32000,  'colors' => ['Or miroir', 'Argent miroir', 'Bleu miroir']],
            ['name' => 'Semi-Rimless Elegant',   'brand' => 'ClassicEye', 'prix' => 55000,  'colors' => ['Or', 'Argent']],
            ['name' => 'Wrap Around Sport',      'brand' => 'ActiveLens', 'prix' => 22000,  'colors' => ['Noir', 'Rouge', 'Gris']],
            ['name' => 'Butterfly Crystal',      'brand' => 'FemmeVue',   'prix' => 59000,  'colors' => ['Rose', 'Violet', 'Cristal']],
            ['name' => 'Rectangle Executive',    'brand' => 'VisionLux',  'prix' => 48000,  'colors' => ['Noir', 'Brun', 'Gunmetal']],
            ['name' => 'Clip-On Magnetic',       'brand' => 'SmartSight', 'prix' => 31000,  'colors' => ['Noir', 'Gris']],
            ['name' => 'Panto Bohème',           'brand' => 'RetroSight', 'prix' => 39000,  'colors' => ['Écaille', 'Vert', 'Orange']],
            ['name' => 'Pilot XL Pro',           'brand' => 'ActiveLens', 'prix' => 26000,  'colors' => ['Noir', 'Doré', 'Cuivre']],
            ['name' => 'Shield One Piece',       'brand' => 'StreetView', 'prix' => 43000,  'colors' => ['Noir', 'Blanc', 'Rouge']],
            ['name' => 'Diamant Cut Luxury',     'brand' => 'VisionLux',  'prix' => 89000,  'colors' => ['Or 24k', 'Or rose']],
            ['name' => 'Kids Collection Safe',   'brand' => 'SmartSight', 'prix' => 18000,  'colors' => ['Bleu', 'Rose', 'Vert', 'Jaune']],
            ['name' => 'Photochromic Transition','brand' => 'SmartSight', 'prix' => 55000,  'colors' => ['Noir', 'Brun']],
        ];

        foreach ($lunettes as $data) {
            $product = Product::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'        => $data['name'],
                    'brand'       => $data['brand'],
                    'description' => 'Lunettes ' . $data['brand'] . ' — ' . $data['name'] . '. Style, protection et confort pour sublimer votre regard au quotidien.',
                    'prix'        => $data['prix'],
                    'category'    => 'glasses',
                    'is_active'   => true,
                ]
            );

            foreach ($data['colors'] as $color) {
                ProductVariant::firstOrCreate(
                    ['product_id' => $product->id, 'color' => $color],
                    ['stock_quantity' => rand(5, 50)]
                );
            }
        }

        $this->command->info('✓ 2 comptes créés (client + admin)');
        $this->command->info('✓ 20 montres créées avec variantes');
        $this->command->info('✓ 20 lunettes créées avec variantes');
    }
}
