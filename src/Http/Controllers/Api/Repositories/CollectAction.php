<?php

/*
 * This file is part of Laravel Paket.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Laravel\Paket\Http\Controllers\Api\Repositories;

use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use MCStreetguy\ComposerParser\Factory as ComposerParser;

final class CollectAction
{
    public function __invoke(): ResponsableContract
    {
        $repositories = $this->getRepositories();

        return new CollectResponse($repositories);
    }

    private function getRepositories(): array
    {
        $jsonFile = ComposerParser::parseComposerJson(base_path('composer.json'));

        $repositories = $jsonFile->getRepositories();
        $output = [];

        foreach ($repositories as $repository) {
            $output[] = [
                'type' => $repository->getType(),
                'url' => $repository->getUrl(),
                // TODO: Add options & package
//                'options' => $repository->getOptions(),
//                'package' => $repository->getPackage(),
            ];
        }

        return $output;
    }
}
