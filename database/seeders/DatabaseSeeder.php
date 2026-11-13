<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin NusaStore',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'phone' => '081200000001',
                'address' => 'Jl. Sudirman No. 10, Jakarta Pusat',
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => 'password',
                'role' => User::ROLE_CUSTOMER,
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 45, Bandung, Jawa Barat',
            ]
        );

        $categoryMap = collect([
            [
                'name' => 'Elektronik & Gadget',
                'slug' => 'elektronik',
                'description' => 'Laptop, smartphone, audio, dan perangkat produktivitas harian.',
            ],
            [
                'name' => 'Fashion & Pakaian',
                'slug' => 'fashion',
                'description' => 'Kemeja, kaos katun, sepatu casual, dan fashion modern.',
            ],
            [
                'name' => 'Kebutuhan Rumah Tangga',
                'slug' => 'rumah-tangga',
                'description' => 'Tissue wajah, lampu meja LED, dan perlengkapan rumah.',
            ],
            [
                'name' => 'Aksesoris & Tas',
                'slug' => 'aksesoris',
                'description' => 'Jam tangan kulit, tas ransel laptop tahan air, dan aksesoris gaya.',
            ],
            [
                'name' => 'Olahraga & Aktivitas',
                'slug' => 'olahraga',
                'description' => 'Tumbler stainless, botol minum vacuum, dan perlengkapan aktif.',
            ],
        ])->mapWithKeys(function (array $cat) {
            $model = Category::updateOrCreate(['slug' => $cat['slug']], $cat);

            return [$cat['slug'] => $model];
        });

        $products = [
            [
                'category' => 'elektronik',
                'name' => 'Laptop Ultrabook 14 Inch Core i7 Slim',
                'price' => 12899000,
                'stock' => 9,
                'image' => 'images/products/laptop.jpg',
                'description' => 'Laptop ultra-tipis dengan prosesor Intel Core i7 generasi terbaru, RAM 16GB LPDDR5, SSD 512GB NVMe berkecepatan tinggi, dan layar 14 inci IPS Full HD sRGB 100% dengan bezel tipis. Daya tahan baterai hingga 14 jam kerja harian.',
            ],
            [
                'category' => 'elektronik',
                'name' => 'Smartphone Flagship 5G 256GB AMOLED',
                'price' => 7499000,
                'stock' => 15,
                'image' => 'images/products/handphone.jpg',
                'description' => 'Smartphone flagship layar 6.7 inci Dynamic AMOLED 120Hz dengan kamera utama 108MP OIS, perekaman video 4K HDR, baterai 5000mAh dengan Fast Charging 67W, serta konektivitas 5G super cepat.',
            ],
            [
                'category' => 'rumah-tangga',
                'name' => 'Tissue Wajah Premium 3-Ply 250 Sheets',
                'price' => 18500,
                'stock' => 150,
                'image' => 'images/products/tissue.jpg',
                'description' => 'Tissue wajah ultra lembut 3 lapis (3-Ply) dibuat dari 100% serat alami berkualitas murni (Virgin Pulp). Berdaya serap tinggi, higienis, bebas pemutih berbahaya, dan sangat aman untuk kulit sensitif maupun bayi.',
            ],
            [
                'category' => 'elektronik',
                'name' => 'Mechanical Keyboard Wireless 75% RGB',
                'price' => 899000,
                'stock' => 18,
                'image' => 'images/products/keyboard.jpg',
                'description' => 'Keyboard mekanikal ringkas layout 75% dengan tactile hot-swappable switch, koneksi tri-mode (Bluetooth 5.0, 2.4GHz Wireless & Kabel Type-C), keycaps PBT tahan pudar, dan baterai tahan hingga 120 jam.',
            ],
            [
                'category' => 'elektronik',
                'name' => 'Headphone ANC Studio Pro Wireless',
                'price' => 1450000,
                'stock' => 12,
                'image' => 'images/products/headphone.jpg',
                'description' => 'Headphone over-ear nirkabel dengan Active Noise Cancelling (ANC) hibrida, driver neodymium 40mm beresolusi tinggi, bantalan telinga busa memori nyaman, serta mikrofon jernih untuk panggilan video.',
            ],
            [
                'category' => 'fashion',
                'name' => 'Kemeja Casual Oxford Katun Pria',
                'price' => 279000,
                'stock' => 30,
                'image' => 'images/products/kemeja.jpg',
                'description' => 'Kemeja lengan panjang bahan 100% katun Oxford premium. Serat kain bernapas (breathable), jahitan rantai rapi kokoh, dan pola regular-fit yang pas untuk santai maupun kantor.',
            ],
            [
                'category' => 'fashion',
                'name' => 'Kaos Polos Cotton Combed 24s Heavyweight',
                'price' => 119000,
                'stock' => 50,
                'image' => 'images/products/kaos.jpg',
                'description' => 'Kaos oblong kasual berbahan 100% katun combed 24s gramasi tebal bertekstur lembut. Adem dipakai sepanjang hari, menyerap keringat dengan baik, dan tidak melar setelah dicuci.',
            ],
            [
                'category' => 'fashion',
                'name' => 'Sepatu Sneakers Streetwear Kasual',
                'price' => 489000,
                'stock' => 20,
                'image' => 'images/products/sepatu.jpg',
                'description' => 'Sepatu sneakers kasual dengan sol karet vulkanisir lentur anti-selip, material atas kanvas breathable, dan insole empuk untuk kenyamanan mobilitas harian.',
            ],
            [
                'category' => 'aksesoris',
                'name' => 'Jam Tangan Pria Chronograph Leather Strap',
                'price' => 625000,
                'stock' => 14,
                'image' => 'images/products/jam-tangan.jpg',
                'description' => 'Jam tangan analog maskulin dengan subdial chronograph aktif, kaca kristal safir tahan gores, tahan air hingga 5 ATM, dan strap kulit asli berkualitas tinggi.',
            ],
            [
                'category' => 'aksesoris',
                'name' => 'Tas Ransel Laptop 16 Inch Water-Repellent',
                'price' => 435000,
                'stock' => 22,
                'image' => 'images/products/tas-ransel.jpg',
                'description' => 'Backpack komuter berkapasitas 25L dengan bahan nilon anti air, kompartemen laptop berlapis bantalan busa tebal hingga ukuran 16 inci, resleting tahan air, dan saku anti-maling.',
            ],
            [
                'category' => 'rumah-tangga',
                'name' => 'Lampu Meja LED Touch Dimmer Minimalis',
                'price' => 215000,
                'stock' => 16,
                'image' => 'images/products/lampu-meja.jpg',
                'description' => 'Lampu meja minimalis fleksibel dengan pengatur tingkat kecerahan sentuh, 3 mode temperatur cahaya (Warm, Natural, Cool White), dan port daya USB Type-C hemat energi.',
            ],
            [
                'category' => 'olahraga',
                'name' => 'Tumbler Stainless Steel Vacuum Insulated 750ml',
                'price' => 175000,
                'stock' => 35,
                'image' => 'images/products/tumbler.jpg',
                'description' => 'Botol minum termos berkapasitas 750ml berbahan Stainless Steel Food Grade 304 berdinding ganda. Mampu menjaga es dingin hingga 24 jam dan air panas hingga 12 jam tanpa embun di luar.',
            ],
        ];

        $seededProducts = [];
        foreach ($products as $item) {
            $slug = Str::slug($item['name']);
            $seededProducts[$slug] = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categoryMap[$item['category']]->id,
                    'name' => $item['name'],
                    'slug' => $slug,
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'image' => $item['image'],
                    'is_active' => true,
                ]
            );
        }

        // Demo sample order
        $laptop = $seededProducts['laptop-ultrabook-14-inch-core-i7-slim'] ?? Product::first();
        if ($laptop) {
            Order::updateOrCreate(
                ['order_number' => 'ORD-20261113-DEMO01'],
                [
                    'user_id' => $customer->id,
                    'total_amount' => $laptop->price,
                    'status' => Order::STATUS_COMPLETED,
                    'payment_method' => 'ewallet',
                    'payment_status' => Order::PAYMENT_PAID,
                    'shipping_name' => $customer->name,
                    'shipping_phone' => $customer->phone,
                    'shipping_address' => $customer->address,
                    'notes' => 'Pesanan sampel demo portofolio.',
                    'paid_at' => now()->subDay(),
                ]
            );

            $order = Order::where('order_number', 'ORD-20261113-DEMO01')->first();
            if ($order && ! $order->items()->exists()) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $laptop->id,
                    'product_name' => $laptop->name,
                    'price' => $laptop->price,
                    'quantity' => 1,
                    'subtotal' => $laptop->price,
                ]);
            }
        }
    }
}
