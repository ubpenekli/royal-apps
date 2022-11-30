<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Qtests;

class CreateAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating a new author for q-tests API.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $first_name = $this->ask(__('Type author first name'));
        $last_name = $this->ask(__('Type author last name'));
        $birthday = $this->ask(__('Type author birthday (dd.mm.yyyy)'));
        $gender = $this->ask(__('Male (m) or female (f)'));
        $place_of_birth = $this->ask(__('Type author\'s place of birth'));
        $biography = $this->ask(__('Type author\'s biography'));

        $author = (object) [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birthday' => $birthday,
            'gender' => $gender,
            'place_of_birth' => $place_of_birth,
            'biography' => $biography
        ];

        $service = new Qtests();
        $tokenResponse = $service->getToken('ahsoka.tano@q.agency', 'Kryze4President');
        $service->setToken($tokenResponse->token->token_key);
        $response = $service->storeAuthor($author);
        $this->info($response->message);
        return $response->success ? Command::SUCCESS : Command::FAILURE;
    }
}
