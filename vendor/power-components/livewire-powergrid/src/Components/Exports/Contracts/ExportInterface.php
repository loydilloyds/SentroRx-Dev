<?php

namespace PowerComponents\LivewirePowerGrid\Components\Exports\Contracts;

use PowerComponents\LivewirePowerGrid\{Components\SetUp\Exportable};
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ExportInterface
{
    public function download(array $exportOptions): BinaryFileResponse;

    public function build(Exportable|array $exportOptions): void;
}
