<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUtmsAndUtmhostsTables extends Migration
{
    protected $utms = [
        ['name' => 'utm_source'],
        ['name' => 'utm_medium'],
        ['name' => 'utm_campaign'],
        ['name' => 'utm_content'],
        ['name' => 'utm_term'],
        ['name' => 'utm_lp'],
        ['name' => 'utm_pr'],
        ['name' => 'utm_reflink'],
    ];

    protected $hosts = [
        'https://www.yandex.ru' => [
            'utm_source'  => 'SA',
            'utm_medium'   => 'ya_seo',
        ],
        'https://www.google.ru' => [
            'utm_source'  => 'SA',
            'utm_medium'   => 'g_seo',
        ],
        'https://vk.com' => [
            'utm_source'  => 'SM',
            'utm_medium'   => 'sm_vk',
        ],
        'https://www.facebook.com' => [
            'utm_source'  => 'SM',
            'utm_medium'   => 'sm_fb',
        ],
        'https://www.instagram.com' => [
            'utm_source' => 'SM',
            'utm_medium'   => 'sm_insta',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('utm_hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('utm_utm_host', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('utm_id');
            $table->integer('utm_host_id');
            $table->string('value');
        });


        DB::table('utms')->insert($this->utms);

        foreach( $this->hosts as $host => $value ) {
            $host_id = DB::table('utm_hosts')->insertGetId([
                'url' => $host,
            ]);

            foreach( $value as $utm => $data ) {
                $utm_id = DB::table('utms')->where('name', $utm)->value('id');
                DB::table('utm_utm_host')->insert([
                    'utm_host_id' => $host_id,
                    'utm_id'  => $utm_id,
                    'value'   => $data,
                ]);
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('utms');
        Schema::drop('utm_hosts');
        Schema::drop('utm_utm_host');
    }
}
