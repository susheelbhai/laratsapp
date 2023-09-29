<?php

namespace Susheelbhai\WhatsApp\Commands;

use Illuminate\Console\Command;

class update_env extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:update_env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To add env variable in .env file';

    /**
     * Execute the console command.
     */

    public $env_values = array(
         'KING_END_POINT' => '',
         'KING_DIGITAL_TOKEN' => '',
         'KING_DIGITAL_iNSTANCE' => '',

    );

    public function handle()
    {

        $this->setEnvironmentValue($this->env_values);
    }

    public function setEnvironmentValue(array $values)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            $str .= "\n\n"; // In case the searched variable is in the last line without \n
            foreach ($values as $envKey => $envValue) {

                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        $this->line("Environment Variable added");
        return true;
    }

}
