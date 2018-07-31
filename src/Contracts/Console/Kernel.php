<?php

namespace Kehuanhuan\Contracts\Console;

interface Kernel
{
    public function handle($input, $output = null);
}
