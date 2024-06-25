<?php

namespace Kenepa\Banner\Commands;

use Illuminate\Console\Command;

class BannerCommand extends Command
{
    public $signature = 'banner';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
