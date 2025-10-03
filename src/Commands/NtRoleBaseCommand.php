<?php

namespace Netizens\RB\Commands;

use Illuminate\Console\Command;

class NtRoleBaseCommand extends Command
{
    public $signature = 'cmd-ntrolebase';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
