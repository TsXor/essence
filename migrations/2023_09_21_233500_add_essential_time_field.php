<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if (!$schema->hasColumn('discussions', 'last_set_essential_at')) {
            $schema->table('users', function (Blueprint $table) use ($schema) {
                $table->dateTime('last_set_essential_at')->index('last_set_essential_at_dbidx');
            });
        }
    },
    'down' => function (Builder $schema) {
        $schema->table('discussions', function (Blueprint $table) use ($schema) {
            $table->dropColumn('last_set_essential_at');
        });
    }
];
