<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Включить поддержку внешних ключей в SQLite
        DB::statement('PRAGMA foreign_keys = ON;');

        // Создать таблицу gen_menu
        if (!Schema::hasTable('gen_menu')) {
            Schema::create('gen_menu', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 200)->default('menu');
                $table->unsignedBigInteger('parent_id')->default(0)->nullable();
                $table->string('lang_id', 2)->default('ru');
                $table->string('menu_type', 500)->default('menu');
                $table->string('method', 20)->nullable();
                $table->unsignedTinyInteger('user_type')->nullable();
                $table->timestamps();

                $table->index('lang_id');
                $table->index('menu_type');
                $table->index('parent_id');
                $table->index('user_type');
            });
        }

        // Создать таблицу gen_menu_order
        if (!Schema::hasTable('gen_menu_order')) {
            Schema::create('gen_menu_order', function (Blueprint $table): void {
                $table->unsignedBigInteger('parent_id')->default(0);
                $table->unsignedBigInteger('menu_id')->default(0);
                $table->unsignedBigInteger('position')->default(0);

                $table->index('menu_id');
                $table->index('parent_id');
            });
        }

        // Создать таблицу gen_message
        if (!Schema::hasTable('gen_message')) {
            Schema::create('gen_message', function (Blueprint $table): void {
                $table->id();
                $table->string('title', 200)->default('');
                $table->text('annotation')->nullable();
                $table->dateTime('create_date')->default('1970-01-01 00:00:00');
                $table->unsignedBigInteger('user_id')->default(1);
                $table->string('lang_id', 2)->default('ru');
                $table->unsignedBigInteger('public')->default(0)->nullable();
                $table->unsignedTinyInteger('user_type')->nullable();
                $table->timestamps();

                $table->index('lang_id');
                $table->index('user_id');
                $table->index('user_type');
            });
        }

        // Создать таблицу gen_message_text
        if (!Schema::hasTable('gen_message_text')) {
            Schema::create('gen_message_text', function (Blueprint $table): void {
                $table->unsignedBigInteger('message_id')->default(0);
                $table->text('message')->nullable();

                $table->index('message_id');
            });
        }

        // Создать таблицу gen_mixed_menu_mess
        if (!Schema::hasTable('gen_mixed_menu_mess')) {
            Schema::create('gen_mixed_menu_mess', function (Blueprint $table): void {
                $table->unsignedBigInteger('menu_id')->default(0);
                $table->unsignedBigInteger('message_id')->default(0);

                $table->index('menu_id');
                $table->index('message_id');
            });
        }

        // Создать таблицу gen_mixed_name_lang
        if (!Schema::hasTable('gen_mixed_name_lang')) {
            Schema::create('gen_mixed_name_lang', function (Blueprint $table): void {
                $table->unsignedBigInteger('name_id');
                $table->unsignedBigInteger('name_lang_id')->unique();

                $table->index('name_id');
            });
        }

        // Создать таблицу gen_mixed_surname_lang
        if (!Schema::hasTable('gen_mixed_surname_lang')) {
            Schema::create('gen_mixed_surname_lang', function (Blueprint $table): void {
                $table->unsignedBigInteger('surname_id');
                $table->unsignedBigInteger('surname_lang_id');

                $table->index('surname_id');
                $table->index('surname_lang_id');
            });
        }

        // Создать таблицу gen_name
        if (!Schema::hasTable('gen_name')) {
            Schema::create('gen_name', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('user_id');

                $table->unique('id');
                $table->index('user_id');
            });
        }

        // Создать таблицу gen_name_lang
        if (!Schema::hasTable('gen_name_lang')) {
            Schema::create('gen_name_lang', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('male_id')->nullable();
                $table->string('fname', 45)->nullable();
                $table->string('male_sname', 45)->nullable();
                $table->string('female_sname', 45)->nullable();
                $table->string('lang', 3);

                $table->unique('fname');
                $table->unique('id');
                $table->index('male_id');
            });
        }

        // Создать таблицу gen_person
        if (!Schema::hasTable('gen_person')) {
            Schema::create('gen_person', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('fname_id');
                $table->unsignedBigInteger('sname_id')->nullable();
                $table->unsignedBigInteger('surname_id')->nullable();
                $table->unsignedBigInteger('bsurname_id')->nullable();
                $table->dateTime('bdate')->nullable();
                $table->dateTime('ddate')->nullable();
                $table->unsignedBigInteger('user_id');

                $table->index('bsurname_id');
                $table->index('fname_id');
                $table->index('sname_id');
                $table->index('surname_id');
                $table->index('user_id');
            });
        }

        // Создать таблицу gen_person_info_lang
        if (!Schema::hasTable('gen_person_info_lang')) {
            Schema::create('gen_person_info_lang', function (Blueprint $table): void {
                $table->unsignedBigInteger('person_id');
                $table->text('info')->nullable();
                $table->string('lang', 3);
            });
        }

        // Создать таблицу gen_relation
        if (!Schema::hasTable('gen_relation')) {
            Schema::create('gen_relation', function (Blueprint $table): void {
                $table->unsignedBigInteger('pid1')->nullable();
                $table->unsignedBigInteger('pid2')->nullable();
                $table->unsignedBigInteger('relation_type_id')->nullable();

                $table->index('pid1');
                $table->index('pid2');
                $table->index('relation_type_id');
            });
        }

        // Создать таблицу gen_surname
        if (!Schema::hasTable('gen_surname')) {
            Schema::create('gen_surname', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('user_id');

                $table->unique('id');
                $table->index('user_id');
            });
        }

        // Создать таблицу gen_surname_lang
        if (!Schema::hasTable('gen_surname_lang')) {
            Schema::create('gen_surname_lang', function (Blueprint $table): void {
                $table->id();
                $table->string('male_surname', 45)->nullable();
                $table->string('female_surname', 45)->nullable();
                $table->string('lang', 3);

                $table->unique('female_surname');
                $table->unique('id');
                $table->unique('male_surname');
            });
        }

        // Создать таблицу gen_user
        if (!Schema::hasTable('gen_user')) {
            Schema::create('gen_user', function (Blueprint $table): void {
                $table->id();
                $table->string('login', 45)->default('');
                $table->string('password', 45)->default('');
                $table->string('fname', 45);
                $table->string('sname', 45);
                $table->string('surname', 45);
                $table->string('email', 100);
                $table->dateTime('create_date')->default('1970-01-01 00:00:00');
                $table->unsignedBigInteger('user_type');
                $table->unsignedBigInteger('active')->default(1)->nullable();

                $table->unique('login');
            });
        }

        // Создать таблицу gen_user_right
        if (!Schema::hasTable('gen_user_right')) {
            Schema::create('gen_user_right', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 45);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Удалить таблицы в обратном порядке для соблюдения зависимостей
        Schema::dropIfExists('gen_user_right');
        Schema::dropIfExists('gen_user');
        Schema::dropIfExists('gen_surname_lang');
        Schema::dropIfExists('gen_surname');
        Schema::dropIfExists('gen_person_info_lang');
        Schema::dropIfExists('gen_person');
        Schema::dropIfExists('gen_name_lang');
        Schema::dropIfExists('gen_name');
        Schema::dropIfExists('gen_mixed_surname_lang');
        Schema::dropIfExists('gen_mixed_name_lang');
        Schema::dropIfExists('gen_mixed_menu_mess');
        Schema::dropIfExists('gen_message_text');
        Schema::dropIfExists('gen_message');
        Schema::dropIfExists('gen_menu_order');
        Schema::dropIfExists('gen_menu');
        Schema::dropIfExists('gen_relation');
    }
};
