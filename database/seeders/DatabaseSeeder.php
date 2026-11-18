<?php
namespace Database\Seeders;
use App\Models\{User, Vendor, Category, Food, Hostel, Setting};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $pw = 'password';
        User::create(['name' => 'System Admin', 'email' => 'admin@nakawafood.ug', 'phone' => '0700000000', 'password' => $pw, 'role' => 'admin']);
        User::create(['name' => 'Demo Student', 'email' => 'student@nakawafood.ug', 'phone' => '0700000001', 'password' => $pw, 'role' => 'student']);
        foreach (['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Drinks'] as $c) Category::create(['name' => $c, 'slug' => Str::slug($c)]);
        foreach (['Ideal Classic', 'Ideal Platinum', 'Ideal Annex', 'Akamwesi Hostel', 'Biko Hostel', 'Ideal Diamond Hostel', 'Samuel Courts', 'Esiteri House', 'Dofra Hostel', 'Laxy Courts', 'Betsam Hostel', 'Valley Courts Hostel'] as $h)
            Hostel::create(['name' => $h, 'delivery_point' => 'Main gate / reception', 'landmark' => 'Nakawa, near MUBS', 'status' => 'verified']);
        foreach (['site_name' => 'Nakawa Food Connect', 'delivery_fee' => '2000', 'service_radius' => '2', 'contact_phone' => '+256 700 000 000', 'contact_email' => 'hello@nakawafood.ug'] as $k => $v) Setting::put($k, $v);
        $rest = [['Mr.Hungry', 'images/4.jpeg', 'Burgers, fries and quick bites.'], ['Fundas', 'images/11.jpeg', 'Home-style Ugandan meals.'], ['Shaka Zulu Restaurant', 'images/18.jpeg', 'Grills, platters and more.'],
            ['Hot Wonders', 'images/10.jpeg', 'Crispy chicken and chips.'], ['MUBS Dining', 'images/13.jpeg', 'Campus favourites daily.'], ['Shalom Restaurant', 'images/3.jpeg', 'Fresh lunch and dinner plates.'], ["Yuminy's Restaurant", 'images/5.jpeg', 'Pizza, snacks and juices.']];
        $vs = [];
        foreach ($rest as $i => [$n, $img, $desc]) {
            $u = User::create(['name' => $n.' Manager', 'email' => 'vendor'.($i + 1).'@nakawafood.ug', 'phone' => '07000001'.sprintf('%02d', $i), 'password' => $pw, 'role' => 'vendor']);
            $vs[] = Vendor::create(['user_id' => $u->id, 'name' => $n, 'slug' => Str::slug($n), 'description' => $desc, 'location' => 'Nakawa, near MUBS', 'phone' => $u->phone, 'image' => $img, 'service_areas' => 'All verified hostels within 2 km', 'status' => 'approved']);
        }
        $cat = Category::pluck('id', 'name');
        $menu = [['Full English Breakfast', 'Breakfast', 15000, '7'], ['Breakfast Plate', 'Breakfast', 12000, '6'], ['Avocado & Egg Plate', 'Breakfast', 10000, 'breakfast_1'], ['Rolex', 'Breakfast', 4000, 'rolex'], ['Chicken Rolex', 'Breakfast', 6000, 'lolex_2'],
            ['Matooke & Beef Stew', 'Lunch', 12000, '13'], ['Fish & Matooke', 'Lunch', 18000, '14'], ['Pilau Platter', 'Lunch', 15000, '2'], ['Rice, Chicken & Veg', 'Lunch', 14000, '3'], ['Fried Fish & Chips', 'Lunch', 20000, '11'], ['Beans & Posho Bowl', 'Lunch', 8000, '20'], ['Mixed Grill & Wraps', 'Lunch', 16000, '12'],
            ['Chicken & Chips', 'Dinner', 16000, '10'], ['Roast Chicken & Chips', 'Dinner', 18000, '9'], ['Grilled Platter', 'Dinner', 25000, '18'], ['Rice, Greens & Chips', 'Dinner', 13000, '8'],
            ['Beef Burger', 'Snacks', 12000, '1'], ['Burger & Fries Combo', 'Snacks', 15000, '4'], ['Pizza', 'Snacks', 25000, '5'], ['Grilled Plantain & Fish', 'Snacks', 9000, '15'], ['Chapati Wrap', 'Snacks', 5000, 'lolex_3'],
            ['Passion Juice', 'Drinks', 4000, '1.1'], ['Orange Juice', 'Drinks', 3000, '1.2'], ['Fresh Fruit Juice', 'Drinks', 3000, '1.3'], ['Smoothie Mix', 'Drinks', 5000, '1.4'], ['Cocktail Juices', 'Drinks', 6000, '1.5'], ['Watermelon Juice', 'Drinks', 4000, '1.6'], ['Fresh Yoghurt', 'Drinks', 3000, '1.8']];
        foreach ($menu as $i => [$n, $c, $p, $img]) Food::create(['vendor_id' => $vs[$i % 7]->id, 'category_id' => $cat[$c], 'name' => $n, 'price' => $p, 'image' => "images/$img.jpeg", 'description' => "Freshly prepared $n, served hot."]);
        Food::where('image', 'images/1.2.jpeg')->update(['image' => 'images/1.2.jpg']);
    }
}
