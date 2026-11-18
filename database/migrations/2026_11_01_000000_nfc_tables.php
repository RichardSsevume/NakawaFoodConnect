<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Nakawa Food Connect tables.
 * Every step is guarded (hasColumn / hasTable) so the migration can be safely
 * re-run on MySQL even after an earlier half-finished attempt (MySQL cannot
 * roll back table changes, which used to cause "Duplicate column 'phone'").
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            if (!Schema::hasColumn('users', 'phone')) {
                $t->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'role')) {
                $t->string('role')->default('student');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $t->string('status')->default('active');
            }
        });

        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('name');
                $t->string('slug')->unique();
                $t->text('description')->nullable();
                $t->string('location')->nullable();
                $t->string('phone')->nullable();
                $t->string('image')->default('images/3.jpeg');
                $t->string('hours')->default('8:00 AM - 9:00 PM');
                $t->string('service_areas')->nullable();
                $t->string('status')->default('pending');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('slug')->unique();
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('foods')) {
            Schema::create('foods', function (Blueprint $t) {
                $t->id();
                $t->foreignId('vendor_id')->constrained()->cascadeOnDelete();
                $t->foreignId('category_id')->constrained();
                $t->string('name');
                $t->text('description')->nullable();
                $t->unsignedInteger('price');
                $t->string('image')->default('images/3.jpeg');
                $t->boolean('available')->default(true);
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('hostels')) {
            Schema::create('hostels', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('delivery_point')->default('Main gate');
                $t->string('landmark')->nullable();
                $t->string('status')->default('verified');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $t) {
                $t->id();
                $t->string('code')->unique();
                $t->foreignId('student_id')->constrained('users');
                $t->foreignId('vendor_id')->constrained();
                $t->foreignId('hostel_id')->constrained();
                $t->string('delivery_note')->nullable();
                $t->string('payment_method');
                $t->string('payment_ref')->nullable();
                $t->string('payment_status')->default('unpaid');
                $t->unsignedInteger('subtotal');
                $t->unsignedInteger('delivery_fee');
                $t->unsignedInteger('total');
                $t->string('status')->default('pending');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $t) {
                $t->id();
                $t->foreignId('order_id')->constrained()->cascadeOnDelete();
                $t->foreignId('food_id')->nullable();
                $t->string('name');
                $t->unsignedInteger('price');
                $t->unsignedInteger('qty');
            });
        }

        if (!Schema::hasTable('order_histories')) {
            Schema::create('order_histories', function (Blueprint $t) {
                $t->id();
                $t->foreignId('order_id')->constrained()->cascadeOnDelete();
                $t->foreignId('user_id')->nullable();
                $t->string('status');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('notices')) {
            Schema::create('notices', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('message');
                $t->boolean('seen')->default(false);
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('email');
                $t->text('message');
                $t->timestamps();
            });
        }

        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $t) {
                $t->string('key')->primary();
                $t->string('value')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ([
            'settings', 'contact_messages', 'notices', 'order_histories', 'order_items',
            'orders', 'hostels', 'foods', 'categories', 'vendors',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::table('users', function (Blueprint $t) {
            foreach (['phone', 'role', 'status'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $t->dropColumn($col);
                }
            }
        });
    }
};
